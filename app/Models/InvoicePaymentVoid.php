<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePaymentVoid extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_payment_id',
        'reason',
        'voided_date',
        'volided_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'invoice_payment_id' => 'integer',
        'voided_date' => 'date',
        'volided_by' => 'integer',
    ];


    public function invoicePayment()
    {
        return $this->belongsTo(\App\Models\InvoicePayment::class);
    }

    public function volidedBy()
    {
        return $this->belongsTo(\App\Models\VolidedBy::class);
    }
}
