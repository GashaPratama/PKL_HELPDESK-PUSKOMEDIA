<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'kategori_id',  
        'url_situs',
        'kendala',
        'lampiran',
        'status',
    ];

    // Relasi ke user (pelapor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}

