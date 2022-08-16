<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class Inventaris extends Model
{
    use HasFactory;

    protected $fillable = ['jenbar_id', 'nambar_id', 'k_inven', 'user_id'];
    protected $with = ['Jenbar', 'Nambar', 'User'];

    public function Jenbar()
    {
        return $this->belongsTo(JenisBarang::class);
    }
    public function Nambar()
    {
        return $this->belongsTo(NamaBarang::class);
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function BM()
    {
        return $this->hasMany(BarangMasuk::class, 'inven_id');
    }
    public function BK()
    {
        return $this->hasMany(BarangKeluar::class, 'inven_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('id', 'like', $term)
                ->orWhere('k_inven', 'like', $term)
                ->orWhereHas('User', function ($query) use ($term) {
                    $query->where('nama', 'like', $term);
                })
                ->orWhereHas('Jenbar', function ($query) use ($term) {
                    $query->where('jenbar', 'like', $term);
                })
                ->orWhereHas('Nambar', function ($query) use ($term) {
                    $query->where('nambar', 'like', $term);
                });
        });
    }
}