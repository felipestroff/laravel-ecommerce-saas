<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'name',
        'subdomain',
        'logo',
        'description',
        'main_categories',
    ];

    /**
     * Get the user (loja) that owns the store settings.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
