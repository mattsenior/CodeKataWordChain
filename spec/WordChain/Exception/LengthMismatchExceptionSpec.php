<?php

namespace spec\WordChain\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LengthMismatchExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('WordChain\Exception\LengthMismatchException');
    }
}
