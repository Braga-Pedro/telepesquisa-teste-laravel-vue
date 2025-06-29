<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Segmento extends Model
{
    /** @use HasFactory<\Database\Factories\SegmentoFactory> */
    use HasFactory;

    protected $fillable = [
        'nome',
        'deleted_at',
    ];
}
