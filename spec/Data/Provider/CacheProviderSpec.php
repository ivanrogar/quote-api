<?php

namespace spec\App\Data\Provider;

use App\Data\Provider\CacheProvider;
use App\Data\Quote;
use App\Data\QuoteCollection;
use App\Model\Search\Criteria;
use PhpSpec\ObjectBehavior;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;

/**
 * Class CacheProviderSpec
 * @package spec\App\Data\Provider
 */
class CacheProviderSpec extends ObjectBehavior
{
    private $prophet;

    /**
     * @var ObjectProphecy
     */
    private $wrangler;

    private $genericCriteria;

    public function let()
    {
        $this->prophet = new Prophet();

        $this->wrangler = $this->prophet->prophesize('App\\Contract\\Data\\CacheWranglerInterface');

        $this->genericCriteria = new Criteria('some-slug', 10);

        $this->beConstructedWith($this->wrangler->reveal());
    }

    public function letGo()
    {
        unset($this->prophet);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(CacheProvider::class);
    }

    public function it_supports_any_criteria()
    {
        $this::supports($this->genericCriteria)->shouldReturn(true);
    }

    public function it_returns_an_empty_collection()
    {
        $this
            ->fetch($this->genericCriteria)
            ->callOnWrappedObject('count')
            ->shouldBe(0);
    }

    public function it_returns_a_non_empty_collection()
    {
        $this
            ->wrangler
            ->get($this->genericCriteria)
            ->willReturn(new QuoteCollection(
                [
                    new Quote('text', 'slug'),
                    new Quote('other text', 'slug')
                ],
                $this->genericCriteria
            ));

        $this->beConstructedWith($this->wrangler->reveal());

        $this
            ->fetch($this->genericCriteria)
            ->callOnWrappedObject('count')
            ->shouldBe(2);
    }
}
