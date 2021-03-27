<?php

declare(strict_types=1);

namespace App\Message;

use App\Contract\Data\QuoteInterface;

/**
 * Class QuoteMessage
 * @package App\Message
 * @SuppressWarnings(Long)
 */
class QuoteMessage
{
    /**
     * @var QuoteInterface[]
     */
    private iterable $quotes;
    private string $cacheKey;

    /**
     * QuoteMessage constructor.
     * @param QuoteInterface[] $quotes
     * @param string $cacheKey
     */
    public function __construct($quotes, string $cacheKey)
    {
        $this->quotes = $quotes;
        $this->cacheKey = $cacheKey;
    }

    /**
     * @return QuoteInterface[]
     */
    public function getQuotes(): array
    {
        return $this->quotes;
    }

    /**
     * @return string
     */
    public function getCacheKey(): string
    {
        return $this->cacheKey;
    }
}
