<?php

declare(strict_types=1);

namespace App\Contract\Repository;

use App\Contract\Entity\QuoteInterface;
use App\Contract\Search\CriteriaInterface;
use App\Exception\Repository\CouldNotSaveException;
use App\Exception\Repository\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Interface QuoteRepositoryInterface
 * @package App\Contract\Repository
 * @SuppressWarnings(Short)
 */
interface QuoteRepositoryInterface extends ServiceEntityRepositoryInterface
{
    /**
     * @return QuoteInterface
     */
    public function factory(): QuoteInterface;

    /**
     * @param int $id
     * @return QuoteInterface
     * @throws NotFoundException
     */
    public function get(int $id): QuoteInterface;

    /**
     * @param CriteriaInterface $criteria
     * @return QuoteInterface[]
     */
    public function getByCriteria(CriteriaInterface $criteria);

    /**
     * @param string $authorSlug
     * @param string $text
     * @return QuoteInterface
     * @throws NonUniqueResultException
     * @throws NotFoundException
     */
    public function getByAuthorText(string $authorSlug, string $text): QuoteInterface;

    /**
     * @param QuoteInterface $quote
     * @throws CouldNotSaveException
     */
    public function save(QuoteInterface $quote): void;

    /**
     * @param QuoteInterface $quote
     * @throws CouldNotSaveException
     */
    public function delete(QuoteInterface $quote): void;
}
