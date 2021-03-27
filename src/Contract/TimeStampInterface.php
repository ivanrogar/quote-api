<?php

declare(strict_types=1);

namespace App\Contract;

use DateTimeInterface;

/**
 * Interface TimeStampInterface
 * @package App\Contract
 */
interface TimeStampInterface
{
    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface;

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface;

    /**
     * @param DateTimeInterface $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTimeInterface $updatedAt);
}
