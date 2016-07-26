<?php

namespace spec\PurpleBooth\GitGitHubLint\Validator;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\LimitTheTitleLengthTo69CharactersStatus;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;
use PurpleBooth\GitGitHubLint\Validator\LimitTheTitleLengthTo69CharactersValidator;
use PurpleBooth\GitGitHubLint\Validator\Validator;

class LimitTheTitleLengthTo69CharactersValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LimitTheTitleLengthTo69CharactersValidator::class);
    }


    function it_is_a_validator()
    {
        $this->shouldBeAnInstanceOf(Validator::class);
    }


    function it_returns_the_success_status_when_the_title_length_is_less_than_or_equal_to_69(Message $message)
    {
        $message->getTitleLength()->willReturn(69);
        $this->validate($message)->shouldReturnAnInstanceOf(SuccessStatus::class);
    }

    function it_returns_the_failure_status_when_the_title_length_is_greater_than_70(Message $message)
    {
        $message->getTitleLength()->willReturn(70);
        $this->validate($message)->shouldReturnAnInstanceOf(LimitTheTitleLengthTo69CharactersStatus::class);
    }
}
