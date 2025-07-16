<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'no_telpon',
        'jenis_kelamin',
        'tanggal_lahir',
        'role',
        'foto_profil'
    ];
}
