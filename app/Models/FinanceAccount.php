<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceAccount extends Model
{
    use HasFactory;


    protected $table ="finance_account";
    protected $fillable=[
            'id',
            'account_name',
            'type',
            'currency',
            'description',
            'user_id',
            'status',
            'created_at',
            'updated_at'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function transaction(){
        return $this->hasOne(Transaction::class);
    }
    public function finance_currency()
    {
        return $this->belongsTo(Currency::class,'currency');
    }
    public function expenses_acount()
    {
        return $this->hasMany(IncomeExp::class,'finance_acount_id');
    }
    public function expenses_banks()
    {
        return $this->hasMany(IncomeExp::class,'bank_id');
    }

    public function transaction_bank()
    {
        return $this->hasMany(IncomeExp::class,'bank_acount_id');
    }
}
