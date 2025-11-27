<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str; // Import Str untuk UUID
use App\Models\User;
use App\Models\OrderItem; 

class Order extends Model
{
    use HasFactory;

    // Konfigurasi UUID
    public $incrementing = false; // Non auto-increment
    protected $keyType = 'string'; // Tipe primary key adalah string

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'id',
        'user_id',
        'recipient_name',
        'phone_number',
        'shipping_address',
        'total_amount',
        'payment_method',
        'status',
        'payment_proof_path',
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
     * Relasi: Pesanan ini milik satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class); // Sekarang 'User' dikenali
    }

    /**
     * Relasi: Pesanan ini memiliki banyak Item.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class); // Sekarang 'OrderItem' dikenali
    }
}