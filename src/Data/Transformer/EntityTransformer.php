<?php

declare(strict_types=1);

namespace App\Data\Transformer;

use App\Contract\Entity\QuoteInterface;
use App\Contract\Search\CriteriaInterface;
use App\Data\Quote;
use App\Data\QuoteCollection;
use Webmozart\Assert\Assert;

/**
 * Class EntityTransformer
 * @package App\Data\Converter
 * @SuppressWarnings(Static)
 */
final class EntityTransformer
{
    /**
     * @param QuoteInterface[] $input
     * @param CriteriaInterface $criteria
     * @return QuoteCollection
     */
    public function transform($input, CriteriaInterface $criteria): QuoteCollection
    {
        Assert::isIterable($input) && Assert::allImplementsInterface($input, QuoteInterface::class);

        $data = [];

        foreach ($input as $item) {
            $data[] = new Quote(
                \mb_strtoupper($item->getText()) . '!',
                $item->getAuthor()->getSlug()
            );
        }

        return new QuoteCollection($data, $criteria);
    }
}
