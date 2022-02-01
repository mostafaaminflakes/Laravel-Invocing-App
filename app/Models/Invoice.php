<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'invoice_number', 'client_name', 'client_vat_number', 'project_name', 'project_number', 'notes'];

    public function items()
    {
        return $this->hasMany(InvoiceItems::class);
    }
}
