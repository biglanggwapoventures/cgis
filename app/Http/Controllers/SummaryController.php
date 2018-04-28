<?php

namespace App\Http\Controllers;

use App\Grow;
use App\Services\GrowService;

class SummaryController extends Controller
{
    public function __invoke(Grow $grow)
    {
        $growService = new GrowService($grow->id);
        $chicksPerDeckInitial = $growService->getHeadsPerDeck(1);

        $grow->load([
            'dailyLogs',
            'dailyLogs.mortalities.deck',
            'dailyLogs.feedsConsumption.feed',
            'dailyLogs.feedsConsumption.deck',
            'dailyLogs.feedsDeliveries.feed',
            'dailyLogs.weightRecords.deck',
        ]);

        $feedStock = $growService->getFeedStock(optional($grow->dailyLogs[0])->id);

        // dd($grow->toArray());

        // $report = Grow::find($growId)->generateReport();
        return view('summary.index', [
            'grow' => $grow,
            'totalChicksInitial' => $chicksPerDeckInitial->values()->sum(),
            'chicksPerDeckInitial' => $chicksPerDeckInitial->toArray(),
            'feedStock' => $feedStock->toArray(),
        ]);
    }
}
