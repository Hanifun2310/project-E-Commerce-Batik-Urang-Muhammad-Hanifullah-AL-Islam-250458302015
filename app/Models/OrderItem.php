<?php

namespace App\Models; // <-- [FIX] Namespace harusnya App\Models

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str; // Import Str untuk UUID
use App\Models\Order; // <-- [TAMBAH] Impor model Order
use App\Models\Product; // <-- [TAMBAH] Impor model Product

class OrderItem extends Model
{
    use HasFactory;

    // Konfigurasi UUID
    public $incrementing = false; // Non auto-increment
    protected $keyType = 'string'; // Tipe primary key adalah string

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'product_name',
        'quantity',
        'price_at_purchase',
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
     * Relasi: Item ini milik satu Order.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class); // Sekarang 'Order' dikenali
    }

    /**
     * Relasi: Item ini merujuk ke satu Product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class); // Sekarang 'Product' dikenali
    }
}