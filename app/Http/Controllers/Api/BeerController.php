<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;

class BeerController extends Controller
{
    public function index(Request $request) {
        $query = $request->all();
        $url = "https://api.punkapi.com/v2/beers";
        if(count($query) > 0) {
            $url .= "?" . Arr::query($query); 
        }
        
        $response = Http::get($url);
        return $response->json();
    }
}
