<?php

namespace App;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use FormatDate;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class);
    }
}
