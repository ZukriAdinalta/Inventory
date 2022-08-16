<?php

namespace App\Http\Livewire\Backend;

use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Inventaris as ModelsInventaris;
use App\Models\JenisBarang;
use App\Models\NamaBarang;
use Livewire\WithPagination;
use Livewire\Component;

class Inventaris extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '', $perpage = 10;
    public $create = false, $update = false;
    public $id_inven, $jenbar_id, $nambar_id, $k_inven;
    public $selectJenbar = null, $selectNambar = null;
    protected $rules = [
        'jenbar_id'  => 'required',
        'nambar_id'  => 'required',
    ];
    protected $validationAttributes = [
        'jenbar_id' => 'Jenis Barang',
        'nambar_id' => 'Nama Barang',
    ];

    protected $messages = [
        'required'      => ':attribute wajib diisi',
        'unique'        => ':attribute sudah ada',
    ];
    public function Create()
    {
        $this->create = true;
        $this->update = false;
    }
    public function Close()
    {
        $this->create = false;
        $this->update = false;
        $this->jenbar_id = '';
        $this->nambar_id = '';
    }

    public function Simpan()
    {
        $data = ModelsInventaris::latest()->first();
        $Inventaris = ModelsInventaris::all();
        foreach ($Inventaris as $inventaris) {
            if ($this->jenbar_id == $inventaris->jenbar_id && $this->nambar_id == $inventaris->nambar_id) :
                $this->nambar_id = '';
                $this->emit('alert_remove');
                return   session()->flash('hapus', 'Data inventaris ini sudah ada silahkan cek ulang');
            endif;
        }
        $validatinData = $this->validate();
        if (!$data) {
            $validatinData['k_inven'] = 'INV0001';
        } else {
            $kode = preg_replace("/[^0-9\.]/", '', $data->k_inven);
            $validatinData['k_inven'] = 'INV' . sprintf('%04d', $kode + 1);
        }
        $validatinData['user_id'] = auth()->user()->id;
        ModelsInventaris::create($validatinData);
        $this->Close();
        session()->flash('pesan', 'Data berhasil disimpan');
        $this->emit('alert_remove');
    }

    public function Edit($id)
    {
        $this->create = false;
        $this->update = true;
        $data = ModelsInventaris::find($id);
        $this->id_inven  = $data->id;
        $this->jenbar_id = $data->jenbar_id;
        $this->nambar_id = $data->nambar_id;
        $this->k_inven   = $data->k_inven;
    }
    public function Update($id)
    {
        $data = ModelsInventaris::find($id);
        $Inventaris = ModelsInventaris::all();
        $BM = ModelsInventaris::find($id)->BM;
        $BK = ModelsInventaris::find($id)->BK;
        if ($this->jenbar_id != $data->jenbar_id || $this->nambar_id != $data->nambar_id) :
            foreach ($Inventaris as $inventaris) {
                if ($this->jenbar_id == $inventaris->jenbar_id && $this->nambar_id == $inventaris->nambar_id) :
                    $this->Close();
                    $this->emit('alert_remove');
                    return   session()->flash('hapus', 'Data inventaris ini sudah ada silahkan cek ulang');
                endif;
            }
        endif;
        if (count($BM) >= 1 || count($BK) >= 1) {
            session()->flash('hapus', 'Maaf ' . $this->k_inven . ' tidak bisa di edit karena telah digunakan di barang masuk/keluar.');
            $this->Close();
        } else {
            $validatinData = $this->validate();
            $validatinData['user_id'] = auth()->user()->id;
            ModelsInventaris::where('id', $id)->update($validatinData);
            $this->Close();
            session()->flash('pesan', 'Data berhasil disimpan');
        }
        $this->emit('alert_remove');
    }

    public function DeleteData($id)
    {
        $this->create = false;
        $this->update = false;
        $data = ModelsInventaris::find($id);
        $this->id_inven  = $data->id;
        $this->k_inven   = $data->k_inven;
    }

    public function Delete($id)
    {
        $BM = ModelsInventaris::find($id)->BM;
        $BK = ModelsInventaris::find($id)->BK;
        if (count($BM) >= 1 || count($BK) >= 1) {
            session()->flash('hapus', 'Maaf ' . $this->k_inven . ' tidak bisa di edit karena telah digunakan di barang masuk/keluar.');
            $this->Close();
        } else {
            ModelsInventaris::destroy($id);
            $this->Close();
            session()->flash('hapus', 'Data berhasil dihapus');
            $this->emit('alert_remove');
        }
        $this->emit('delete');
    }


    public function render()
    {
        $data = [
            'JenisBarang' => JenisBarang::all(),
            'NamaBarang' => NamaBarang::all(),
            'Inventaris' => ModelsInventaris::with('Jenbar', 'Nambar', 'User')
                ->when($this->selectJenbar, function ($query) {
                    $query->where('jenbar_id', $this->selectJenbar);
                })
                ->when($this->selectNambar, function ($query) {
                    $query->where('nambar_id', $this->selectNambar);
                })
                ->when($this->selectNambar, function ($query) {
                    $query->where('user_id', $this->selectNambar);
                })
                ->search(trim($this->search))->latest()
                ->paginate($this->perpage),
        ];
        return view('livewire.backend.inventaris', $data)->extends('layouts.index')->section('content');
    }
}