<?php

namespace App\Http\Livewire\Backend;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Profil extends Component
{
    public $id_user, $nama, $email, $old_password, $password, $password_confirmation, $no_hp, $alamat,  $level, $update = false, $ganti_pass = false;

    protected $rules = [
        'nama'                      => 'required',
        'email'                     => 'required|email',
        'no_hp'                     => 'required|min:10|max:13',
        'alamat'                    => 'required',
    ];
    protected $validationAttributes = [
        'nama'                  => 'Nama',
        'email'                 => 'Email',
        'old_password'          => 'Password Lama',
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
        'mas'           => ':attribute maksimal :min karakter',
        'same'          => ':attribute tidak cocok.',
        'email'         => 'Format :attribute tidak valid'
    ];
    public function updated($fild)
    {
        $this->validateOnly($fild);
        $this->resetErrorBag();
    }

    public function Profil()
    {
        if ($this->update == false) {
            $user = User::find(auth()->user()->id);
            $this->nama = $user->nama;
            $this->email = $user->email;
            $this->no_hp = $user->no_hp;
            $this->alamat = $user->alamat;
            $this->level = $user->level;
        }
    }
    public function Close()
    {
        $this->update = false;
        $this->ganti_pass = false;
        $this->nama = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->old_password = '';
        $this->email = '';
        $this->no_hp = '';
        $this->alamat = '';
        $this->resetErrorBag();
    }
    public function Edit()
    {
        $this->update = true;
        $this->ganti_pass = false;
        $user = User::find(auth()->user()->id);
        $this->nama = $user->nama;
        $this->email = $user->email;
        $this->no_hp = $user->no_hp;
        $this->alamat = $user->alamat;
        $this->level = $user->level;
    }
    public function Ganpas()
    {
        $this->update = false;
        $this->ganti_pass = true;
    }

    public function Update()
    {
        if ($this->update == true && $this->ganti_pass == false) {
            $rules = [
                'nama'                      => 'required',
                'no_hp'                     => 'required|min:10|max:13',
                'email'                     => 'required',
                'alamat'                    => 'required|min:6',
            ];
            $validatinData =  $this->validate();
            $validatinData['nama'] = Str::title($this->nama);
            User::where('id', auth()->user()->id)->update($validatinData);
            session()->flash('pesan', 'Data berhasil diedit');
        } elseif ($this->update == false && $this->ganti_pass == true) {
            $rules = [
                'old_password'              => 'required',
                'password'                  => 'required|min:6',
                'password_confirmation'     => 'required|same:password|min:6',
            ];
            $this->validate($rules);
            $user = User::find(auth()->user()->id);
            if (Hash::check($this->old_password, $user->password)) {
                $user->fill([
                    'password' => Hash::make($this->password_confirmation)
                ])->save();
                session()->flash('pesan', 'Password berhasil di rubah');
            } else {
                return $this->addError('old_password', 'Password lama salah.');
            }
        }
        $this->Close();
        $this->emit('alert_remove');
    }

    public function render()
    {
        $this->Profil();
        return view('livewire.backend.profil')->extends('layouts.index')->section('content');
    }
}