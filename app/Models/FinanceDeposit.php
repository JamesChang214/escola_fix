<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceDeposit extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'finance_deposits';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    protected $fillable = [
        'deposited_date',
        'centre_id',
        'syear',
        'payment_type_id',
        'amount',       
        'deposited_by',
        'description',
        'status',
        'source',
    ];

    protected $casts = [
        'id' => 'integer',
        'invoice_id' => 'integer',
        'centre_id' => 'integer',
        'amount' => 'decimal:2',
        'payment_type_id' => 'integer',
        'deposited_date' => 'date',
        'user_id' => 'integer',
    ];

    public function paymentType()
    {
        return $this->belongsTo(\App\Models\PaymentType::class);
    }

  
}
