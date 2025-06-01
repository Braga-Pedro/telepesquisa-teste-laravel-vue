<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Empresa extends Model
{
    /** @use HasFactory<\Database\Factories\EmpresaFactory> */
    use HasFactory;

    protected $fillable = [
        'nome',
        'cep',
        'rua',
        'numero_casa',
        'bairro',
        'estado',
        'telefone',
        'cpf_cnpj',
        'segmento_id',
        'deleted_at',
    ];

    // protected $append = [
    //     'cep_formatado',
    //     'telefone_formatado',
    // ];
    
    public function segmento()
    {
        return $this->belongsTo(Segmento::class, 'segmento_id');
    }
    
    // public function getCepFormatadoAttribute()
    // {
    //     // Format the CEP to a standard format (e.g., 12345-678)
    //     return preg_replace('/(\d{5})(\d{3})/', '$1-$2', $this->cep);
    // }

    // public function getTelefoneFormatadoAttribute()
    // {
    //     // Format the phone number to a standard format (e.g., (12) 34567-8901)
    //     return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $this->telefone);
    // }


}
