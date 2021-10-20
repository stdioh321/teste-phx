<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Carro extends Model
{
    use SoftDeletes;

    protected $table = "carros";
    public $timestamps = false;

    protected $fillable = [
        'marca', 'modelo', 'ano',
    ];

    // Não exibe o campo "deleted_at" nos endpoints
    protected $hidden = [
        'deleted_at',
    ];
    protected $casts = [
        'ano' => 'date:Y-m-d',
    ];

    public function setAnoAttribute($value)
    {
        // Caso o ano seja passado com string, ele é setado com Carbon
        if (is_string($value))
            $this->attributes["ano"] = Carbon::parse($value);
        else
            $this->attributes["ano"] = $value;
    }
}
