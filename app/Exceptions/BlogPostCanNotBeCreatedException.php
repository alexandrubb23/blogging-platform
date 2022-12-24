<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class BlogPostCanNotBeCreatedException extends Exception
{
    const CREATE_ERROR_MESSAGE = 'Blog post can not be created.';

    /**
     * Class constructor.
     */
    public function __construct(QueryException $ex)
    {
        parent::__construct($ex->getMessage());
    }

    /**
     * Report or log the exception.
     *
     * @return void
     */
    public function report()
    {
        Log::error(self::CREATE_ERROR_MESSAGE, [
            'message' => $this->getMessage(),
        ]);
    }
}
