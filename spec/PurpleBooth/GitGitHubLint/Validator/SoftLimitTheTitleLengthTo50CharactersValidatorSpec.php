<?php

namespace spec\PurpleBooth\GitGitHubLint\Validator;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\SoftLimitTheTitleLengthTo50CharactersStatus;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;
use PurpleBooth\GitGitHubLint\Validator\SoftLimitTheTitleLengthTo50CharactersValidator;
use PurpleBooth\GitGitHubLint\Validator\Validator;

class SoftLimitTheTitleLengthTo50CharactersValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SoftLimitTheTitleLengthTo50CharactersValidator::class);
    }

    function it_is_a_validator()
    {
        $this->shouldBeAnInstanceOf(Validator::class);
    }

    function it_returns_the_success_status_when_the_title_is_less_than_or_equal_to_50_characters(Message $message)
    {
        $message->getTitleLength()->willReturn(50);
        $this->validate($message)->shouldReturnAnInstanceOf(SuccessStatus::class);
    }

    function it_returns_the_failure_status_when_it_is_greater_than_50_characters(Message $message)
    {
        $message->getTitleLength()->willReturn(51);
        $this->validate($message)->shouldReturnAnInstanceOf(SoftLimitTheTitleLengthTo50CharactersStatus::class);
    }
}
