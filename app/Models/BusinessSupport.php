<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessSupport extends Model
{
    use HasFactory;

    protected $table = 'business_supports';

    protected $fillable = [
        'nama',
      
    ];

}
