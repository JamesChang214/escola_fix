<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'student_id',
        'centre_id',
        'syear',
        'receipt_number',
        'amount',
        'payment_type_id',
        'private_note',
        'public_note',
        'cheuque_number',
        'bank_name',
        'cleared',
        'cleared_date',
        'user_id',
        'status',
        'source',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'invoice_id' => 'integer',
        'student_id' => 'integer',
        'centre_id' => 'integer',
        'amount' => 'decimal:2',
        'payment_type_id' => 'integer',
        'cleared_date' => 'date',
        'user_id' => 'integer',
    ];


    public function invoice()
    {
        return $this->belongsTo(\App\Models\Invoice::class);
    }

    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class);
    }

    public function centre()
    {
        return $this->belongsTo(\App\Models\Centre::class);
    }

    public function paymentType()
    {
        return $this->belongsTo(\App\Models\PaymentType::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function financeDeposit()
    {
        return $this->hasOne(\App\Models\FinanceDeposit::class, 'link_id');
    }

}
