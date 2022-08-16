<?php

namespace App\Http\Livewire\Backend;

use App\Models\NamaBarang as ModelsNamaBarang;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Component;

class NamaBarang extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '', $perpage = 5;
    public $id_nambar, $k_nambar, $nambar, $update = false;

    protected $rules = [
        'k_nambar'                => 'required',
        'nambar'                  => 'required',
    ];
    protected $validationAttributes = [
        'k_nambar'                => 'Kode Barang',
        'nambar'                  => 'Nama Barang',
    ];

    protected $messages = [
        'required'      => ':attribute wajib diisi',
        'unique'        => ':attribute sudah ada',
    ];
    public function updated($fild)
    {
        $this->validateOnly($fild);
    }

    public function resetForm()
    {
        $this->k_nambar = '';
        $this->nambar = '';
        $this->update = false;
        $this->resetErrorBag();
    }

    public function Simpan()
    {
        $validatinData =  $this->validate();
        $validatinData['nambar'] = Str::title($this->nambar);
        ModelsNamaBarang::create($validatinData);
        $this->resetForm();
        session()->flash('pesan', 'Data berhasil disimpan');
        $this->emit('alert_remove');
    }

    public function Edit($id)
    {
        $this->update = true;
        $data = ModelsNamaBarang::find($id);
        $this->id_nambar = $data->id;
        $this->k_nambar = $data->k_nambar;
        $this->nambar = $data->nambar;
    }

    public function Update($id)
    {
        $data = ModelsNamaBarang::find($id);
        $inven = ModelsNamaBarang::find($id)->Inven;
        if (count($inven) >= 1) {
            session()->flash('hapus', 'Maaf ' . $data->nambar . ' tidak bisa di edit karena telah digunakan di Inventaris.');
            $this->resetform();
        } else {
            // $data = ModelsNamaBarang::find($id);
            // $rules = [
            //     'nambar'   => 'required',
            // ];
            // if ($this->nambar != $data->nambar) {
            //     $rules['nambar'] = 'required|unique:nama_barangs';
            // }
            $validatinData =  $this->validate();
            $validatinData['nambar'] = Str::title($this->nambar);
            ModelsNamaBarang::where('id', $id)->update($validatinData);
            $this->resetform();
            $this->resetErrorBag();
            $this->update = false;
            session()->flash('pesan', 'Data berhasil diedit');
        }
        $this->emit('alert_remove');
    }

    public function Delete($id)
    {
        $inven = ModelsNamaBarang::find($id)->Inven;
        if (count($inven) >= 1) {
            session()->flash('hapus', 'Maaf ' . $this->nambar . ' tidak bisa di hapus karena telah digunakan di Inventaris.');
            $this->resetform();
        } else {
            ModelsNamaBarang::destroy($id);
            $this->resetForm();
            session()->flash('hapus', 'Data berhasil dihapus');
            $this->emit('alert_remove');
        }
        $this->emit('delete');
    }

    public function render()
    {
        $data = [
            'namaBarang' => ModelsNamaBarang::Where('nambar', 'like', '%' . $this->search . '%')->latest()->paginate($this->perpage)
        ];
        return view('livewire.backend.nama-barang', $data)->extends('layouts.index')->section('content');
    }
}