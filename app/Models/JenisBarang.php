<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventaris;

class JenisBarang extends Model
{
    use HasFactory;
    protected $fillable = [
        'k_jenbar',
        'jenbar',
    ];

    public function Inven()
    {
        return $this->hasMany(Inventaris::class, 'jenbar_id');
    }
}