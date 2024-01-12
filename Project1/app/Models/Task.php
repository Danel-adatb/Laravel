<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    //Which properties can be mass changed or modified and which not!
    protected $fillable = ['title', 'description', 'long_description'];
    //All the sensitive informations: (guarded)
    //protected $guarded = ['secret / password'];

    public function toggleComplete() {
        $this->completed = !$this->completed;
        $this->save();
    }
}
