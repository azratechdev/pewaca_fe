<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'photo',
        'visi',
        'misi',
        'bio',
        'vote_count',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
