<?php

declare(strict_types=1);

namespace App\Model\Search;

use Webmozart\Assert\Assert;

/**
 * Class Builder
 * @package App\Model\Search
 * @SuppressWarnings(Static)
 */
final class Builder
{
    private ?string $authorSlug = null;
    private int $limit = 10;

    /**
     * @param string $authorSlug
     * @return $this
     */
    public function withAuthorSlug(string $authorSlug): self
    {
        $this->authorSlug = $authorSlug;
        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function withLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @return Criteria
     */
    public function build(): Criteria
    {
        Assert::notNull($this->authorSlug);

        $criteria = new Criteria($this->authorSlug, $this->limit);

        $this->clear();

        return $criteria;
    }

    /**
     * @return $this
     */
    private function clear(): self
    {
        $this->authorSlug = null;
        $this->limit = 10;

        return $this;
    }
}
