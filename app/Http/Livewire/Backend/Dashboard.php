<?php

namespace App\Http\Livewire\Backend;

use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Inventaris;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $data = [
            'User' => User::all(),
            'Inven' => Inventaris::all(),
            'BM' => BarangMasuk::all(),
            'BK' => BarangKeluar::all(),
        ];
        return view('livewire.backend.dashboard', $data)->extends('layouts.index')->section('content');
    }
}