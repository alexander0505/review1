<?php

namespace solution\src\Integration;

use solution\src\DTO\AuthData;

class Client implements ClientInterface
{
    /** @var AuthData  */
    private $auth;

    /**
     * @param AuthData $auth
     */
    public function __construct(AuthData $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param array $request
     *
     * @return array
     */
    public function get(array $request): array
    {
        // returns a response from external service
    }
}