<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sach extends Model
{
    use HasFactory;
    
    protected $table = 'sach';
    public $timestamps = false;
    
    protected $fillable = [
        'tieu_de', 'nha_cung_cap', 'nha_xuat_ban', 'tac_gia',
        'hinh_thuc_bia', 'mo_ta', 'file_anh_bia', 'link_anh_bia',
        'gia_ban', 'the_loai'
    ];
    
    public function theLoai()
    {
        return $this->belongsTo(TheLoai::class, 'the_loai', 'id');
    }
}