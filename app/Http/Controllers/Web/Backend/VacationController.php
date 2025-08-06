<?php

namespace App\Http\Controllers\Web\Backend;
use App\Models\Vacation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class VacationController extends Controller
{
    /**
     * Store vacation date time
     * @param Request $request
     * @return response
     */

    public function index(): View
    {
        // Get the current date and time
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');

        $vacation = Vacation::first();

        return view('backend.layouts.vacation.index', compact('vacation'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|date_format:Y-m-d H:i',
            'end_date' => 'required|date|date_format:Y-m-d H:i',
        ]);

        Vacation::updateOrCreate(
            [
                'id' => 1,
            ],
            [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]
        );

        return redirect()->back()->with('t-success', 'Vacation date time updated successfully.');
    }
}
