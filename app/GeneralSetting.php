<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeneralSetting extends Model
{
    protected $fillable =[

        "site_title", "site_logo", "is_rtl", "currency", "currency_position", "staff_access", "date_format", "theme", "developed_by", "invoice_format", "state"
    ];

    public function currencies()
    {
    	return $this->belongsTo('App\Currency');
    }

}
