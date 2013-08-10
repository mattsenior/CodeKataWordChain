<?php

namespace spec\Seniorio\WordChain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AdjacentWordFinderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Seniorio\WordChain\AdjacentWordFinder');
    }

    /**
     * @param \Seniorio\WordChain\Comparator\LengthComparator              $lengthComparator
     * @param \Seniorio\WordChain\Comparator\OneLetterDifferenceComparator $oneLetterDifferenceComparator
     */
    function let($lengthComparator, $oneLetterDifferenceComparator)
    {
        $this->beConstructedWith($lengthComparator, $oneLetterDifferenceComparator);
    }

    function it_should_find_adjacent_words($lengthComparator, $oneLetterDifferenceComparator)
    {
        $words = array('aa', 'ab', 'bbb', 'bbc', 'bbd', 'ccc');

        $lengthComparator->areTheSameLength('aa', 'ab')->shouldBeCalled()->willReturn(true);
        $lengthComparator->areTheSameLength('aa', 'bbb')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('aa', 'bbc')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('aa', 'bbd')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('aa', 'ccc')->shouldBeCalled()->willReturn(false);

        $lengthComparator->areTheSameLength('ab', 'aa')->shouldBeCalled()->willReturn(true);
        $lengthComparator->areTheSameLength('ab', 'bbb')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('ab', 'bbc')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('ab', 'bbd')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('ab', 'ccc')->shouldBeCalled()->willReturn(false);

        $lengthComparator->areTheSameLength('bbb', 'aa')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('bbb', 'ab')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('bbb', 'bbc')->shouldBeCalled()->willReturn(true);
        $lengthComparator->areTheSameLength('bbb', 'bbd')->shouldBeCalled()->willReturn(true);
        $lengthComparator->areTheSameLength('bbb', 'ccc')->shouldBeCalled()->willReturn(true);

        $lengthComparator->areTheSameLength('bbc', 'aa')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('bbc', 'ab')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('bbc', 'bbb')->shouldBeCalled()->willReturn(true);
        $lengthComparator->areTheSameLength('bbc', 'bbd')->shouldBeCalled()->willReturn(true);
        $lengthComparator->areTheSameLength('bbc', 'ccc')->shouldBeCalled()->willReturn(true);

        $lengthComparator->areTheSameLength('bbd', 'aa')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('bbd', 'ab')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('bbd', 'bbb')->shouldBeCalled()->willReturn(true);
        $lengthComparator->areTheSameLength('bbd', 'bbc')->shouldBeCalled()->willReturn(true);
        $lengthComparator->areTheSameLength('bbd', 'ccc')->shouldBeCalled()->willReturn(true);

        $lengthComparator->areTheSameLength('ccc', 'aa')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('ccc', 'ab')->shouldBeCalled()->willReturn(false);
        $lengthComparator->areTheSameLength('ccc', 'bbb')->shouldBeCalled()->willReturn(true);
        $lengthComparator->areTheSameLength('ccc', 'bbc')->shouldBeCalled()->willReturn(true);
        $lengthComparator->areTheSameLength('ccc', 'bbd')->shouldBeCalled()->willReturn(true);

        $oneLetterDifferenceComparator->areOneLetterApart('aa', 'ab')->shouldBeCalled()->willReturn(true);
        $oneLetterDifferenceComparator->areOneLetterApart('ab', 'aa')->shouldBeCalled()->willReturn(true);
        $oneLetterDifferenceComparator->areOneLetterApart('bbb', 'bbc')->shouldBeCalled()->willReturn(true);
        $oneLetterDifferenceComparator->areOneLetterApart('bbb', 'bbd')->shouldBeCalled()->willReturn(true);
        $oneLetterDifferenceComparator->areOneLetterApart('bbb', 'ccc')->shouldBeCalled()->willReturn(false);
        $oneLetterDifferenceComparator->areOneLetterApart('bbc', 'bbb')->shouldBeCalled()->willReturn(true);
        $oneLetterDifferenceComparator->areOneLetterApart('bbc', 'bbd')->shouldBeCalled()->willReturn(true);
        $oneLetterDifferenceComparator->areOneLetterApart('bbc', 'ccc')->shouldBeCalled()->willReturn(false);
        $oneLetterDifferenceComparator->areOneLetterApart('bbd', 'bbb')->shouldBeCalled()->willReturn(true);
        $oneLetterDifferenceComparator->areOneLetterApart('bbd', 'bbc')->shouldBeCalled()->willReturn(true);
        $oneLetterDifferenceComparator->areOneLetterApart('bbd', 'ccc')->shouldBeCalled()->willReturn(false);
        $oneLetterDifferenceComparator->areOneLetterApart('ccc', 'bbb')->shouldBeCalled()->willReturn(false);
        $oneLetterDifferenceComparator->areOneLetterApart('ccc', 'bbc')->shouldBeCalled()->willReturn(false);
        $oneLetterDifferenceComparator->areOneLetterApart('ccc', 'bbd')->shouldBeCalled()->willReturn(false);

        $this->getAdjacentWords('aa', $words)->shouldReturn(array('ab'));
        $this->getAdjacentWords('ab', $words)->shouldReturn(array('aa'));
        $this->getAdjacentWords('bbb', $words)->shouldReturn(array('bbc', 'bbd'));
        $this->getAdjacentWords('bbc', $words)->shouldReturn(array('bbb', 'bbd'));
        $this->getAdjacentWords('bbd', $words)->shouldReturn(array('bbb', 'bbc'));
        $this->getAdjacentWords('ccc', $words)->shouldReturn(array());
    }
}
