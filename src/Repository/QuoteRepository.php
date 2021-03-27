<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Entity\QuoteInterface;
use App\Contract\Repository\QuoteRepositoryInterface;
use App\Contract\Search\CriteriaInterface;
use App\Entity\Quote;
use App\Exception\Repository\CouldNotSaveException;
use App\Exception\Repository\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class QuoteRepository
 * @package App\Repository
 * @SuppressWarnings(Short)
 */
class QuoteRepository extends ServiceEntityRepository implements QuoteRepositoryInterface
{
    /**
     * QuoteRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quote::class);
    }

    /**
     * @inheritDoc
     */
    public function factory(): QuoteInterface
    {
        return new Quote();
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): QuoteInterface
    {
        /**
         * @var QuoteInterface|null $quote
         */
        $quote = $this->find($id);

        if (!$quote) {
            throw new NotFoundException('Quote not found');
        }

        return $quote;
    }

    /**
     * @inheritDoc
     */
    public function getByCriteria(CriteriaInterface $criteria)
    {
        $result = $this
            ->createQueryBuilder('q')
            ->innerJoin('q.author', 'author')
            ->andWhere('author.slug = :slug')
            ->setParameter('slug', $criteria->getAuthorSlug())
            ->setMaxResults($criteria->getLimit())
            ->getQuery()
            ->getResult();

        return (is_iterable($result)) ? $result : [];
    }

    /**
     * @inheritDoc
     */
    public function getByAuthorText(string $authorSlug, string $text): QuoteInterface
    {
        $quote = $this
            ->createQueryBuilder('q')
            ->innerJoin('q.author', 'author')
            ->andWhere('author.slug = :slug')
            ->setParameter('slug', $authorSlug)
            ->andWhere('q.text = :text')
            ->setParameter('text', $text)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$quote) {
            throw new NotFoundException('Quote not found');
        }

        return $quote;
    }

    /**
     * @inheritDoc
     */
    public function save(QuoteInterface $quote): void
    {
        $ema = $this->getEntityManager();

        try {
            $ema->persist($quote);
            $ema->flush();
        } catch (ORMException $exception) {
            throw new CouldNotSaveException($exception->getMessage(), 0, $exception);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(QuoteInterface $quote): void
    {
        $ema = $this->getEntityManager();

        try {
            $ema->remove($quote);
            $ema->flush();
        } catch (ORMException $exception) {
            throw new CouldNotSaveException($exception->getMessage(), 0, $exception);
        }
    }
}
