<?php

namespace spec\App\Data\Provider;

use App\Data\Provider\LocalQuoteProvider;
use App\Data\Transformer\EntityTransformer;
use App\Entity\Author;
use App\Model\Search\Criteria;
use PhpSpec\ObjectBehavior;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;

/**
 * Class LocalQuoteProviderSpec
 * @package spec\App\Data\Provider
 */
class LocalQuoteProviderSpec extends ObjectBehavior
{
    private $prophet;

    /**
     * @var ObjectProphecy
     */
    private $wrangler;

    private $quoteRepository;

    private $entityTransformer;

    private $genericCriteria;

    public function let()
    {
        $this->prophet = new Prophet();

        $this->wrangler = $this->prophet->prophesize('App\Contract\Data\CacheWranglerInterface');

        $this->quoteRepository = $this->prophet->prophesize('App\Contract\Repository\QuoteRepositoryInterface');

        $this->entityTransformer = new EntityTransformer();

        $this->genericCriteria = new Criteria('some-slug', 10);

        $this->construct();
    }

    public function letGo()
    {
        unset($this->prophet);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(LocalQuoteProvider::class);
    }

    public function it_supports_any_criteria()
    {
        $this::supports($this->genericCriteria)->shouldReturn(true);
    }

    public function it_returns_a_non_empty_collection()
    {
        $author = (new Author())->setName('author')->setSlug('slug');

        $this
            ->quoteRepository
            ->getByCriteria($this->genericCriteria)
            ->willReturn(
                [
                    (new \App\Entity\Quote())->setText('text')->setAuthor($author),
                    (new \App\Entity\Quote())->setText('other text')->setAuthor($author)
                ]
            );

        $this->construct();

        $this
            ->fetch($this->genericCriteria)
            ->count()
            ->shouldBe(2);
    }

    private function construct()
    {
        $this->beConstructedWith(
            $this->quoteRepository->reveal(),
            $this->entityTransformer,
            $this->wrangler->reveal()
        );
    }
}
