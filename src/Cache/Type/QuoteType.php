<?php

declare(strict_types=1);

namespace App\Cache\Type;

use App\Contract\Cache\CacheTypeInterface;

/**
 * Class QuoteType
 * @package App\Cache\Type
 * @SuppressWarnings(Static)
 */
final class QuoteType extends AbstractType implements CacheTypeInterface
{
    /**
     * @inheritDoc
     */
    public static function getName(): string
    {
        return 'quote_type';
    }
}
