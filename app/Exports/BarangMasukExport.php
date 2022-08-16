<?php

namespace App\Exports;

use App\Models\BarangMasuk;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BarangMasukExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $tgl_awal, $tgl_akhir, $manager, $kegud;

    function __construct($tgl_awal, $tgl_akhir, $manager, $kegud)
    {
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
        $this->manager = $manager;
        $this->kegud = $kegud;
    }


    public function view(): View
    {
        return view('exports.barang-masuk', [
            'BarangMasuk' => BarangMasuk::with('Inven')->whereBetween('tgl_masuk', [$this->tgl_awal, $this->tgl_akhir])
                ->orderBy('tgl_masuk')->get(),
            'tgl_awal' =>  $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir,
            'manager' =>  $this->manager,
            'kegud' => $this->kegud,
        ]);
    }
}