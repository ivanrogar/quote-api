<?php

declare(strict_types=1);

namespace App\Fixture;

use App\Contract\Repository\AuthorRepositoryInterface;
use App\Contract\Repository\QuoteRepositoryInterface;
use App\Exception\Repository\CouldNotSaveException;
use App\Exception\Repository\NotFoundException;
use App\Model\Search\Builder;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Tools\ToolsException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class Quotes
 * @package App\Fixture
 */
final class Quotes
{
    private ManagerRegistry $registry;
    private QuoteRepositoryInterface $quoteRepository;
    private AuthorRepositoryInterface $authorRepository;
    private Slugify $slugify;
    private Builder $builder;

    /**
     * Quotes constructor.
     * @param ManagerRegistry $registry
     * @param QuoteRepositoryInterface $quoteRepository
     * @param AuthorRepositoryInterface $authorRepository
     * @param Slugify $slugify
     * @param Builder $builder
     */
    public function __construct(
        ManagerRegistry $registry,
        QuoteRepositoryInterface $quoteRepository,
        AuthorRepositoryInterface $authorRepository,
        Slugify $slugify,
        Builder $builder
    ) {
        $this->registry = $registry;
        $this->quoteRepository = $quoteRepository;
        $this->authorRepository = $authorRepository;
        $this->slugify = $slugify;
        $this->builder = $builder;
    }

    /**
     * @throws NonUniqueResultException
     * @throws CouldNotSaveException
     * @throws ToolsException
     * @SuppressWarnings(SuperGlobals)
     */
    public function install()
    {
        $fixture = \json_decode(
            \file_get_contents(dirname(__FILE__) . '/quotes.json'),
            true
        );

        foreach ($fixture['quotes'] as $item) {
            $slug = $this->slugify->slugify($item['author']);

            try {
                $author = $this->authorRepository->getBySlug($slug);
            } catch (NotFoundException $exception) {
                $author = $this->authorRepository->factory();

                $author
                    ->setSlug($slug)
                    ->setName($item['author']);

                $this->authorRepository->save($author);
            }

            try {
                $this->quoteRepository->getByAuthorText($slug, $item['quote']);
            } catch (NotFoundException $exception) {
                $quote = $this->quoteRepository->factory();

                $quote
                    ->setAuthor($author)
                    ->setText($item['quote']);

                $this->quoteRepository->save($quote);
            }
        }
    }
}
