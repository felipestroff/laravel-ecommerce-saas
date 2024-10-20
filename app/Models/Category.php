<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'user_id',
    ];

    /**
     * Get the user (loja) that owns the category.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
