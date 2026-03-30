<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    use HasFactory;
    
    protected $table = 'dm_the_loai';
    public $timestamps = false;
    
    protected $fillable = ['id', 'ten_the_loai'];
    
    public function saches()
    {
        return $this->hasMany(Sach::class, 'the_loai', 'id');
    }
}