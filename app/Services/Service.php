<?php 
namespace App\Services;

use Illuminate\Support\Facades\Http;

abstract class Service 
{
    protected $baseUrl;

    /*
    * Handle call api as json
    */
    public function callApi(?string $url = null) 
    {
        return Http::asJson()->acceptJson()->baseUrl($url ?? $this->baseUrl ?? '');
    }

}