<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['brand', 'model', 'price'];
    protected function casts(): array
    {
        return ['price' =>'integer'];
    }
}
