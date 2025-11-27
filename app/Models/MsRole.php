<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MsUser;
class MsRole extends Model
{
    protected $table = "msrole";

    protected $fillable = [
        'name'
    ];

    public function user(){
        return $this->hasMany(MsUser::class, 'roleId');
    }
}
