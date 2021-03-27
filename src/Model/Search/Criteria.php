<?php

declare(strict_types=1);

namespace App\Model\Search;

use App\Contract\Search\CriteriaInterface;

/**
 * Class Criteria
 * @package App\Model\Search
 */
final class Criteria implements CriteriaInterface
{
    private string $authorSlug;
    private int $limit = 10;

    /**
     * Criteria constructor.
     * @param string $authorSlug
     * @param int $limit
     */
    public function __construct(string $authorSlug, int $limit)
    {
        $this->authorSlug = $authorSlug;
        $this->limit = $limit;
    }

    /**
     * @return string
     */
    public function getAuthorSlug(): string
    {
        return $this->authorSlug;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }
}
