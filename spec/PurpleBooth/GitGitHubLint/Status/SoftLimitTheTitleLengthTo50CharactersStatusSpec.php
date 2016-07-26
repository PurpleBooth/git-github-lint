<?php

namespace spec\PurpleBooth\GitGitHubLint\Status;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\Status\SoftLimitTheTitleLengthTo50CharactersStatus;
use PurpleBooth\GitGitHubLint\Status\Status;

class SoftLimitTheTitleLengthTo50CharactersStatusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SoftLimitTheTitleLengthTo50CharactersStatus::class);
    }

    function it_has_weight_50()
    {
        $this->getWeight()->shouldReturn(50);
    }

    function it_has_success_state()
    {
        $this->getState()->shouldReturn('success');
    }

    function it_has_message()
    {
        $this->getMessage()->shouldReturn(
            'Looks good, but can you shorten the subject of the commit message to 50 characters or less?'
        );
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
