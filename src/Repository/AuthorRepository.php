<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contract\Entity\AuthorInterface;
use App\Contract\Repository\AuthorRepositoryInterface;
use App\Entity\Author;
use App\Exception\Repository\CouldNotSaveException;
use App\Exception\Repository\NotFoundException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AuthorRepository
 * @package App\Repository
 * @SuppressWarnings(Short)
 */
class AuthorRepository extends ServiceEntityRepository implements AuthorRepositoryInterface
{
    /**
     * AuthorRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    /**
     * @inheritDoc
     */
    public function factory(): AuthorInterface
    {
        return new Author();
    }

    /**
     * @inheritDoc
     */
    public function get(int $id): AuthorInterface
    {
        /**
         * @var AuthorInterface|null $author
         */
        $author = $this->find($id);

        if (!$author) {
            throw new NotFoundException('Author not found');
        }

        return $author;
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name): AuthorInterface
    {
        /**
         * @var AuthorInterface|null $author
         */
        $author = $this->findOneBy(['name' => $name]);

        if (!$author) {
            throw new NotFoundException('Author not found');
        }

        return $author;
    }

    /**
     * @inheritDoc
     */
    public function getBySlug(string $slug): AuthorInterface
    {
        /**
         * @var AuthorInterface|null $author
         */
        $author = $this->findOneBy(['slug' => $slug]);

        if (!$author) {
            throw new NotFoundException('Author not found');
        }

        return $author;
    }

    /**
     * @inheritDoc
     */
    public function save(AuthorInterface $author): void
    {
        $ema = $this->getEntityManager();

        try {
            $ema->persist($author);
            $ema->flush();
        } catch (ORMException $exception) {
            throw new CouldNotSaveException($exception->getMessage(), 0, $exception);
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(AuthorInterface $author): void
    {
        $ema = $this->getEntityManager();

        try {
            $ema->remove($author);
            $ema->flush();
        } catch (ORMException $exception) {
            throw new CouldNotSaveException($exception->getMessage(), 0, $exception);
        }
    }
}
