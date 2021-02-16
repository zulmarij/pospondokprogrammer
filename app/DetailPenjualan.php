<?php

namespace App;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use FormatDate;

    protected $guarded = [];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class);
    }
}
