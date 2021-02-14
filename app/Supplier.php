<?php

namespace App;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use FormatDate;

    protected $guarded = [];

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }
}
