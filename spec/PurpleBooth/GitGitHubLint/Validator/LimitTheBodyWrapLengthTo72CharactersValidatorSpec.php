<?php

namespace spec\PurpleBooth\GitGitHubLint\Validator;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\LimitTheBodyWrapLengthTo72CharactersStatus;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;
use PurpleBooth\GitGitHubLint\Validator\LimitTheBodyWrapLengthTo72CharactersValidator;
use PurpleBooth\GitGitHubLint\Validator\Validator;

class LimitTheBodyWrapLengthTo72CharactersValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LimitTheBodyWrapLengthTo72CharactersValidator::class);
    }

    function it_is_a_validator()
    {
        $this->shouldBeAnInstanceOf(Validator::class);
    }


    function it_returns_the_success_status_when_the_body_wrap_is_equal_to_or_less_than_72(Message $message)
    {
        $message->getBodyWrapLength()->willReturn(72);
        $this->validate($message)->shouldReturnAnInstanceOf(SuccessStatus::class);
    }

    function it_returns_the_failure_status_when_the_body_wrap_is_greater_than_72(Message $message)
    {
        $message->getBodyWrapLength()->willReturn(73);
        $this->validate($message)->shouldReturnAnInstanceOf(LimitTheBodyWrapLengthTo72CharactersStatus::class);
    }
}
