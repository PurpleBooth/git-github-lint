<?php

namespace spec\PurpleBooth\GitGitHubLint\Status;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\Status\LimitTheBodyWrapLengthTo72CharactersStatus;
use PurpleBooth\GitGitHubLint\Status\Status;

class LimitTheBodyWrapLengthTo72CharactersStatusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LimitTheBodyWrapLengthTo72CharactersStatus::class);
    }

    function it_has_weight_100()
    {
        $this->getWeight()->shouldReturn(100);
    }


    function it_has_success_state()
    {
        $this->getState()->shouldReturn('failure');
    }


    function it_has_message()
    {
        $this->getMessage()->shouldReturn(
            'Please limit the body line length of the commit message to 72 characters'
        );
    }

    function it_is_a_status()
    {
        $this->shouldImplement(Status::class);
    }


    function it_is_a_good_status()
    {
        $this->isPositive()->shouldReturn(false);
    }
}
