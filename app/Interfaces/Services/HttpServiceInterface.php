<?php

namespace App\Interfaces\Services;

interface HttpServiceInterface
{
  /**
   * @return \Illuminate\Http\Client\Response
   */
  public function get(string $url): \Illuminate\Http\Client\Response;

  /**
   * @return object
   */
  public function getAsObject(string $url): object;
}
