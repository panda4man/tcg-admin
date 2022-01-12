<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeriesResource;
use App\Models\Series;

class SeriesController extends Controller
{
    public function index()
    {
        return SeriesResource::collection(
            Series::with('game')
                  ->orderBy('set_number')
                  ->get()
        );
    }
}
