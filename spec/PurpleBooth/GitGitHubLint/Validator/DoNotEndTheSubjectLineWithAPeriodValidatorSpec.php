<?php

namespace spec\PurpleBooth\GitGitHubLint\Validator;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\DoNotEndTheSubjectLineWithAPeriodStatus;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;
use PurpleBooth\GitGitHubLint\Validator\DoNotEndTheSubjectLineWithAPeriodValidator;
use PurpleBooth\GitGitHubLint\Validator\Validator;

class DoNotEndTheSubjectLineWithAPeriodValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DoNotEndTheSubjectLineWithAPeriodValidator::class);
    }

    function it_is_a_validator()
    {
        $this->shouldBeAnInstanceOf(Validator::class);
    }

    function it_returns_the_success_status_when_the_title_has_no_full_stop(Message $message)
    {
        $message->hasTitleAFullStop()->willReturn(false);
        $this->validate($message)->shouldReturnAnInstanceOf(SuccessStatus::class);
    }

    function it_returns_the_failure_status_when_the_title_has_a_full_stop(Message $message)
    {
        $message->hasTitleAFullStop()->willReturn(true);
        $this->validate($message)->shouldReturnAnInstanceOf(DoNotEndTheSubjectLineWithAPeriodStatus::class);
    }
}
