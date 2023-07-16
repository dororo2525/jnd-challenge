<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlClick extends Model
{
    use HasFactory;
    protected $table = 'url_clicks';
    protected $fillable = [
        'url_id',
        'browser',
        'platform',
        'device',
        'created_at',
        'updated_at',
    ];

    public function url()
    {
        return $this->belongsTo(Url::class);
    }
}
