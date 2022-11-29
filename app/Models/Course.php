<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
    ];

    protected $appends =[
        'year_created_at',
    ];
    public function getYearCreatedAtAttribute($value)
    {
        return $this->created_at->format('Y');
        // return date_format(date_create($this->created_at), 'Y');
    }
}
