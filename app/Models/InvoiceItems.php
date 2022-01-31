<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItems extends Model
{
    use HasFactory;

    //public $table = "invoice_items";

    protected $fillable = ['service_name', 'unit_price', 'quantity'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class); // belongsTo // hasOne
    }
}
