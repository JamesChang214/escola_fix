<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'short_name',
        'syear',
        'centre_id',
        'processing_fee',
        'processing_percentage',
        'is_usable',
        'account_id',
        'globaluse',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'centre_id' => 'integer',
        'processing_fee' => 'decimal:2',
        'processing_percentage' => 'decimal:2',
        'globaluse' => 'boolean',
    ];


    public function centre()
    {
        return $this->belongsTo(\App\Models\Centre::class);
    }
}
