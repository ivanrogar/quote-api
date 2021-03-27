<?php

declare(strict_types=1);

namespace App\Data;

use App\Contract\Data\QuoteInterface;

/**
 * Class Quote
 * @package App\Data
 */
final class Quote implements QuoteInterface
{
    private string $text;
    private string $authorSlug;

    /**
     * Quote constructor.
     * @param string $text
     * @param string $authorSlug
     */
    public function __construct(string $text, string $authorSlug)
    {
        $this->text = $text;
        $this->authorSlug = $authorSlug;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getAuthorSlug(): string
    {
        return $this->authorSlug;
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return \json_encode(
            [
                'text' => $this->text,
                'authorSlug' => $this->authorSlug
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        $data = \json_decode($serialized, true);

        $this->text = $data['text'];
        $this->authorSlug = $data['authorSlug'];
    }
}
