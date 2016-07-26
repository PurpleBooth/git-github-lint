<?php

namespace spec\PurpleBooth\GitGitHubLint\Status;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\Status\PreviousFailureStatus;
use PurpleBooth\GitGitHubLint\Status\Status;

class PreviousFailureStatusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PreviousFailureStatus::class);
    }

    function it_has_weight_0()
    {
        $this->getWeight()->shouldReturn(25);
    }


    function it_has_success_state()
    {
        $this->getState()->shouldReturn('failure');
    }

    function it_has_message()
    {
        $this->getMessage()->shouldReturn('This commit message is fine, but the others are not so good.');
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
