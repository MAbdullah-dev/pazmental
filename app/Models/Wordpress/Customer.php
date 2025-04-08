<?php

declare(strict_types=1);

namespace App\Models\Wordpress;

use Corcel\Model\User;
use App\Models\Wordpress\Order;
use Database\Factories\CustomerFactory;
use Corcel\WooCommerce\Traits\AddressesTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Corcel\WooCommerce\Traits\HasRelationsThroughMeta;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $order_count
 * @property Collection $orders
 */
class Customer extends User
{
    use AddressesTrait;
    use HasFactory;

    /**
     * @use HasRelationsThroughMeta<\Illuminate\Database\Eloquent\Model>
     */
    use HasRelationsThroughMeta;

    /**
     * {@inheritDoc}
     *
     * @var array<string>
     */
    protected $appends = [
        'order_count',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return CustomerFactory
     */
    protected static function newFactory()
    {
        return CustomerFactory::new();
    }

    /**
     * Get order count attribute.
     */
    protected function getOrderCountAttribute(): int
    {
        $count = $this->orders()->count();

        return is_numeric($count) ? (int) $count : 0;
    }

    /**
     * Get the related orders.
     *
     * @return HasMany<\Illuminate\Database\Eloquent\Model>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(
            Order::class,
            'post_author',
            'ID'
        );
    }
}
