<?php

namespace App\Observers;

use App\Models\DonationItem;

class DonationItemObserver
{
    public function created(DonationItem $donationItem)
    {
        // Lógica se necessário
    }

    public function updated(DonationItem $donationItem)
    {
        // Lógica se necessário
    }

    public function deleted(DonationItem $donationItem)
    {
        // Lógica se necessário
    }
}
