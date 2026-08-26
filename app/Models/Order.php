<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'buyer_id',
        'service_id',
        'requirements',
        'deadline',
        'notes',
        'result_file',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    //user yang membeli jasa
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    //jasa yang dipesan 
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    
}
