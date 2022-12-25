<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

use App\Interfaces\Services\HttpServiceInterface;

class HttpService implements HttpServiceInterface
{
    /**
     * @inheritdoc
     */
    public function get(string $url): \Illuminate\Http\Client\Response
    {
        return Http::get($url);
    }

    /**
     * @inheritdoc
     */
    public function getAsObject(string $url): object
    {
        return $this->get($url)->object();
    }
}
