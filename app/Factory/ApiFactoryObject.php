<?php

namespace App\Factory;

abstract class ApiFactoryObject
{
    protected string $apiUrl;
    protected object $response;

    /**
     * Class constructor.
     *
     * @param string $apiUrl
     * @param object $response
     */
    public function __construct(string $apiUrl, object $response)
    {
        $this->apiUrl = $apiUrl;
        $this->response = $response;
    }

    /**
     * Factory an object.
     *
     * @return static
     */
    public static final function factory(string $apiUrl, object $response): static
    {
        return new static($apiUrl, $response);
    }

    /**
     * Validate the object shape.
     *
     * @return boolean
     */
    abstract public function isValid(): bool;
}
