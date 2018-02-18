<?php

namespace App\Http\Controllers;

use App\Grow;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    public function __invoke($growId)
    {
    	$report = Grow::find($growId)->generateReport();

    	return view('summary.index', compact('report'));
    }
}
