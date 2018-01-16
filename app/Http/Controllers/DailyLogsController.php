<?php

namespace App\Http\Controllers;

use App\DailyLog;
use App\Deck;
use App\Feed;
use App\Grow;
use App\Http\Requests\DailyLogRequest;
use App\Programs\FeedingProgramReference;
use DB;
use Illuminate\Http\Request;

class DailyLogsController extends Controller
{
    public function index(Grow $grow, Request $request)
    {
        return view('grows.daily-logs-index', [
            'grow' => $grow->load(['dailyLogs' => function ($query) {
                $query->orderBy('day_count');
            }]),
        ]);
    }

    public function create(Grow $grow, Request $request)
    {
        $logCount = $grow->dailyLogs()->count() + 1;
        $program = FeedingProgramReference::getProgram($logCount);
        $feeds = Feed::orderBy('description')->get();
        $decks = Deck::whereIn('id', $grow->decksUsed())->with('building')->get();

        return view('grows.daily-logs', [
            'program' => $program,
            'grow' => $grow,
            'feeds' => $feeds,
            'decks' => $decks,
        ]);
    }

    public function edit(Grow $grow, DailyLog $dailyLog, Request $request)
    {
        $feeds = Feed::orderBy('description')->get();
        $decks = Deck::whereIn('id', $grow->decksUsed())->with('building')->get();
        $program = FeedingProgramReference::getProgram($dailyLog->day_count);

        return view('grows.daily-logs', [
            'program' => $program,
            'data' => $dailyLog->load(['mortalities', 'feedsConsumption', 'feedsDeliveries', 'weightRecords']),
            'grow' => $grow->load('dailyLogsCount'),
            'feeds' => $feeds,
            'decks' => $decks,
        ]);
    }

    public function store(Grow $grow, DailyLogRequest $request)
    {
        DB::transaction(function () use ($grow, $request) {
            $log = $grow->dailyLogs()->create([
                'day_count' => $grow->dailyLogs()->count() + 1,
                'remarks' => $request->remarks,
            ]);

            $log->mortalities()->createMany($request->mortality);
            $log->feedsConsumption()->createMany($request->consumption);
            $log->feedsDeliveries()->createMany($request->delivery);
            $log->weightRecords()->createMany($request->weight);
        });

        return redirect(route('grows.daily-logs.index', ['grow' => $grow->id]));

    }

    public function update(Grow $grow, DailyLog $dailyLog, DailyLogRequest $request)
    {
        DB::transaction(function () use ($grow, $dailyLog, $request) {
            $grow->update([
                'remarks' => $request->remarks,
            ]);

            collect($request->consumption)->each(function ($consumption) use ($dailyLog) {
                if (isset($consumption['id'])) {
                    $dailyLog->feedsConsumption()->whereId($consumption['id'])->update(array_except($consumption, ['id']));
                } else {
                    $dailyLog->feedsConsumption()->create($consumption);
                }
            });

            collect($request->mortality)->each(function ($mortality) use ($dailyLog) {
                if (isset($mortality['id'])) {
                    $dailyLog->mortalities()->whereId($mortality['id'])->update(array_except($mortality, ['id']));
                } else {
                    $dailyLog->mortalities()->create($mortality);
                }
            });

            collect($request->delivery)->each(function ($delivery) use ($dailyLog) {
                if (isset($delivery['id'])) {
                    $dailyLog->feedsDeliveries()->whereId($delivery['id'])->update(array_except($delivery, ['id']));
                } else {
                    $dailyLog->feedsDeliveries()->create($delivery);
                }
            });

            collect($request->weight)->each(function ($weight) use ($dailyLog) {
                if (isset($weight['id'])) {
                    $dailyLog->weightRecords()->whereId($weight['id'])->update(array_except($weight, ['id']));
                } else {
                    $dailyLog->weightRecords()->create($weight);
                }
            });
        });

        return redirect(route('grows.daily-logs.index', ['grow' => $grow->id]));
    }
}
