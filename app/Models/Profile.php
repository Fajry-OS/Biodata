<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'picture',
        'nama_lengkap',
        'no_telpon',
        'email',
        'deskripsi',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'alamat',
    ];
    protected $date = ['deleted_at'];

    public function experience(){
        return $this->hasMany(Experience::class, 'id_profile');
    }
}


