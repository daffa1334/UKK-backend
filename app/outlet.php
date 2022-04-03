<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $table = 'outlet';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['id','nama_outlet','alamat'];
}