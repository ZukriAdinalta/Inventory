<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    // protected $fillable = ['k_inven', 'nambar', 'jumlah_masuk', 'tgl_masuk', 'user'];
    protected $guarded = ['id'];
    protected $with = ['Inven', 'User'];

    public function Inven()
    {
        return $this->belongsTo(Inventaris::class, 'inven_id');
    }
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('id', 'like', $term)
                ->orWhere('jenbar', 'like', $term)
                ->orWhere('nambar', 'like', $term)
                ->orWhereHas('User', function ($query) use ($term) {
                    $query->where('nama', 'like', $term);
                })
                ->orWhereHas('Inven', function ($query) use ($term) {
                    $query->where('k_inven', 'like', $term);
                });
        });
    }
}