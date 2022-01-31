<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_number', 'client_name', 'client_address', 'client_vat_number'];

    public function items()
    {
        return $this->hasMany(InvoiceItems::class);
    }
}
