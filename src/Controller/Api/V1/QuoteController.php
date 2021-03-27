<?php

declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\JsonMessageTrait;
use App\Data\Provider\Pool;
use App\Model\Search\Builder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class QuoteController
 * @package App\Controller\Api\V1
 */
class QuoteController extends AbstractController
{
    use JsonMessageTrait;

    private RequestStack $requestStack;
    private Pool $pool;
    private Builder $builder;

    /**
     * QuoteController constructor.
     * @param RequestStack $requestStack
     * @param Pool $pool
     * @param Builder $builder
     */
    public function __construct(RequestStack $requestStack, Pool $pool, Builder $builder)
    {
        $this->requestStack = $requestStack;
        $this->pool = $pool;
        $this->builder = $builder;
    }

    /**
     * @param string $authorSlug
     * @Route("/shout/{authorSlug}", methods={"GET"})
     * @return JsonResponse
     */
    public function shoutAction(string $authorSlug)
    {
        $request = $this->requestStack->getMasterRequest();

        if (!$request->query->has('limit')) {
            return $this->error("Parameter 'limit' is required");
        }

        $limit = (int)$request->query->get('limit');

        if ($limit < 1 || $limit > 10) {
            return $this->error("Parameter 'limit' must be a value between 1 and 10");
        }

        $criteria = $this
            ->builder
            ->withAuthorSlug($authorSlug)
            ->withLimit($limit)
            ->build();

        return $this->json($this->pool->handle($criteria)->toArray());
    }
}
