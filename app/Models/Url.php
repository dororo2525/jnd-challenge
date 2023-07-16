<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;
    protected $table = 'shorten_urls';
    protected $fillable = [
        'url',
        'shorten_url',
        'code',
        'user_id',
        'hits',
        'status',
    ];

    public function clicks(){
        return $this->hasMany(UrlClick::class);
    }
}
