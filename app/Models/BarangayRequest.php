<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayRequest extends Model // Consider renaming to avoid confusion with Laravel's Request
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'request_type_id',
        'payment_type_id',
        'reference_no',
        'status_id',
        'or_no',
        'pick_up_date',
        'tracking_code',
        'purposes',
    ];

    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }
    
    public function request_type()
    {
        return $this->belongsTo(Service::class, 'request_type_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}