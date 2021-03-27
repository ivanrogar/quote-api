<?php

declare(strict_types=1);

namespace App\Contract\Entity;

/**
 * Interface QuoteInterface
 * @package App\Contract\Entity
 */
interface QuoteInterface extends EntityInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getText(): string;

    /**
     * @param string $text
     * @return $this
     */
    public function setText(string $text): self;

    /**
     * @return AuthorInterface|null
     */
    public function getAuthor(): ?AuthorInterface;

    /**
     * @param AuthorInterface $author
     * @return $this
     */
    public function setAuthor(AuthorInterface $author): self;
}
