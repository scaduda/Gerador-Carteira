<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rgbm extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'rgbms';
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'nom_completo',
        'cargo_nome',
        'num_cpf',
        'num_matricula',
        'num_rgbm',
        'rg',
        'tip_sangue',
        'siape',
        'naturalidade',
        'nacionalidade',
        'dat_nasc',
        'dat_validade_rgbm',
        'data_expedicao',
        'foto',
        'assinatura'
    ];
    protected $visible = [
        'id',
        'nom_completo',
        'cargo_nome',
        'num_cpf',
        'num_matricula',
        'num_rgbm',
        'rg',
        'tip_sangue',
        'siape',
        'naturalidade',
        'nacionalidade',
        'dat_nasc',
        'dat_validade_rgbm',
        'data_expedicao',
        'foto',
        'assinatura'
    ];
}
