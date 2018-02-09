<?php
namespace App\Observers;

use App\FeedsConsumption;

class FeedsConsumptionObserver
{

    public function updated(FeedsConsumption $feedsConsumption)
    {
        $feedsConsumption->saveLog();
    }

    public function created(FeedsConsumption $feedsConsumption)
    {
        $feedsConsumption->saveLog();
    }

    public function deleting(FeedsConsumption $feedsConsumption)
    {
        $feedsConsumption->log()->delete();
    }
}
