<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FonnteService;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    protected $fonnteService;

    public function __construct(FonnteService $fonnteService)
    {
        $this->fonnteService = $fonnteService;
    }

    public function index()
    {
        $page_title = 'All Devices';

        return view('devices.index', compact('devices', 'page_title'));
    }

    public function sendMessage(Request $request)
    {
        // Validasi input untuk memastikan target dan pesan ada dan valid
        $request->validate([
            'target'    => 'required|string',
            'message'   => 'required|string',
        ]);

        // Ambil target dan pesan dari body request
        $target         = $request->input('target');
        $message        = $request->input('message');
        $deviceToken    = $request->input('device_token');

        // Kirim pesan menggunakan FonnteService
        $response = $this->fonnteService->sendWhatsAppMessage($target, $message, $deviceToken);

        // Periksa apakah API Fonnte mengembalikan status false
        if (!$response['status'] || (isset($response['data']['status']) && !$response['data']['status'])) {
            // Jika terjadi error atau status false, kembalikan pesan error
            $errorReason = $response['data']['reason'] ?? 'Unknown error occurred';
            return response()->json(['message' => 'Error', 'error' => $errorReason], 500);
        }

        // Jika berhasil, kembalikan pesan sukses
        return response()->json([
            'message' => 'Pesan berhasil dikirim!',
            'data' => $response['data']
        ]);
    }

    // Method untuk memvalidasi header Authorization dan API Key
    protected function validateHeaders($authorizationHeader, $deviceToken)
    {
        if (empty($authorizationHeader)) {
            return response()->json(['message' => 'Authorization header is required'], 401);
        }

        if ($authorizationHeader != $deviceToken) {
            return response()->json(['message' => 'Invalid Device Authorization Token!'], 401);
        }

        return null; // No errors
    }
}
