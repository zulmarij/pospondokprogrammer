<?php

namespace App;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use FormatDate;

    protected $guarded = [];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}
