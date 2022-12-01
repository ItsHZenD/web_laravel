<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function getAgeAttribute(){
        return date_diff(date_create($this->birthdate), date_create('now'))->y;
    }
}
