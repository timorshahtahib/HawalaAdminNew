<?php

namespace App\Models;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable ;
    protected $table="users";
    protected $fillable=
    [
            'id', 'name', 'cu_number',
            'phone', 'username', 'password', 'image', 
            'address', 'token', 'type', 
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
