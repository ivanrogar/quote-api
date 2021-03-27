<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Trait MessageTrait
 * @package App\Controller
 */
trait JsonMessageTrait
{
    /**
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    private function error(string $message, int $statusCode = 400)
    {
        return $this->json(['message' => $message], $statusCode);
    }
}
