<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class paket extends Model
{
    protected $table = 'paket';
    public $timestamps = false;
    protected $primaryKey = 'id_paket';
    protected $fillable = ['id_paket','jenis','harga'];
}