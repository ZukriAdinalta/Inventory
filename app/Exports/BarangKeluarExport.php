<?php

namespace App\Exports;

use App\Models\BarangKeluar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BarangKeluarExport implements FromView
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
        // dd($this->tgl_akhir);
        return view('exports.barang-keluar', [
            'BarangKeluar' => BarangKeluar::with('Inven')->whereBetween('tgl_keluar', [$this->tgl_awal, $this->tgl_akhir])
                ->orderBy('tgl_keluar')->get(),
            'tgl_awal' =>  $this->tgl_awal,
            'tgl_akhir' => $this->tgl_akhir,
            'manager' =>  $this->manager,
            'kegud' => $this->kegud,
        ]);
    }
}