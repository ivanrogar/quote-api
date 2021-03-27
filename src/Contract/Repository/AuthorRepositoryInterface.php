<?php

declare(strict_types=1);

namespace App\Contract\Repository;

use App\Contract\Entity\AuthorInterface;
use App\Exception\Repository\CouldNotSaveException;
use App\Exception\Repository\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

/**
 * Interface AuthorRepositoryInterface
 * @package App\Contract\Repository
 * @SuppressWarnings(Short)
 */
interface AuthorRepositoryInterface extends ServiceEntityRepositoryInterface
{
    /**
     * @return AuthorInterface
     */
    public function factory(): AuthorInterface;

    /**
     * @param int $id
     * @return AuthorInterface
     * @throws NotFoundException
     */
    public function get(int $id): AuthorInterface;

    /**
     * @param string $name
     * @return AuthorInterface
     * @throws NotFoundException
     */
    public function getByName(string $name): AuthorInterface;

    /**
     * @param string $slug
     * @return AuthorInterface
     * @throws NotFoundException
     */
    public function getBySlug(string $slug): AuthorInterface;

    /**
     * @param AuthorInterface $author
     * @throws CouldNotSaveException
     */
    public function save(AuthorInterface $author): void;

    /**
     * @param AuthorInterface $author
     * @throws CouldNotSaveException
     */
    public function delete(AuthorInterface $author): void;
}
