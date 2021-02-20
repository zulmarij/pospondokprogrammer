<?php

namespace App;

use App\Traits\FormatDate;
use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    use FormatDate;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
