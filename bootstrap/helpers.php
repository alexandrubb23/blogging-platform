<?php

function route_to($route, $params = [])
{
  return route(config('routes.' . $route), $params);
}
