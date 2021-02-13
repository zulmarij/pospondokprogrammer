<?php

namespace App;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use FormatDate;

    protected $guarded = [];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function pembelian()
    {
        return $this->hasOne(Pembelian::class);
    }
}
