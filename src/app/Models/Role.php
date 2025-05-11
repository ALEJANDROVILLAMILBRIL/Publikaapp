<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Role extends Model
{
    protected $fillable = ['name', 'slug'];

    protected static function booted()
    {
        static::creating(function ($role) {
            $role->slug = Str::slug($role->name);
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}