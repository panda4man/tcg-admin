<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardResource;
use App\Models\Card;
use Illuminate\Http\Request;

class CardsController extends Controller
{
    public function index()
    {
        return CardResource::collection(
            Card::withOnly(['series', 'culture', 'rarity'])->paginate(15)
        );
    }
}
