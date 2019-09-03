<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stats() : Response
    {
        $stats = [
            // CODE CHALLENGE: Active Domains
            'active' => 0,
            // CODE CHALLENGE: Trashed Domains
            'trash' => 0,
            // CODE CHALLENGE: Internationalized Domains
            'internationalized' => 0,
            // CODE CHALLENGE: Imprinted Domains
            'imprinted' => 0
        ];
        // Create HTTP response, 200 ok.
        $response = new Response($stats, Response::HTTP_OK);
        // Return HTTP response.
        return $response;
    }
}
