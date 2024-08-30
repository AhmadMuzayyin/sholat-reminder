<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use App\Models\AlarmLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function getLocation()
    {
        if (request()->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Data ditemukan',
                'location' => config('app.userLocation.id') == '' && config('app.userLocation.name') == '' ? config('app.defaultLocation') : config('app.userLocation'),
            ]);
        }
    }
    public function setLocation()
    {
        if (request()->ajax()) {
            $location = request()->location;
            \Config::write('app.userLocation.name', $location['lokasi']);
            \Config::write('app.userLocation.id', $location['id']);
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'location' => config('app.userLocation'),
            ]);
        }
    }
    public function getAlarm()
    {
        if (request()->ajax()) {
            $alarms = Alarm::with('logs')->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Data ditemukan',
                'alarms' => $alarms,
            ]);
        }
    }
    public function setAlarm(Request $request)
    {
        $validated = $request->validate([
            'lable' => 'required|string',
            'time' => 'required|date_format:H:i',
            'repeat' => 'required|in:daily,weekly,monthly,none',
        ]);
        try {
            $data = Alarm::create($validated);
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'alarm' => $data,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal disimpan',
                'error' => $th->getMessage(),
            ]);
        }
    }
    public function triggerAlarm(Request $request)
    {
        $validated = $request->validate([
            'alarm_id' => 'required|exists:alarms,id',
        ]);
        try {
            AlarmLog::create([
                'alarm_id' => $validated['alarm_id'],
                'triggered_at' => now(),
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Alarm berhasil diaktifkan',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Alarm gagal diaktifkan',
                'error' => $th->getMessage(),
            ]);
        }
    }
    public function deleteAlarm(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:alarms,id',
        ]);
        try {
            $data = Alarm::find($validated['id']);
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data gagal dihapus',
                'error' => $th->getMessage(),
            ]);
        }
    }
}
