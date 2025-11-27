<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str; // Import Str untuk UUID

class CartItem extends Model
{
    use HasFactory;

    // Konfigurasi UUID
    public $incrementing = false; // Non auto-increment
    protected $keyType = 'string'; // Tipe primary key adalah string

    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = [
        'id',
        'user_id',
        'product_id',
        'quantity',
    ];

    // Auto-generate UUID saat create
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi: Item keranjang ini milik satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Item keranjang ini merujuk ke satu Product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}