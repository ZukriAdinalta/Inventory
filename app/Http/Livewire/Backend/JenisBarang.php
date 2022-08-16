<?php

namespace App\Http\Livewire\Backend;

use App\Models\Inventaris;
use App\Models\JenisBarang as ModelsJenisBarang;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Component;

class JenisBarang extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '', $perpage = 5;
    public $id_jenbar, $k_jenbar, $jenbar, $update = false;

    protected $rules = [
        'k_jenbar'  => 'required',
        'jenbar'    => 'required',
    ];
    protected $validationAttributes = [
        'k_jenbar'  => 'Kode Jenis Barang',
        'jenbar'    => 'Jenis Barang',
    ];

    protected $messages = [
        'required'      => ':attribute wajib diisi',
    ];
    public function updated($fild)
    {
        $this->validateOnly($fild);
    }

    public function resetForm()
    {
        $this->k_jenbar = '';
        $this->jenbar = '';
        $this->update = false;
        $this->resetErrorBag();
    }

    public function Simpan()
    {
        $validatinData =  $this->validate();
        $validatinData['jenbar'] = Str::title($this->jenbar);
        ModelsJenisBarang::create($validatinData);
        $this->resetForm();
        session()->flash('pesan', 'Data berhasil disimpan');
        $this->emit('alert_remove');
    }

    public function Edit($id)
    {
        $this->update = true;
        $data = ModelsJenisBarang::find($id);
        $this->id_jenbar = $data->id;
        $this->k_jenbar = $data->k_jenbar;
        $this->jenbar = $data->jenbar;
    }

    public function Update($id)
    {
        $data = ModelsJenisBarang::find($id);
        $inven = ModelsJenisBarang::find($id)->Inven;
        if (count($inven) >= 1) {
            session()->flash('hapus', 'Maaf ' . $data->jenbar . ' tidak bisa di edit karena telah digunakan di Inventaris.');
            $this->resetform();
        } else {
            // $data = ModelsJenisBarang::find($id);
            // $rules = [
            //     'jenbar'   => 'required',
            // ];
            // if ($this->jenbar != $data->jenbar) {
            //     $rules['jenbar'] = 'required|unique:jenis_barangs';
            // }
            $validatinData =  $this->validate();
            $validatinData['jenbar'] = Str::title($this->jenbar);
            ModelsJenisBarang::where('id', $id)->update($validatinData);
            $this->resetform();
            $this->resetErrorBag();
            $this->update = false;
            session()->flash('pesan', 'Data berhasil diedit');
        }
        $this->emit('alert_remove');
    }

    public function Delete($id)
    {
        $inven = ModelsJenisBarang::find($id)->Inven;
        if (count($inven) >= 1) {
            session()->flash('hapus', 'Maaf ' . $this->jenbar . ' tidak bisa di hapus karena telah digunakan di Inventaris.');
            $this->resetform();
        } else {
            ModelsJenisBarang::destroy($id);
            $this->resetForm();
            session()->flash('hapus', 'Data berhasil dihapus');
        }
        $this->emit('alert_remove');
        $this->emit('delete');
    }

    public function render()
    {
        $data = [
            'jenisBarang' => ModelsJenisBarang::Where('jenbar', 'like', '%' . $this->search . '%')->latest()->paginate($this->perpage)
        ];

        return view('livewire.backend.jenis-barang', $data)->extends('layouts.index')->section('content');
    }
}