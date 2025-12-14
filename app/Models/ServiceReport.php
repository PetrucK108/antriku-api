<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceReport extends Model
{
    use HasFactory;

    protected $table = 'service_reports';

    protected $fillable = [
        'report_date',
        'created_by',
        'file_path',
    ];

    public function creator()
    {
        return $this->belongsTo(MsUser::class, 'created_by');
    }
}
