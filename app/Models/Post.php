<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'title',
        'description',
        'website_name'
    ];
}