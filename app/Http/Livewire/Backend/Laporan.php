<?php

namespace App\Http\Livewire\Backend;

use App\Exports\BarangKeluarExport;
use App\Exports\BarangMasukExport;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
// use Maatwebsite\Excel\Excel;
use Livewire\WithPagination;
use Livewire\Component;
use Maatwebsite\Excel\Excel as ExcelExcel;

class Laporan extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $tgl_awal, $tgl_akhir, $manager, $kegud, $kategori, $filter = false, $perpage = 10;
    protected $rules = [
        'tgl_awal'      => 'required',
        'tgl_akhir'     => 'required',
        'kategori'      => 'required',
        'manager'       => 'required',
        'kegud'         => 'required',
    ];
    protected $validationAttributes = [
        'tgl_awal'       => 'Tanggal',
        'tgl_akhir'      => 'Tanggal',
        'kategori'       => 'Kategori Laporan',
        'kategori'       => 'Manager',
        'kegud'          => 'Kepala Gudang',
    ];
    protected $messages = [
        'required'      => ':attribute wajib diisi',
    ];

    public function resetForm()
    {
        $this->kategori = '';
        $this->tgl_awal = '';
        $this->tgl_akhir = '';
        $this->resetErrorBag();
        $this->filter = false;
    }

    public function Export()
    {
        ini_set('max_execution_time', '0');
        ini_set("pcre.backtrack_limit", "5000000");
        ini_set('memory_limit', '1024M');
        $tgl_awal = $this->tgl_awal;
        $tgl_akhir = $this->tgl_akhir;
        $manager = $this->manager;
        $kegud = $this->kegud;
        $this->validate();
        if ($this->kategori == 'b_masuk') {
            $this->resetForm();
            session()->flash('pesan', 'Laporan berhasil dibuat');
            $this->emit('alert_remove');
            return Excel::download(new BarangMasukExport($tgl_awal, $tgl_akhir, $manager, $kegud), 'Barang Masuk.pdf', ExcelExcel::MPDF);
        } elseif ($this->kategori == 'b_keluar') {
            $this->resetForm();
            session()->flash('pesan', 'Laporan berhasil dibuat');
            $this->emit('alert_remove');
            return Excel::download(new BarangKeluarExport($tgl_awal, $tgl_akhir, $manager, $kegud), 'Barang Keluar.pdf', ExcelExcel::MPDF);
            // return Excel::download(new BarangKeluarExport($tgl_awal, $tgl_akhir), 'Barang Keluar.xlsx');
        }
    }
    public function Filter()
    {
        $rules = [
            'tgl_awal'      => 'required',
            'tgl_akhir'     => 'required',
            'kategori'      => 'required',
        ];
        $this->validate($rules);
        $this->filter = true;
    }

    public function render()
    {
        if ($this->kategori == 'b_masuk') {
            $data =
                [
                    'Manager'   => User::where('level', 1)->get(),
                    'Kegud'     => User::where('level', 2)->get(),
                    'BarangMasuk' => BarangMasuk::with('Inven')->whereBetween('tgl_masuk', [$this->tgl_awal, $this->tgl_akhir])
                        ->orderBy('tgl_masuk')->latest()->paginate($this->perpage)
                ];
        } elseif ($this->kategori == 'b_keluar') {
            $data =
                [
                    'Manager'   => User::where('level', 1)->get(),
                    'Kegud'     => User::where('level', 2)->get(),
                    'BarangKeluar' =>  BarangKeluar::with('Inven')->whereBetween('tgl_keluar', [$this->tgl_awal, $this->tgl_akhir])
                        ->orderBy('tgl_keluar')->paginate($this->perpage),
                ];
        } else {
            $data = [
                'Manager'   => User::where('level', 1)->get(),
                'Kegud'     => User::where('level', 2)->get(),
            ];
        }

        return view('livewire.backend.laporan', $data)->extends('layouts.index')->section('content');
    }
}