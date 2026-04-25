<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class IDVerificationController extends Controller
{
    public function scan(Request $request)
    {
        $request->validate([
            'image' => 'required|string',
        ]);

        $response = Http::withHeaders([
            'X-API-KEY'    => env('IDANALYZER_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api2.idanalyzer.com/scan', [
            'document'    => $request->image,
            'saveFile'    => false,
            'outputImage' => true,
            'outputFace'  => true,
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Could not read ID. Please upload a clearer photo.'
            ], 422);
        }

        $data = $response->json();

        if (isset($data['error'])) {
            return response()->json([
                'error' => $data['error']['message'] ?? 'ID scan failed.'
            ], 422);
        }

        $r = $data['result'] ?? [];

        return response()->json([
            'firstName'   => $r['firstName']  ?? $r['givenName']  ?? '',
            'lastName'    => $r['lastName']   ?? $r['surname']    ?? '',
            'middleName'  => $r['middleName'] ?? '',
            'dateOfBirth' => isset($r['dob']) ? str_replace('/', '-', $r['dob']) : '',
            'sex'         => isset($r['sex'])
                ? (strtolower($r['sex'][0]) === 'm' ? 'Male' : 'Female')
                : '',
            'address'     => $r['address1'] ?? $r['address'] ?? '',
            'face'        => $data['face']   ?? null,
        ]);
    }
}