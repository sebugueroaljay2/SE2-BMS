<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function barangay_request(): HasMany {
        return $this->hasMany(BarangayRequest::class, 'request_type_id');
    }
}
