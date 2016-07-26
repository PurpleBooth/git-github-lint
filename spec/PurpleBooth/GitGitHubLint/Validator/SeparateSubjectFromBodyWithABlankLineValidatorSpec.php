<?php

namespace spec\PurpleBooth\GitGitHubLint\Validator;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\SeparateSubjectFromBodyWithABlankLineStatus;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;
use PurpleBooth\GitGitHubLint\Validator\SeparateSubjectFromBodyWithABlankLineValidator;
use PurpleBooth\GitGitHubLint\Validator\Validator;

class SeparateSubjectFromBodyWithABlankLineValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SeparateSubjectFromBodyWithABlankLineValidator::class);
    }


    function it_is_a_validator()
    {
        $this->shouldBeAnInstanceOf(Validator::class);
    }


    function it_returns_the_success_status_when_there_is_a_blank_line_after_the_title(Message $message)
    {
        $message->hasBlankLineAfterTitle()->willReturn(true);
        $this->validate($message)->shouldReturnAnInstanceOf(SuccessStatus::class);
    }

    function it_returns_the_failure_status_when_there_is_not_a_blank_line_after_the_title(Message $message)
    {
        $message->hasBlankLineAfterTitle()->willReturn(false);
        $this->validate($message)->shouldReturnAnInstanceOf(SeparateSubjectFromBodyWithABlankLineStatus::class);
    }
}
