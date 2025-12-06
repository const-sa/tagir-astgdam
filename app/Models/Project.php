<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Project extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function client()
    {
        // return $this->belongsTo(Client::class);
        return $this->belongsTo(User::class, 'client_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_projects');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'item');
    }
}
