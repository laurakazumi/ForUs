<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'cep', 'rua', 'numero', 'complemento', 'bairro', 'cidade', 'email', 'telefone', 'campaignName', 'donationType', 'startDate', 'endDate'
    ];

    public function donationItems()
    {
        return $this->hasMany(DonationItem::class);
    }
}
