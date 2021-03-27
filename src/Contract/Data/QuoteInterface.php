<?php

declare(strict_types=1);

namespace App\Contract\Data;

use Serializable;

/**
 * Interface QuoteInterface
 * @package App\Contract\Data
 */
interface QuoteInterface extends Serializable
{
    /**
     * @return string
     */
    public function getText(): string;

    /**
     * @return string
     */
    public function getAuthorSlug(): string;
}
