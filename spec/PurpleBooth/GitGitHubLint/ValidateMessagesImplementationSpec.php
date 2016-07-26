<?php

namespace spec\PurpleBooth\GitGitHubLint;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\LimitTheTitleLengthTo69CharactersStatus;
use PurpleBooth\GitGitHubLint\Status\PreviousFailureStatus;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;
use PurpleBooth\GitGitHubLint\ValidateMessage;
use PurpleBooth\GitGitHubLint\ValidateMessages;
use PurpleBooth\GitGitHubLint\ValidateMessagesImplementation;

class ValidateMessagesImplementationSpec extends ObjectBehavior
{
    function it_is_initializable(ValidateMessage $validateMessage)
    {
        $this->beConstructedWith($validateMessage);
        $this->shouldHaveType(ValidateMessagesImplementation::class);
        $this->shouldHaveType(ValidateMessages::class);
    }

    function it_sets_the_status_in_the_message(Message $message, ValidateMessage $validateMessage)
    {
        $status = new SuccessStatus();

        $this->beConstructedWith($validateMessage);
        $validateMessage->validate($message)->willReturn($status);
        $message->setStatus($status)->shouldBeCalled();

        $this->validate([$message]);
    }


    function it_sets_the_one_failed_status_triggers_all_following_to_be(
        Message $message1,
        Message $message2,
        Message $message3,
        ValidateMessage $validateMessage
    ) {
        $this->beConstructedWith($validateMessage);
        $validateMessage->validate($message1)->willReturn(new SuccessStatus());
        $validateMessage->validate($message2)->willReturn(new LimitTheTitleLengthTo69CharactersStatus());
        $validateMessage->validate($message3)->willReturn(new SuccessStatus());

        $message1->setStatus(
            Argument::type(SuccessStatus::class)
        )->shouldBeCalled();
        $message2->setStatus(
            Argument::type(LimitTheTitleLengthTo69CharactersStatus::class)
        )->shouldBeCalled();
        $message3->setStatus(
            Argument::type(PreviousFailureStatus::class)
        )->shouldBeCalled();

        $this->validate([$message1, $message2, $message3]);
    }

}
