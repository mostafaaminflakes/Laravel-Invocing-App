<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItems extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['invoice_id', 'service_name', 'unit', 'completion', 'unit_price', 'quantity'];

    protected $appends = ['net_amount'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class); // belongsTo // hasOne
    }

    public function getNetAmountAttribute()
    {
        return round($this->unit_price * $this->quantity);
    }
}
