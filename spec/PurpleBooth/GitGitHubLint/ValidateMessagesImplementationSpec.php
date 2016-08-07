<?php

namespace spec\PurpleBooth\GitGitHubLint;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PurpleBooth\GitGitHubLint\GitHubMessage;
use PurpleBooth\GitGitHubLint\Status\PreviousFailureStatus;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;
use PurpleBooth\GitGitHubLint\ValidateMessages;
use PurpleBooth\GitGitHubLint\ValidateMessagesImplementation;
use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\Status\CapitalizeTheSubjectLineStatus;
use PurpleBooth\GitLintValidators\ValidateMessage;

class ValidateMessagesImplementationSpec extends ObjectBehavior
{
    function it_is_initializable(ValidateMessage $validateMessage)
    {
        $this->beConstructedWith($validateMessage);
        $this->shouldHaveType(ValidateMessagesImplementation::class);
        $this->shouldHaveType(ValidateMessages::class);
    }

    function is_sets_a_succeess_status_if_there_are_none(GitHubMessage $message, ValidateMessage $validateMessage)
    {
        $this->beConstructedWith($validateMessage);
        $message->getStatuses()->willReturn([]);
        $message->addStatus(Argument::type(SuccessStatus::class))->shouldBeCalled();
        $validateMessage->validate($message)->shouldBeCalled();
        $this->validate([$message]);
    }


    function it_sets_the_one_failed_status_triggers_all_following_to_be(
        Message $message1,
        Message $message2,
        Message $message3,
        ValidateMessage $validateMessage
    ) {
        $this->beConstructedWith($validateMessage);
        $validateMessage->validate($message1)->shouldBeCalled();
        $validateMessage->validate($message2)->shouldBeCalled();
        $validateMessage->validate($message3)->shouldBeCalled();

        $message1->getStatuses()->willReturn([new CapitalizeTheSubjectLineStatus()]);
        $message2->getStatuses()->willReturn([new CapitalizeTheSubjectLineStatus()]);

        $message3->getStatuses()->willReturn([]);
        $message3->addStatus(
            Argument::type(PreviousFailureStatus::class)
        )->shouldBeCalled();

        $this->validate([$message1, $message2, $message3]);
    }

    function it_sets_the_one_failed_status_triggers_all_following_to_be_earlier_statues_are_not_effected(
        Message $message1,
        Message $message2,
        Message $message3,
        ValidateMessage $validateMessage
    ) {
        $this->beConstructedWith($validateMessage);
        $validateMessage->validate($message1)->shouldBeCalled();
        $validateMessage->validate($message2)->shouldBeCalled();
        $validateMessage->validate($message3)->shouldBeCalled();

        $message1->getStatuses()->willReturn([]);
        $message2->getStatuses()->willReturn([new CapitalizeTheSubjectLineStatus()]);
        $message3->getStatuses()->willReturn([]);

        $message1->addStatus(
            Argument::type(SuccessStatus::class)
        )->shouldBeCalled();
        $message3->addStatus(
            Argument::type(PreviousFailureStatus::class)
        )->shouldBeCalled();

        $this->validate([$message1, $message2, $message3]);
    }
}
