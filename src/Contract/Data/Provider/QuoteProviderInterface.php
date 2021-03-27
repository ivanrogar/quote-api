<?php

declare(strict_types=1);

namespace App\Contract\Data\Provider;

use App\Contract\Data\QuoteCollectionInterface;
use App\Contract\Search\CriteriaInterface;

/**
 * Interface QuoteProviderInterface
 * @package App\Contract\Data\Provider
 */
interface QuoteProviderInterface
{
    /**
     * The provider might or might not support a certain query type in the future
     *
     * @param CriteriaInterface $criteria
     * @return bool
     */
    public static function supports(CriteriaInterface $criteria): bool;

    /**
     * @return string
     */
    public function getProviderCode(): string;

    /**
     * @param CriteriaInterface $criteria
     * @return QuoteCollectionInterface
     */
    public function fetch(CriteriaInterface $criteria): QuoteCollectionInterface;
}
