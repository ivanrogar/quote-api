<?php

declare(strict_types=1);

namespace App\Contract\Search;

/**
 * Interface CriteriaInterface
 * @package App\Contract\Search
 */
interface CriteriaInterface
{
    /**
     * @return string
     */
    public function getAuthorSlug(): string;

    /**
     * @return int
     */
    public function getLimit(): int;
}
