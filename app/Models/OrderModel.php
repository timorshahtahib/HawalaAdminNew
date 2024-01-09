<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;

    protected $table="orders";
    protected $fillable=
    [
        "id",
        "customer_id",
        "transaction_id",
        "order_date",
        "action_date",
        "state",
        "order_number",
        "ip_address",
        "system",
        "phone_number",
        "network_id",
        "sub_category_id",
        "qtt", 
        "amount",
        "final_amount",
        "profit_percentage",
        "profit_amount",
        "currency",
        "buy_currency_id",
        "currency_rate",
        "buy_price",
        "user_id",
        "product_id",
        "supplier_id",
        "reject_disc",
        "status",
        "created_at",
        "updated_at"

    ];
    public function Customer(){
        return $this->belongsTo(Customer::class);
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function orders()
    {
        return $this->belongsTo(OrderModel::class);
    }

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'buy_currency_id');
    }

}
