<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    protected $primarykey = 'id_member';

    public $timestamps = false;

    protected $fillable =['id_member','nama_member', 'alamat', 'jenis_kelamin', 'tlp'];
}
