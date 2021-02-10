<?php

namespace App;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use FormatDate;

    public function supplier()
    {
        return $this->hasMany(Supplier::class);
    }
}
