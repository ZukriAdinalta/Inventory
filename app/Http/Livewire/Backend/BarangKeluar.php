<?php

namespace App\Http\Livewire\Backend;

use App\Models\BarangKeluar as ModelsBarangKeluar;
use App\Models\Inventaris;
use App\Models\JenisBarang;
use App\Models\NamaBarang;
use Livewire\WithPagination;
use Livewire\Component;

class BarangKeluar extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '', $perpage = 10;
    public $create = false, $update = false, $selectInven;
    public $id_keluar, $inven_id, $id_inven, $k_inven, $nambar, $jenbar, $jumlah_keluar, $total, $tgl_keluar;

    protected $rules = [
        'inven_id'       => 'required',
        'jumlah_keluar'  => 'required',
        'tgl_keluar'     => 'required',
    ];
    protected $validationAttributes = [
        'inven_id'       => 'Kode Inventaris',
        'jumlah_keluar'  => 'Barang Keluar',
        'tgl_keluar'     => 'Tanggal',
    ];
    protected $messages = [
        'required'      => ':attribute wajib diisi',
    ];

    public function updated($fild)
    {
        $data = Inventaris::find($this->inven_id);
        $BM = ModelsBarangKeluar::find($this->id_keluar);
        if ($this->inven_id && $this->create == true) {
            $namabarang = NamaBarang::find($data->nambar_id);
            $jenisbarang = JenisBarang::find($data->jenbar_id);
            $this->nambar = $namabarang->nambar;
            $this->jenbar = $jenisbarang->jenbar;
            if ($this->jumlah_keluar > $data->jumlah) {
                $this->total =  0;
            } elseif ($this->jumlah_keluar == null) {
                $this->total = $data->jumlah - 0;
            } elseif ($this->jumlah_keluar) {
                $this->total = $data->jumlah - $this->jumlah_keluar;
            } else {
                $this->addError('jumlah_keluar', 'Barang keluar minimal 1 barang.');
            }
        }
        if ($this->update == true && $this->jumlah_keluar != $BM->jumlah_keluar) {
            if ($this->jumlah_keluar > $data->jumlah + $BM->jumlah_keluar) {
                $this->total =  0;
            } elseif ($this->jumlah_keluar == '') {
                $this->total = $data->jumlah + 0;
            } elseif ($this->jumlah_keluar != $BM->jumlah_keluar) {
                $this->total = $data->jumlah + $BM->jumlah_keluar - $this->jumlah_keluar;
            }
        }

        $this->validateOnly($fild);
    }

    public function Create()
    {
        $this->create = true;
        $this->update = false;
    }
    public function Close()
    {
        $this->create = false;
        $this->update = false;
        $this->inven_id = '';
        $this->nambar = '';
        $this->tgl_keluar = '';
        $this->jumlah_keluar = '';
        $this->jenbar = '';
        $this->total = '';
        $this->resetErrorBag();
    }
    public function Simpan()
    {
        $validatinData = $this->validate();
        $data = Inventaris::find($this->inven_id);
        if ($this->jumlah_keluar > $data->jumlah) {
            return  $this->addError('jumlah_keluar', 'Barang keluar tidak boleh lebih besar dari stok barang.');
        } elseif ($this->jumlah_keluar >= 1) {
            $validatinData['jenbar'] = $this->jenbar;
            $validatinData['nambar'] = $this->nambar;
            $validatinData['user_id'] = auth()->user()->id;
            ModelsBarangKeluar::create($validatinData);
            Inventaris::where('id', $this->inven_id)->update([
                'jumlah' => $this->total
            ]);
            $this->Close();
            session()->flash('pesan', 'Data berhasil disimpan');
            $this->emit('alert_remove');
        } else {
            $this->addError('jumlah_keluar', 'Barang keluar minimal 1 barang');
        }
    }
    public function Edit($id)
    {
        $this->total = '';
        $this->create = false;
        $this->update = true;
        $data = ModelsBarangKeluar::find($id);
        $this->id_keluar = $data->id;
        $this->inven_id = $data->inven_id;
        $this->jenbar = $data->jenbar;
        $this->nambar = $data->nambar;
        $this->tgl_keluar = $data->tgl_keluar;
        $this->jumlah_keluar = $data->jumlah_keluar;
        $this->resetErrorBag();
    }

    public function Update($id)
    {
        $validatinData = $this->validate();
        $BM = ModelsBarangKeluar::find($id);
        $data = Inventaris::find($this->inven_id);
        if ($this->jumlah_keluar > $data->jumlah + $BM->jumlah_keluar) {
            return  $this->addError('jumlah_keluar', 'Barang keluar tidak boleh lebih besar dari stok barang.');
        } elseif ($this->jumlah_keluar >= 1) {
            $validatinData['jenbar'] = $this->jenbar;
            $validatinData['nambar'] = $this->nambar;
            $validatinData['user_id'] = auth()->user()->id;
            ModelsBarangKeluar::where('id', $id)->update($validatinData);
            if ($this->jumlah_keluar != $BM->jumlah_keluar) {
                Inventaris::where('id', $this->inven_id)->update([
                    'jumlah' => $this->total
                ]);
            }
            $this->Close();
            session()->flash('pesan', 'Data berhasil diedit');
            $this->emit('alert_remove');
        } else {
            $this->addError('jumlah_keluar', 'Barang keluar minimal 1 barang');
        }
    }

    public function DeleteData($id)
    {
        $this->create = false;
        $this->update = false;
        $data = ModelsBarangKeluar::find($id);
        $this->id_keluar = $data->id;
        $this->id_inven = $data->inven_id;
        $this->jenbar = $data->jenbar;
        $this->nambar = $data->nambar;
        $this->tgl_keluar = $data->tgl_keluar;
        $this->jumlah_keluar = $data->jumlah_keluar;
        $BM = ModelsBarangKeluar::find($id)->Inven;
        $this->inven_id = $BM->k_inven;
        $this->total = $BM->jumlah + $data->jumlah_keluar;
    }

    public function Delete($id)
    {
        ModelsBarangKeluar::destroy($id);
        Inventaris::where('id', $this->id_inven)->update([
            'jumlah' => $this->total
        ]);
        session()->flash('hapus', 'Barang Keluar berhasil dihapus stok ' . $this->nambar . ' menjadi ' . $this->total);
        $this->Close();
        $this->emit('alert_remove');
        $this->emit('delete');
    }
    public function render()
    {
        $data = [
            'Inventaris' => Inventaris::all(),
            'BarangKeluar' => ModelsBarangKeluar::with('Inven', 'User')
                ->when($this->selectInven, function ($query) {
                    $query->where('inven_id', $this->selectInven);
                })->when($this->selectInven, function ($query) {
                    $query->where('user_id', $this->selectInven);
                })
                ->search(trim($this->search))->latest()
                ->paginate($this->perpage),
        ];
        return view('livewire.backend.barang-keluar', $data)->extends('layouts.index')->section('content');
    }
}