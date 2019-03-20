<?php

namespace src\Decorator;

use DateTime;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use src\Integration\DataProvider;

class DecoratorManager extends DataProvider
{
    public $cache; // нет phpdoc
    public $logger; // нет phpdoc

    /**
     * @param string $host
     * @param string $user
     * @param string $password
     * @param CacheItemPoolInterface $cache
     */
    public function __construct($host, $user, $password, CacheItemPoolInterface $cache) // не указан тип для аргументов host, user, password
    {
        parent::__construct($host, $user, $password);
        $this->cache = $cache;
    }

    // нет phpdoc
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger; // в сеттерах лучше всегда возвращать текущий объект, т.е. return $this, чтобы можно было использовать цепочки вызовов
    }

    //  Нет интерфейса от которого происходит наследование phpdoc
    /**
     * {@inheritdoc}
     */
    public function getResponse(array $input) // нет возвращаемого значения :array
    {
        try {
            $cacheKey = $this->getCacheKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);
            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }

            $result = parent::get($input);

            // возможно лучше добавить проверку на наличие данных в result прежде чем записывать в кэш, но это тонкий случай и зависит от требований.
            $cacheItem
                ->set($result)
                ->expiresAt(
                    (new DateTime())->modify('+1 day')
                );

            return $result;
        } catch (Exception $e) { // нужно передавать $e->getMessage() в логгер, чтобы понимать какая именно ошибка произошла
            $this->logger->critical('Error');
        }

        return []; // 3 точки выхода в одном методе, слишком много, можно объявить переменную result = [] в начале метода и вынести return $result из конструкции try catch в конец метода вместо return [];

    }

    // нет phpdoc
    public function getCacheKey(array $input) // нет возвращаемого типа string
    {
        return json_encode($input);
    }
}
