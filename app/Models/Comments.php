<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $fillable = ['text'];

    public function post()
    {
        return $this->belongsTo(Posts::class)->
        select('id','post','user_id');
    }
}
