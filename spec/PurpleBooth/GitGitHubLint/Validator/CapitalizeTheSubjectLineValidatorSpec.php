<?php

namespace spec\PurpleBooth\GitGitHubLint\Validator;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\CapitalizeTheSubjectLineStatus;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;
use PurpleBooth\GitGitHubLint\Validator\CapitalizeTheSubjectLineValidator;
use PurpleBooth\GitGitHubLint\Validator\Validator;

class CapitalizeTheSubjectLineValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CapitalizeTheSubjectLineValidator::class);
    }

    function it_is_a_validator()
    {
        $this->shouldBeAnInstanceOf(Validator::class);
    }

    function it_returns_the_success_status_when_title_is_capitalised(Message $message)
    {
        $message->isTitleCapitalised()->willReturn(true);
        $this->validate($message)->shouldReturnAnInstanceOf(SuccessStatus::class);
    }

    function it_returns_the_failure_status_when_the_title_is_not_capitalised(Message $message)
    {
        $message->isTitleCapitalised()->willReturn(false);
        $this->validate($message)->shouldReturnAnInstanceOf(CapitalizeTheSubjectLineStatus::class);
    }
}
