<?php

declare(strict_types=1);

namespace App\Entity;

use App\Contract\Entity\AuthorInterface;
use App\Contract\Entity\QuoteInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Quote
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Table(name="quote")
 * @SuppressWarnings(Short)
 */
class Quote implements QuoteInterface
{
    use TimeStampTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $text;

    /**
     * @ORM\ManyToOne(targetEntity="App\Contract\Entity\AuthorInterface", inversedBy="quotes")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $author;

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @inheritDoc
     */
    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAuthor(): ?AuthorInterface
    {
        return $this->author;
    }

    /**
     * @inheritDoc
     */
    public function setAuthor(AuthorInterface $author): self
    {
        $this->author = $author;
        return $this;
    }
}
