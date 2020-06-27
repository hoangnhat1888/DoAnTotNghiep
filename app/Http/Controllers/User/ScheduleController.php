<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\WorkSchedule;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleController extends Controller
{
    //Khoi tao view check
    public function index()
    {
        $schedules = Schedule::all();
        return view('user.Schedule', compact('schedules'));
    }
}
