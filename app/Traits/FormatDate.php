<?php

namespace App\Traits;

use Carbon\Carbon;

trait FormatDate
{
    protected $newDateFormat = 'l, d F Y';

    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat($this->newDateFormat);
    }

    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->diffForHumans();
    }

    public function getEmailVerifiedAtAttribute()
    {
        if ($this->attributes['email_verified_at'] == null) {
            return $this->attributes['email_verified_at'] = null;
        }else {
            return Carbon::parse($this->attributes['email_verified_at'])->translatedFormat($this->newDateFormat);
        }
    }
}
