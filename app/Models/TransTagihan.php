<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransTagihan extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function detail(){
        return $this->hasMany(TransTagihanDetail::class,'trans_tagihan_id','id');
    }
}
