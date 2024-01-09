<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table="customer";
    protected $fillable=
    [
            'id', 'name', 'last_name', 'cu_number',
            'phone', 'username', 'password', 'image', 
            'address', 'token', 'type', 'acount_currency',
            'desc', 'status',
            'created_at', 'updated_at'

    ]; 
    protected $hidden = ['username', 'password', 'created_at', 'updated_at'
    // ,'status',
];


    public function currency()
    {
        return $this->hasMany(Currency::class);
    }

    public function orders(){
        return $this->hasMany(OrderModel::class);
    }
    public function financeAccount()
    {
        return $this->hasOne(FinanceAccount::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function incomeExpense()
    {
        return $this->hasMany(IncomeExp::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
  
}