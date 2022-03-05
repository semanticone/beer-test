<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ApiTest extends TestCase
{
    /**
     * Test if an authenticated user can use the API
     *
     * @return void
     */
    public function testApiCallByAuthenticatedUser()
    {
        Auth::loginUsingId(1);
        $response = $this->json('GET', '/api/beers');

        $response->assertStatus(200);
    }

    /**
     * Test if an authenticated user can use the API
     *
     * @return void
     */
    public function testApiCallByUnauthenticatedUser()
    {
        $response = $this->json('GET', '/api/beers');

        $response->assertStatus(401);
    }

    /**
     * Test if proxy API returns the same json
     * 
     * @return void
     */
    public function testProxyApiSameJson()
    {
        Auth::loginUsingId(1);
        $proxyResponse = $this->json('GET', '/api/beers');
        $proxyJson = json_decode($proxyResponse->getContent(), true);

        $apiResponse = Http::get('https://api.punkapi.com/v2/beers');
        $apiJson = $apiResponse->json();

        $this->assertEquals($proxyJson, $apiJson);
    }

    /**
     * Test if proxy API returns the same json (with query string parameters)
     * 
     * @return void
     */
    public function testProxyApiSameJsonWithQueryStringParameters()
    {
        Auth::loginUsingId(1);
        $proxyResponse = $this->json('get', '/api/beers?page=3&per_page=12');
        $proxyJson = json_decode($proxyResponse->getContent(), true);

        $apiResponse = Http::get('https://api.punkapi.com/v2/beers?page=3&per_page=12');
        $apiJson = $apiResponse->json();

        $this->assertEquals($proxyJson, $apiJson);
    }
}
