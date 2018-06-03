<?php

namespace App\Http\Controllers;

use App\Grow;

class HarvestReportController extends Controller
{
    public function __invoke(Grow $grow)
    {
        $grow->load('harvests.line');

        return view('harvest-report', compact('grow'));
    }
}
