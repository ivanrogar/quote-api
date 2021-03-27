<?php

declare(strict_types=1);

namespace App\Contract\Entity;

/**
 * Interface AuthorInterface
 * @package App\Contract\Entity
 */
interface AuthorInterface extends EntityInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self;

    /**
     * @return string
     */
    public function getSlug(): string;

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug(string $slug): self;

    /**
     * @return QuoteInterface[]
     */
    public function getQuotes();

    /**
     * @param QuoteInterface $quote
     * @return $this
     */
    public function addQuote(QuoteInterface $quote): self;

    /**
     * @param QuoteInterface $quote
     * @return $this
     */
    public function removeQuote(QuoteInterface $quote): self;

    /**
     * @return $this
     */
    public function clearQuotes(): self;
}
