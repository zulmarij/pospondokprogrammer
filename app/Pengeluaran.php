<?php

namespace App;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use FormatDate;

    protected $guarded = [];
}
