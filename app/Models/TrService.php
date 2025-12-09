<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrService extends Model
{
    use HasFactory;

    protected $table = 'tr_services';

    protected $fillable = [
        'service_id',
        'user_id',
        'queue_number',
        'status',
        'queue_date',
        'estimated_time'
    ];

    // Relasi ke Service
    public function service()
    {
        return $this->belongsTo(MsService::class, 'service_id');
    }

    // Relasi ke User (Customer)
    public function user()
    {
        return $this->belongsTo(MsUser::class, 'user_id');
    }
}
