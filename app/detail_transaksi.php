<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_transaksi extends Model
{
    protected $table = 'detail_transaksi';
    public $timestamps = false;
    protected $primaryKey = 'id_detail_transaksi';

    protected $fillable = ['id_transaksi','id_paket', 'qty', 'subtotal'];
}