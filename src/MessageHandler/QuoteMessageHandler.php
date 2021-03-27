<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Contract\Cache\CacheTypeInterface;
use App\Message\QuoteMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Throwable;

/**
 * Class QuoteMessageHandler
 * @package App\MessageHandler
 */
class QuoteMessageHandler implements MessageHandlerInterface
{
    private CacheTypeInterface $cacheType;
    private LoggerInterface $logger;

    /**
     * QuoteMessageHandler constructor.
     * @param CacheTypeInterface $cacheType
     * @param LoggerInterface $logger
     */
    public function __construct(CacheTypeInterface $cacheType, LoggerInterface $logger)
    {
        $this->cacheType = $cacheType;
        $this->logger = $logger;
    }

    public function __invoke(QuoteMessage $message)
    {
        try {
            $this->cacheType->set($message->getCacheKey(), serialize($message->getQuotes()));
        } catch (Throwable $exception) {
            $this
                ->logger
                ->error(
                    'Failed to save quotes to cache: ' . $exception->getMessage(),
                    [
                        'exception' => $exception
                    ]
                );
        }
    }
}
