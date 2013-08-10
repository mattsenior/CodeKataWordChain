<?php

namespace spec\Seniorio\WordChain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ChainMakerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Seniorio\WordChain\ChainMaker');
    }

    /**
     * @param \Seniorio\WordChain\Comparator\LengthComparator $lengthComparator
     * @param \Seniorio\WordChain\Dictionary                  $dictionary
     */
    function let($lengthComparator, $dictionary)
    {
        $this->beConstructedWith($lengthComparator, $dictionary);
    }

    function it_should_know_the_shortest_chain_where_there_is_only_one_shortest_chain($lengthComparator, $dictionary)
    {
        $paths = array(array('lead', 'load', 'goad', 'gold'));
        $lengthComparator->areTheSameLength('lead', 'gold')->shouldBeCalled()->willReturn(true);
        $dictionary->getShortestPaths('lead', 'gold')->shouldBeCalled()->willReturn($paths);
        $this->getShortestChain('lead', 'gold')->shouldreturn($paths);
    }

    function it_should_throw_an_exception_if_inputs_are_different_lengths($lengthComparator)
    {
        $lengthComparator->areTheSameLength('a', 'ab')->shouldBeCalled()->willReturn(false);

        $this->shouldThrow('\Seniorio\WordChain\Exception\LengthMismatchException')->duringGetShortestChain('a', 'ab');
    }

    function it_should_throw_an_exception_if_there_is_no_chain($lengthComparator, $dictionary)
    {
        $lengthComparator->areTheSameLength('lead', 'gold')->shouldBeCalled()->willReturn(true);
        $dictionary->getShortestPaths('lead', 'gold')->shouldBeCalled()->willReturn(array());

        $this->shouldThrow('\Seniorio\WordChain\Exception\NoChainException')->duringGetShortestChain('lead', 'gold');
    }
}
