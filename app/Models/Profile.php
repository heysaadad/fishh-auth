<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'about',
        'job_title',
        'job_place',
        'school_name',
        'grad_year',
        'custom_username',
        'current_city',
        'photo_1',
        'photo_2',
        'photo_3',
        'photo_4',
        'photo_5',
    ];

    // public function user(){
    //     return $this->belongsTo(User::class);
    // }


}
