<?php

namespace spec\WordChain;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DictionarySpec extends ObjectBehavior
{
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

    function it_should_store_multiple_words()
    {
        $this->addWord('Hello');
        $this->addWord('Goodbye');
        $this->getWords()->shouldHaveCount(2);
        $this->getWords()->shouldReturn(array('Hello', 'Goodbye'));
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
}
