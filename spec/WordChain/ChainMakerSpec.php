<?php

namespace spec\WordChain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ChainMakerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('WordChain\ChainMaker');
    }

    /**
     * @var WordChain\Comparator\LengthComparator $lengthComparator
     */
    function let($lengthComparator)
    {
        $this->beConstructedWith($lengthComparator);
    }

    function it_should_know_the_shortest_chain_where_there_is_only_one_shortest_chain()
    {

        $this->getShortestChain('lead', 'gold')->shouldreturn(array('lead', 'load', 'goad', 'gold'));
    }

    function it_should_throw_an_exception_if_there_is_no_chain()
    {
        $this->shouldThrow('WordChain\Exception\LengthMismatchException')->duringGetShortestChain('a', 'ab');
    }
}
