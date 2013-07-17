<?php

namespace spec\WordChain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DictionarySpec extends ObjectBehavior
{
    function let()
    {
        // Empty
        $this->setWords(array());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('WordChain\Dictionary');
    }

    function it_should_always_return_an_array()
    {
        $this->getWords()->shouldReturn(array());
    }

    function it_should_store_one_word()
    {
        $this->addWord('Hello');

        $this->getWords()->shouldHaveCount(1);
        $this->getWords()->shouldReturn(array('Hello'));
    }

    function it_should_store_multiple_words_in_separate_calls()
    {
        $this->addWord('Hello');
        $this->addWord('Goodbye');
        $this->getWords()->shouldHaveCount(2);
        $this->getWords()->shouldReturn(array('Hello', 'Goodbye'));
    }

    function it_should_store_multiple_words_in_a_single_call()
    {
        $this->addWords(array('Hello', 'Goodbye'));
        $this->getWords()->shouldHaveCount(2);
        $this->getWords()->shouldReturn(array('Hello', 'Goodbye'));
    }

    function it_should_overwrite_words_with_set()
    {
        $this->addWord('Hello');
        $this->addWord('Goodbye');
        $this->setWords(array('Hoi', 'Goedemorgen', 'Dag'));
        $this->getWords()->shouldHaveCount(3);
        $this->getWords()->shouldReturn(array('Hoi', 'Goedemorgen', 'Dag'));
    }

    function it_should_add_idempotently()
    {
        $this->addWord('Hello');
        $this->getWords()->shouldReturn(array('Hello'));

        $this->addWord('Hello');
        $this->getWords()->shouldReturn(array('Hello'));

        $this->addWord('Goodbye');
        $this->getWords()->shouldReturn(array('Hello', 'Goodbye'));

        $this->addWord('Hello');
        $this->getWords()->shouldReturn(array('Hello', 'Goodbye'));
    }

    function it_should_return_an_empty_array_if_no_adjacent_words_found()
    {
        $this->getAdjacentWords('hello')->shouldReturn(array());
    }

    function it_should_store_adjacent_words_for_a_word()
    {
        $adjacentWords = array('hella', 'jello');
        $this->addWords(array('hello', 'hella', 'jello'));
        $this->setAdjacentWords('hello', $adjacentWords);
        $this->getAdjacentWords('hello')->shouldReturn($adjacentWords);
    }

    function it_should_know_the_shortest_paths()
    {
        $this->setWords(array('aa', 'ab', 'bb', 'bc', 'cb', 'cc'));
        $this->setAdjacentWords('aa', array('ab'));
        $this->setAdjacentWords('ab', array('aa', 'bb', 'cb'));
        $this->setAdjacentWords('bb', array('ab', 'bc', 'cb'));
        $this->setAdjacentWords('bc', array('bb', 'cc'));
        $this->setAdjacentWords('cb', array('bb', 'cc'));
        $this->setAdjacentWords('cc', array('bc', 'cb'));

        $this->getShortestPaths('aa', 'ab')->shouldReturn(array(array('aa', 'ab')));
        $this->getShortestPaths('aa', 'bc')->shouldReturn(array(array('aa', 'ab', 'bb', 'bc')));
        $this->getShortestPaths('aa', 'cc')->shouldReturn(array(array('aa', 'ab', 'cb', 'cc')));
    }

    function it_should_know_the_shortest_paths_when_words_are_adjacent()
    {
        $this->setWords(array('aa', 'ab'));
        $this->setAdjacentWords('aa', array('ab'));
        $this->setAdjacentWords('ab', array('aa'));

        $this->getShortestPaths('aa', 'ab')->shouldReturn(array(array('aa', 'ab')));
    }
}
