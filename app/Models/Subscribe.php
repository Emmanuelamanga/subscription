<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscribe extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass Assignable fields
     */
    protected $fillable = [
        'website_name', 'email'
    ];

    /**
     * Subscriber post relation
     *
     * one subscriber many websites
     */
    public function websites()
    {
        return $this->hasMany(Website::class, 'name', 'id');
    }
}
