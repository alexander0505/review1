<?php

namespace solution\src\Decorator;

use DateTime;
use Exception;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use solution\src\DTO\RequestData;
use solution\src\Integration\ClientInterface;

class DecoratorManager implements DecoratorService
{
    /** @var CacheItemPoolInterface  */
    private $cache;

    /** @var LoggerInterface  */
    private $logger;

    /** @var ClientInterface  */
    private $client;

    /**
     * @param ClientInterface $client
     * @param CacheItemPoolInterface $cache
     * @param LoggerInterface $logger
     */
    public function __construct(ClientInterface $client, CacheItemPoolInterface $cache, LoggerInterface $logger)
    {
        $this->cache = $cache;
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse(RequestData $input): array
    {
        $result = [];

        try {
            $cacheKey = $this->getCacheKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);

            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }

            if ($result = $this->client->get($input)) {
                $cacheItem
                    ->set($result)
                    ->expiresAt(
                        (new DateTime())->modify('+1 day')
                    );
            }

        } catch (Exception $e) {
            $this->logger->critical('Error: ' . $e->getMessage());
        }

        return $result;
    }

    /**
     * @param RequestData $input
     *
     * @return string
     */
    protected function getCacheKey(RequestData $input): string
    {
        return json_encode($input);
    }
}