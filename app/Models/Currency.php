<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Currency extends Model
{
    use HasFactory;

    protected $table="currency";
    protected $fillable=
    [
        'id', 'name', 'sign', 'status', 'created_at', 'updated_at'

    ]; 
    
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function order()
    {
        return $this->belongsTo(OrderModel::class);
    }
    public function financeAccount()
    {
        return $this->hasMany(FinanceAccount::class);
    }
    public function Transaction()
    {
        return $this->hasMany(Transaction::class);
    }
    public function expense()
    {
        return $this->hasMany(IncomeExp::class);
    }
}
