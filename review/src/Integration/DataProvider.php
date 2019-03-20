<?php

namespace src\Integration;

class DataProvider
{
    private $host; // нет phpdoc
    private $user; // нет phpdoc
    private $password; // нет phpdoc

    /**
     * @param $host // не указан тип string
     * @param $user // не указан тип string
     * @param $password // не указан тип string
     */
    public function __construct($host, $user, $password) // не указан тип для аргументов host, user, password
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @param array $request
     *
     * @return array
     */
    public function get(array $request) // не указан тип возвращаемого значения :array. И в целом, лучше передавать объект DTO для большей прозрачности
    {
        // returns a response from external service
    }
}
