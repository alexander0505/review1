<?php

namespace solution\src\Decorator;

use solution\src\DTO\RequestData;

interface DecoratorService
{
    /**
     * @param RequestData $input
     *
     * @return array
     */
    public function getResponse(RequestData $input) : array;
}
