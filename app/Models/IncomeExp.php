<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeExp extends Model
{
    use HasFactory;

    protected $table = "income_expense";
    protected $fillable=[
        'id', 'type', 'amount', 'currency', 'amount_equal', 'currency_equal', 'date', 'transaction_id', 'finance_acount_id','bank_id', 'user_id', 'ref_type', 'state', 'status', 'desc', 'created_at', 'updated_at'
    ];


    public function expense_currency()
    {
        return $this->belongsto(Currency::class, 'currency','id');
    }
    public function inserted_by_user()
    {
        return $this->belongsto(User::class,'user_id','id');
    }
    public function expense_acount()
    {
        return $this->belongsto(FinanceAccount::class,'finance_acount_id','id');
    }
    public function expense_bank()
    {
        return $this->belongsto(FinanceAccount::class,'bank_id','id');
    }
    public function transaction()
    {
        return $this->belongsto(IncomeExp::class,'bank_id','id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class,'ref_type');
    }

    public function customer_expense()
    {
        return $this->belongsTo(Customer::class);
    }
    public function user()
    {
        return $this->belongsto(User::class);
    }
}
