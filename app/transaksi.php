<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    protected $table = 'transaksi';
    public $timestamps = false;
    protected $primaryKey = 'id_transaksi';

    protected $fillable = ['id_member', 'tgl', 'batas_waktu', 'tgl_bayar', 'status', 'dibayar', 'id'];
}