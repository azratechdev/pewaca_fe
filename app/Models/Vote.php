<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $connection = 'voting_sqlite';

    protected $fillable = [
        'candidate_id',
        'voter_name',
        'house_block',
        'ip_address'
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
