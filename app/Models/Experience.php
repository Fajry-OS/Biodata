<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_profile',
        'judul',
        'subjudul',
        'deskripsi',
        'tgl_experience',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'id_profile');
    }
}
