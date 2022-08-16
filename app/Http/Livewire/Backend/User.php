<?php

namespace App\Http\Livewire\Backend;

use App\Models\User as ModelsUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\Component;
use Symfony\Component\String\ByteString;

class User extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search = '', $perpage = 10;
    public $id_user, $nama, $email, $password, $no_hp, $alamat, $level, $password_confirmation;
    public $update = false, $ganti_pass = false, $hapus_pass = false;

    protected $rules = [
        'nama'                      => 'required',
        'email'                     => 'required|email',
        'no_hp'                     => 'required|min:6|max:13',
        'alamat'                    => 'required',
        'password'                  => 'required|min:6',
        'level'                     => 'required',
    ];
    protected $validationAttributes = [
        'nama'                  => 'Nama',
        'email'                 => 'Email',
        'password'              => 'Password',
        'no_hp'                 => 'Nomor Hp',
        'alamat'                => 'Alamat',
        'level'                 => 'Level',
        'password_confirmation' => 'Konfirmasi Password',
    ];
    protected $messages = [
        'required'      => ':attribute wajib diisi',
        'unique'        => ':attribute sudah ada',
        'min'           => ':attribute minimal :min karakter',
        'max'           => ':attribute maksimal :min karakter',
        'same'          => ':attribute tidak cocok.',
        'email'         => 'Format :attribute tidak valid'
    ];
    public function updated($fild)
    {
        $this->validateOnly($fild);
        $this->resetErrorBag();
    }

    public function HPass($id)
    {
        $this->hapus_pass = true;
        $this->ganti_pass = false;
        $user = ModelsUser::find($id);
        $this->id_user = $user->id;
        $this->nama = $user->nama;
        $this->password = $user->password;
        $this->level = $user->level;
    }
    public function GPass($id)
    {
        $this->ganti_pass = true;
        $this->hapus_pass = false;
        $user = ModelsUser::find($id);
        $this->id_user = $user->id;
        $this->nama = $user->nama;
        $this->email = $user->email;
        $this->password = bin2hex(random_bytes(8));
        ModelsUser::where('id', $id)->update(
            [
                'status'    => 1,
                'password'  => Hash::make($this->password)
            ]
        );
        session()->flash('pesan', 'Berhasil aktifkan user ');
    }

    public function Password($id)
    {
        $data = ModelsUser::where('level', 1)->get();
        if (count($data) < 2 && $this->level == 1) {
            session()->flash('hapus', 'Maaf ' . $this->nama . ' tidak bisa di nonaktifkan karena manager harus lebih dari 1 user.');
            $this->resetform();
            $this->emit('password');
        } else {
            ModelsUser::where('id', $id)->update(
                [
                    'status' => 0
                ]
            );

            $this->resetForm();
            $this->emit('password');
            session()->flash('pesan', 'Berhasil nonaktifkan user ');
            $this->emit('alert_remove');
            $this->hapus_pass = false;
        }
    }

    public function resetForm()
    {
        $this->nama = '';
        $this->email = '';
        $this->alamat = '';
        $this->no_hp = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->level = '';
        $this->resetErrorBag();
        $this->update = false;
        $this->hapus_pass = false;
    }

    public function Simpan()
    {
        $rules = [
            'nama'                      => 'required',
            'email'                     => 'required|unique:users|email',
            'no_hp'                     => 'required|min:6|max:13',
            'alamat'                    => 'required',
            'password'                  => 'required|min:6',
            'password_confirmation'     => 'required|same:password|min:6',
            'level'                     => 'required',
        ];
        $validatinData =  $this->validate($rules);
        $validatinData['nama'] = Str::title($this->nama);
        $validatinData['password'] = Hash::make($this->password);
        ModelsUser::create($validatinData);
        $this->resetForm();
        session()->flash('pesan', 'Data berhasil disimpan');
        $this->emit('alert_remove');
        $this->emit('create');
    }

    public function Edit($id)
    {
        $this->update = true;
        $user = ModelsUser::find($id);
        $this->id_user = $user->id;
        $this->nama = $user->nama;
        $this->password = $user->password;
        $this->email = $user->email;
        $this->no_hp = $user->no_hp;
        $this->alamat = $user->alamat;
        $this->level = $user->level;
    }

    public function Update()
    {
        $user = ModelsUser::find($this->id_user);
        $rules = [
            'nama'                      => 'required',
            'no_hp'                     => 'required',
            'email'                     => 'required',
            'alamat'                    => 'required|min:6|max:13',
            'level'                     => 'required',
        ];
        if ($this->email != $user->email) {
            $rules['email'] = 'required|unique:users|email';
        }
        $validatinData =  $this->validate();
        $validatinData['nama'] = Str::title($this->nama);
        ModelsUser::where('id', $this->id_user)->update($validatinData);
        $this->resetform();
        $this->resetErrorBag();
        $this->update = false;
        session()->flash('pesan', 'Data berhasil diedit');
        $this->emit('alert_remove');
        $this->emit('create');
    }

    public function Delete($id)
    {
        $data = ModelsUser::where('level', 1)->get();
        $inven = ModelsUser::find($id)->Inven;
        if (count($inven) >= 1) {
            session()->flash('hapus', 'Maaf ' . $this->nama . ' tidak bisa di hapus karena telah digunakan di Inventaris sebanyak ' . count($inven) . ' data');
            $this->resetform();
            $this->emit('delete');
        } elseif (count($data) < 2 && $this->level == 1) {
            session()->flash('hapus', 'Maaf ' . $this->nama . ' tidak bisa di hapus karena manager harus lebih dari 1 user.');
            $this->resetform();
            $this->emit('delete');
        } elseif ($id == Auth()->user()->id) {
            session()->flash('hapus', 'Maaf ' . $this->nama . ' tidak bisa mengapus akun anda sendiri.');
            $this->resetform();
            $this->emit('delete');
        } else {
            ModelsUser::destroy($id);
            $this->resetForm();
            session()->flash('hapus', 'Data berhasil dihapus');
            $this->emit('alert_remove');
            $this->emit('delete');
        }
    }
    public function render()
    {
        $data = [
            'User' => ModelsUser::Where('nama', 'like', '%' . $this->search . '%')->latest()->paginate($this->perpage),
        ];
        return view('livewire.backend.user', $data)->extends('layouts.index')->section('content');
    }
}