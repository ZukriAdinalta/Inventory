<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventaris;

class NamaBarang extends Model
{
    use HasFactory;
    protected $fillable = [
        'k_nambar',
        'nambar',
    ];

    public function Inven()
    {
        return $this->hasMany(Inventaris::class, 'nambar_id');
    }
}