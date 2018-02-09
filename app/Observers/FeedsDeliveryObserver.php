<?php
namespace App\Observers;

use App\FeedsDelivery;

class FeedsDeliveryObserver
{

    public function updated(FeedsDelivery $feedsDelivery)
    {
        $feedsDelivery->saveLog();
    }

    public function created(FeedsDelivery $feedsDelivery)
    {
        $feedsDelivery->saveLog();
    }

    public function deleting(FeedsDelivery $feedsDelivery)
    {
        $feedsDelivery->log()->delete();
    }
}
