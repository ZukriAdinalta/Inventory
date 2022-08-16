<?php

namespace App\Http\Livewire\Backend;

use App\Models\BarangMasuk as ModelsBarangMasuk;
use App\Models\Inventaris;
use App\Models\JenisBarang;
use App\Models\NamaBarang;
use Livewire\WithPagination;
use Livewire\Component;

class BarangMasuk extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '', $perpage = 10;
    public $create = false, $update = false, $selectInven;
    public $id_masuk, $inven_id, $id_inven, $k_inven, $nambar, $jenbar, $jumlah_masuk, $total, $tgl_masuk;

    protected $rules = [
        'inven_id'  => 'required',
        'jumlah_masuk'  => 'required',
        'tgl_masuk'     => 'required',
    ];
    protected $validationAttributes = [
        'inven_id'      => 'Kode Inventaris',
        'jumlah_masuk'  => 'Barang Masuk',
        'tgl_masuk'     => 'Tanggal',
    ];
    protected $messages = [
        'required'      => ':attribute wajib diisi',
    ];

    public function updated($fild)
    {
        $data = Inventaris::find($this->inven_id);
        $BM = ModelsBarangMasuk::find($this->id_masuk);
        if ($this->inven_id) {
            $namabarang = NamaBarang::find($data->nambar_id);
            $jenisbarang = JenisBarang::find($data->jenbar_id);
            $this->nambar = $namabarang->nambar;
            $this->jenbar = $jenisbarang->jenbar;
            if ($this->jumlah_masuk == null  && $this->create == true) {
                $this->total = $data->jumlah + 0;
            } elseif ($this->jumlah_masuk  && $this->create == true) {
                $this->total = $data->jumlah + $this->jumlah_masuk;
            }
        } else {
            $this->addError('inven_id', 'Kode Inventaris Wajib Dipilih');
        }
        if ($this->update == true && $this->jumlah_masuk != $BM->jumlah_masuk) {
            if ($this->jumlah_masuk == '' && $this->create == false) {
                $this->total = $data->jumlah + 0;
            } elseif ($this->jumlah_masuk != $BM->jumlah_masuk) {
                $this->total = $data->jumlah - $BM->jumlah_masuk + $this->jumlah_masuk;
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
        $this->tgl_masuk = '';
        $this->jumlah_masuk = '';
        $this->jenbar = '';
        $this->total = '';
        $this->resetErrorBag();
    }
    public function Simpan()
    {
        if ($this->jumlah_masuk >= 1) {
            $validatinData = $this->validate();
            $validatinData['jenbar'] = $this->jenbar;
            $validatinData['nambar'] = $this->nambar;
            $validatinData['user_id'] = auth()->user()->id;
            ModelsBarangMasuk::create($validatinData);
            Inventaris::where('id', $this->inven_id)->update([
                'jumlah' => $this->total
            ]);
            $this->Close();
            session()->flash('pesan', 'Data berhasil disimpan');
            $this->emit('alert_remove');
        } else {
            $this->addError('jumlah_masuk', 'Barang Masuk minimal 1 barang');
        }
    }
    public function Edit($id)
    {
        $this->create = false;
        $this->update = true;
        $data = ModelsBarangMasuk::find($id);
        $this->id_masuk = $data->id;
        $this->inven_id = $data->inven_id;
        $this->jenbar = $data->jenbar;
        $this->nambar = $data->nambar;
        $this->tgl_masuk = $data->tgl_masuk;
        $this->jumlah_masuk = $data->jumlah_masuk;
    }

    public function Update($id)
    {
        $BM = ModelsBarangMasuk::find($id);
        if ($this->jumlah_masuk >= 1) {
            $validatinData = $this->validate();
            $validatinData['jenbar'] = $this->jenbar;
            $validatinData['nambar'] = $this->nambar;
            $validatinData['user_id'] = auth()->user()->id;
            ModelsBarangMasuk::where('id', $id)->update($validatinData);
            if ($this->jumlah_masuk != $BM->jumlah_masuk) {
                Inventaris::where('id', $this->inven_id)->update([
                    'jumlah' => $this->total
                ]);
            }
            $this->Close();
            session()->flash('pesan', 'Data berhasil diedit');
            $this->emit('alert_remove');
        } else {
            $this->addError('jumlah_masuk', 'Barang Masuk minimal 1 barang');
        }
    }

    public function DeleteData($id)
    {
        $this->create = false;
        $this->update = false;
        $data = ModelsBarangMasuk::find($id);
        $this->id_masuk = $data->id;
        $this->id_inven = $data->inven_id;
        $this->jenbar = $data->jenbar;
        $this->nambar = $data->nambar;
        $this->tgl_masuk = $data->tgl_masuk;
        $this->jumlah_masuk = $data->jumlah_masuk;
        $BM = ModelsBarangMasuk::find($id)->Inven;
        $this->inven_id = $BM->k_inven;
        $this->total = $BM->jumlah - $data->jumlah_masuk;
    }

    public function Delete($id)
    {
        $data = Inventaris::find($this->id_inven);
        if ($data->jumlah < $this->jumlah_masuk) {
            $this->Close();
            $this->emit('alert_remove');
            $this->emit('delete');
            return session()->flash('hapus', 'Barang masuk telah di digunakan di barang keluar.');
        } else {
            ModelsBarangMasuk::destroy($id);
            Inventaris::where('id', $this->id_inven)->update([
                'jumlah' => $this->total
            ]);
            session()->flash('hapus', 'Data berhasil dihapus stok ' . $this->nambar . ' menjadi ' . $this->total);
            $this->Close();
            $this->emit('alert_remove');
            $this->emit('delete');
        }
    }
    public function render()
    {
        $data = [
            'Inventaris' => Inventaris::all(),
            // 'BarangMasuk' => ModelsBarangMasuk::Where('nambar', 'like', '%' . $this->search . '%')->latest()->paginate($this->perpage)
            'BarangMasuk' => ModelsBarangMasuk::with('Inven', 'User')
                ->when($this->selectInven, function ($query) {
                    $query->where('inven_id', $this->selectInven);
                })
                ->when($this->selectInven, function ($query) {
                    $query->where('user_id', $this->selectInven);
                })
                ->search(trim($this->search))->latest()
                ->paginate($this->perpage),
        ];
        return view('livewire.backend.barang-masuk', $data)->extends('layouts.index')->section('content');
    }
}