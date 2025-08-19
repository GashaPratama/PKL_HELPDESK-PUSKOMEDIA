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
        'judul',
        'kategori_id',
        'url_situs',
        'kendala',
        'lampiran',     // file bukti (foto/dokumen)
        'status',
        'assigned_to',  // teknisi yang ditugaskan
        'notes',        // catatan dari CS
    ];

    /**
     * Alias agar bisa akses $laporan->deskripsi
     */
    public function getDeskripsiAttribute()
    {
        return $this->kendala;
    }

    /**
     * Alias agar bisa akses $laporan->url
     */
    public function getUrlAttribute()
    {
        return $this->url_situs;
    }

    /**
     * Alias agar bisa akses $laporan->foto (mengambil dari lampiran)
     */
    public function getFotoAttribute()
    {
        return $this->lampiran;
    }

    /**
     * Relasi ke user yang membuat laporan (customer)
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
    
    /**
     * Relasi ke teknisi yang ditugaskan
     */
    public function teknisi()
    {
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }

    /**
     * Relasi ke kategori laporan
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }
}
