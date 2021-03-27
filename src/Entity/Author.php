<?php

declare(strict_types=1);

namespace App\Entity;

use App\Contract\Entity\AuthorInterface;
use App\Contract\Entity\QuoteInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Author
 * @package App\Entity
 * @SuppressWarnings(Short)
 * @ORM\Entity
 * @ORM\Table(name="author")
 */
class Author implements AuthorInterface
{
    use TimeStampTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $slug;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Contract\Entity\QuoteInterface", cascade={"persist", "remove"},
     *     mappedBy="author"
     * )
     */
    private $quotes;

    public function __construct()
    {
        $this->quotes = new ArrayCollection();
    }

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @inheritDoc
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getQuotes()
    {
        return $this->quotes->toArray();
    }

    /**
     * @inheritDoc
     */
    public function addQuote(QuoteInterface $quote): self
    {
        if (!$this->quotes->contains($quote)) {
            $this->quotes->add($quote);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function removeQuote(QuoteInterface $quote): self
    {
        if ($this->quotes->contains($quote)) {
            $this->quotes->removeElement($quote);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function clearQuotes(): self
    {
        $this->quotes->clear();
        return $this;
    }
}
