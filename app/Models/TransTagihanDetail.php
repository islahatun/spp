<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransTagihanDetail extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function TagihanHeader(){
        return $this->belongsTo(TransTagihan::class,'trans_tagihan_id','id');
    }
}
