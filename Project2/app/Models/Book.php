<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function reviews() {
        //Defines a one-to-many relationship between Book and Review models (tables)
        return $this->hasMany(Review::class);
    }
}
