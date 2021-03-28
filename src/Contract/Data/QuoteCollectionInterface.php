<?php

declare(strict_types=1);

namespace App\Contract\Data;

use App\Contract\Search\CriteriaInterface;
use Iterator;
use Countable;

/**
 * Interface QuoteCollectionInterface
 * @package App\Contract\Data
 */
interface QuoteCollectionInterface extends Countable
{
    /**
     * @return Iterator|QuoteInterface[]
     */
    public function getItems();

    /**
     * @return CriteriaInterface
     */
    public function getCriteria(): CriteriaInterface;

    /**
     * @return array
     */
    public function toArray(): array;
}
