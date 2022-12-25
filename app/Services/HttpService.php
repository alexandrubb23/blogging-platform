<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

use App\Interfaces\Services\HttpServiceInterface;

class HttpService implements HttpServiceInterface
{
  /**
   * @return \Illuminate\Http\Client\Response
   */
  public function get(string $url): \Illuminate\Http\Client\Response
  {
    return Http::get($url);
  }
}
