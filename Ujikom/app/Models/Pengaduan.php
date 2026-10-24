<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'nama', 
        'email', 
        'no_telp', 
        'no_meja', 
        'kategori', 
        'isi_pengaduan', 
        'file_upload', 
        'status'
    ];
}
