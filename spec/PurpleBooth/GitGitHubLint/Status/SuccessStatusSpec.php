<?php

namespace spec\PurpleBooth\GitGitHubLint\Status;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\Status\Status;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;

class SuccessStatusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SuccessStatus::class);
    }

    function it_has_weight_0()
    {
        $this->getWeight()->shouldReturn(0);
    }

    function it_has_success_state()
    {
        $this->getState()->shouldReturn('success');
    }

    function it_has_message()
    {
        $this->getMessage()->shouldReturn('Commit message looking good!');
    }

    function it_is_a_status()
    {
        $this->shouldImplement(Status::class);
    }

    function it_is_a_good_status()
    {
        $this->isPositive()->shouldReturn(true);
    }
}
