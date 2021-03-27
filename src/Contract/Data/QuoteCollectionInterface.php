<?php

declare(strict_types=1);

namespace App\Contract\Data;

use App\Contract\Search\CriteriaInterface;
use Iterator;

/**
 * Interface QuoteCollectionInterface
 * @package App\Contract\Data
 */
interface QuoteCollectionInterface
{
    /**
     * @return Iterator|QuoteInterface[]
     */
    public function getItems();

    /**
     * @return int
     */
    public function getCount(): int;

    /**
     * @return CriteriaInterface
     */
    public function getCriteria(): CriteriaInterface;

    /**
     * @return array
     */
    public function toArray(): array;
}
