<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    use HasFactory;

    // protected $connection = 'sqlite_backup'; // Use default connection (mysql)

    protected $fillable = [
        'name',
        'description',
        'logo',
        'address',
        'phone',
        'email',
        'rating',
        'is_active',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function availableProducts()
    {
        return $this->hasMany(Product::class)->where('is_available', true)->where('stock', '>', 0);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'store_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function sellers()
    {
        return $this->users()->wherePivot('role', 'seller');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
