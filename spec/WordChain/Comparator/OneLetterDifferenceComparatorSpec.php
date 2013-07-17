<?php

namespace spec\WordChain\Comparator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OneLetterDifferenceComparatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('WordChain\Comparator\OneLetterDifferenceComparator');
    }

    function it_should_know_if_two_strings_of_different_lengths_are_not_one_letter_apart()
    {
        $a = 'a';
        $b = 'ab';

        $this->areOneLetterApart($a, $b)->shouldReturn(false);
    }

    function it_should_know_if_two_strings_of_the_same_length_are_not_one_letter_apart()
    {
        $this->areOneLetterApart('ab', 'cd')->shouldReturn(false);
        $this->areOneLetterApart('abcdef', 'abcdfg')->shouldReturn(false);
    }

    function it_should_know_if_two_strings_of_the_same_length_are_one_letter_apart()
    {
        $this->areOneLetterApart('aa', 'ab')->shouldReturn(true);
        $this->areOneLetterApart('abcdef', 'abceef')->shouldReturn(true);
    }
}
