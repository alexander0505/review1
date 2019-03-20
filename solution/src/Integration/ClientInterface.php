<?php

namespace solution\src\Integration;

interface ClientInterface
{
    public function get(array $request): array;
}