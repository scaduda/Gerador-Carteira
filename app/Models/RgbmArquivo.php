<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RgbmArquivo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'arquivos_rgbms';
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'frente',
        'verso',
        'rgbm_id'
    ];
    protected $visible = [
        'id',
        'frente',
        'verso',
        'rgbm_id'
    ];
}
