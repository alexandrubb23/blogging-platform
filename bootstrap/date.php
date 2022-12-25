<?php

use Carbon\Carbon;

function getCurrentDateAndTime()
{
  return Carbon::now()->toDateTimeString();
}
