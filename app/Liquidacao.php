<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liquidacao extends Model
{
    use HasFactory;

    protected $table = 'lancamentos';
    protected $guarded = array();
}
