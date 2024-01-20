<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table="transaction";
    protected $fillable=
    [
        'id', 'rasid_bord','check_number','date', 'transaction_type', 'amount', 'currency', 'amount_equal', 'currency_equal', 'currency_rate', 'ref_id', 'order_id', 'finance_acount_id', 'bank_acount_id', 'user_id', 'desc', 'status', 'created_at', 'updated_at'

    ];
    public function customer()
    {
        // return $this->belongsTo(Customer::class,'ref_id');
        return $this->belongsTo(Customer::class,'ref_id');
    }
    public function finacount_expenc()
    {
        return $this->belongsTo(IncomeExp::class,'ref_id');
    }
    public function tr_currency()
    {
        return $this->belongsTo(Currency::class,'currency');
    }
    public function eq_transaction()
    {
        return $this->belongsTo(Currency::class,'currency_equal');
    }

   public function financeAccount(){
            return $this->belongsTo(FinanceAccount::class,'finance_acount_id');
         
    }

    public function bank_account(){
        return $this->belongsTo(FinanceAccount::class,'bank_acount_id');
     
}

     
        public function incomeExp1(){
            return $this->hasMany(IncomeExp::class,'bank_id');
        }

        public function customer_exchange()
        {
            return $this->belongsTo(Customer::class);
        }

}
