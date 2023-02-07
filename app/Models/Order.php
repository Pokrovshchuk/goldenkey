<?php

namespace App\Models;

use App\Http\Requests\OrderMakeRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['quantity', 'total', 'status', 'user_id', 'product_id', 'user_id', 'email'];

    const STATUSES = [
        'p' => 'pending',
        'pr' => 'processing',
        'com' => 'completed',
        'с' => 'cancelled',
        'f' => 'failed',
        'r' => 'returned'
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(User::class);
    }

    public function certificates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order_meta(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(OrderMeta::class, 'order_id', 'id');
    }

//    public static function createOrder(int $product_id, int $quantity = 1, $user_id = null, string $email = null, bool $more_than_one, bool $named, string $name = null)
    public static function createOrder(OrderMakeRequest $request)
    {
        $product = Product::select('id', 'price', 'count')->where('id', $request->product_id)->first();
        $product->count -= $request->quantity;
        $product->save();

        $user_id = null;
        if(auth()->check()) {
            $user_id = auth()->user()->id;
        }

        $order = self::create([
            'product_id' => $request->product_id,
            'quantity' => (int)$request->quantity,
            'total' => $request->quantity * $product->price,
            'status' => self::STATUSES['p'],
            'user_id' => $user_id,
            'email' => $request->email,
        ]);

        OrderMeta::create([
            'order_id' => $order->id,
            'more_than_one' => $request->more_than_one ?? false,
            'named' => $request->named ?? false,
            'name' => $request->name,
            'from_stand' => (bool)$request->from_stand,
        ]);

        return $order;
    }
}
