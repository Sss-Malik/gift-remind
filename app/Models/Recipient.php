<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'relationship'];

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
