<?php

namespace App\Exceptions;

use Exception;

use Illuminate\Support\Facades\Log;

class BlogPostCanNotBeCreatedException extends Exception
{
    /**
     * Report or log the exception.
     *
     * @return void
     */
    public function report()
    {
        Log::error('Blog post can not be created.', [
            'message' => $this->getMessage(),
        ]);
    }
}
