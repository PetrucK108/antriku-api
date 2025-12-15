<?php

namespace App\Http\Controllers;

use App\Models\TrService;
use App\Models\MsService;
use Carbon\Carbon;

class DisplayController extends Controller
{
    public function displayAllServices()
    {
        $today = Carbon::today();

        $services = MsService::all();

        $result = $services->map(function ($service) use ($today) {

            // Ambil assigned users
            $staffs = $service->getAssignedUsers()->pluck('name');

            // Antrian yang sedang dipanggil
            $currentQueue = TrService::with('user')
                ->where('service_id', $service->id)
                ->where('queue_date', $today)
                ->where('status', 'processing')
                ->orderBy('queue_number')
                ->first();

            // Antrian berikutnya
            $nextQueue = TrService::with('user')
                ->where('service_id', $service->id)
                ->where('queue_date', $today)
                ->where('status', 'waiting')
                ->orderBy('queue_number')
                ->first();

            return [
                'service_id'     => $service->id,
                'service_name'   => $service->name,
                'service_code'   => $service->code, // tambahkan kode service
                'staff_names'    => $staffs,

                'current_queue' => $currentQueue ? [
                    'queue_number'  => $service->code . $currentQueue->queue_number, // gabung code + nomor
                    'customer_name' => $currentQueue->user->name ?? null,
                ] : null,

                'next_queue' => $nextQueue ? [
                    'queue_number'  => $service->code . $nextQueue->queue_number, // gabung code + nomor
                    'customer_name' => $nextQueue->user->name ?? null,
                ] : null,
            ];
        });

        return response()->json([
            'date' => $today->toDateString(),
            'data' => $result
        ]);
    }
}
