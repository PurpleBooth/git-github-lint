<?php

namespace spec\PurpleBooth\GitGitHubLint\Status;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\Status\SeparateSubjectFromBodyWithABlankLineStatus;
use PurpleBooth\GitGitHubLint\Status\Status;

class SeparateSubjectFromBodyWithABlankLineStatusSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SeparateSubjectFromBodyWithABlankLineStatus::class);
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
            'Please put a single blank line between the subject and body of the commit message'
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
