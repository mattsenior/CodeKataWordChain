<?php

namespace spec\WordChain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ImporterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('WordChain\Importer');
    }

    /**
     * @param \WordChain\Dictionary         $dictionary
     * @param \WordChain\AdjacentWordFinder $adjacentWordFinder
     */
    function let($dictionary, $adjacentWordFinder)
    {
        $this->beConstructedWith($dictionary, $adjacentWordFinder);
    }

    function it_should_empty_the_dictionary($dictionary)
    {
        $dictionary->setWords(array())->shouldBeCalled();
        $this->reset();
    }

    function it_should_add_words_to_the_dictionary($dictionary)
    {
        $dictionary->addWord('Hello')->shouldBeCalled();
        $this->addWord('Hello');
    }

    function it_should_add_multiple_words_to_the_dictionary($dictionary)
    {
        $dictionary->addWords(array('Hello', 'Goodbye'))->shouldBeCalled();
        $this->addWords(array('Hello', 'Goodbye'));
    }

    function it_should_find_adjacent_words_from_the_dictionary($dictionary, $adjacentWordFinder)
    {
        $words = array('aa', 'ab', 'aaa', 'aba', 'bbb', 'bbc', 'bbd');

        $dictionary->getWords()->shouldBeCalled()->willReturn($words);

        $adjacentWordFinder->getAdjacentWords('aa', $words)->shouldBeCalled()->willReturn(array('ab'));
        $adjacentWordFinder->getAdjacentWords('ab', $words)->shouldBeCalled()->willReturn(array('aa'));
        $adjacentWordFinder->getAdjacentWords('aaa', $words)->shouldBeCalled()->willReturn(array('aba'));
        $adjacentWordFinder->getAdjacentWords('aba', $words)->shouldBeCalled()->willReturn(array('aaa'));
        $adjacentWordFinder->getAdjacentWords('bbb', $words)->shouldBeCalled()->willReturn(array('bbc', 'bbd'));
        $adjacentWordFinder->getAdjacentWords('bbc', $words)->shouldBeCalled()->willReturn(array('bbb', 'bbd'));
        $adjacentWordFinder->getAdjacentWords('bbd', $words)->shouldBeCalled()->willReturn(array('bbb', 'bbc'));

        $dictionary->setAdjacentWords('aa', array('ab'))->shouldBeCalled();
        $dictionary->setAdjacentWords('ab', array('aa'))->shouldBeCalled();
        $dictionary->setAdjacentWords('aaa', array('aba'))->shouldBeCalled();
        $dictionary->setAdjacentWords('aba', array('aaa'))->shouldBeCalled();
        $dictionary->setAdjacentWords('bbb', array('bbc', 'bbd'))->shouldBeCalled();
        $dictionary->setAdjacentWords('bbc', array('bbb', 'bbd'))->shouldBeCalled();
        $dictionary->setAdjacentWords('bbd', array('bbb', 'bbc'))->shouldBeCalled();

        $this->processAdjacentWords();
    }
}
