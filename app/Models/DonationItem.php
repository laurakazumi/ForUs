<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationItem extends Model
{
    protected $fillable = [
        'campaign_id', 'item_name'
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
