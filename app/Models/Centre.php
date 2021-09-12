<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Centre extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    //use HasFactory, SoftDeletes;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'short_name',
        '2c_name',
        'regno',
        'fyending',
        'address1',
        'address2',
        'address3',
        'address4',
        'city',
        'state',
        'country',
        'postal_code',
        'area_code',
        'phone',
        'email',
        'www',
        'contact',
        'calendar',
        'logo',
        'logo_small',
        'currency',
        'invoice_number_type',
        'invoice_number_format',
        'receipt_number_format',
        'invoice_template',
        'receipt_template',
        'contra_template',
        'refund_template',
        'payment_insturctions1',
        'payment_instructions2',
        'credit_instructions',
        'next_invoice_no',
        'next_adjustment_no',
        'next_receipt_no',
        'next_refund_no',
        'next_contra_no',
        'next_expense_no',
        'next_expense_payment_no',
        'next_claim_no',
        'next_journal_no',
        'cash_on_hand',
        'created_user_id',
        'edited_user_id',
        'deleted_user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'fyending' => 'date',
        'cash_on_hand' => 'decimal:2',
        'created_user_id' => 'integer',
        'edited_user_id' => 'integer',
        'deleted_user_id' => 'integer',
    ];


    public function createdUser()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function editedUser()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function deletedUser()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
