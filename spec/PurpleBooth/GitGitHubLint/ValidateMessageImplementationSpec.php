<?php

namespace spec\PurpleBooth\GitGitHubLint;

use LogicException;
use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\LimitTheTitleLengthTo69CharactersStatus;
use PurpleBooth\GitGitHubLint\Status\SoftLimitTheTitleLengthTo50CharactersStatus;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;
use PurpleBooth\GitGitHubLint\ValidateMessage;
use PurpleBooth\GitGitHubLint\ValidateMessageImplementation;
use PurpleBooth\GitGitHubLint\Validator\Validator;

class ValidateMessageImplementationSpec extends ObjectBehavior
{
    function it_is_initializable(Validator $successValidator)
    {
        $this->beConstructedWith([$successValidator]);
        $this->shouldHaveType(ValidateMessageImplementation::class);
        $this->shouldHaveType(ValidateMessage::class);
    }

    function it_throws_an_exception_if_i_do_not_contruct_the_service_with_at_least_one_validator()
    {
        $this->shouldThrow(LogicException::class);
        $this->beConstructedWith([]);
        $this->shouldHaveType(ValidateMessageImplementation::class);
    }

    function it_will_take_a_message_and_give_you_the_highest_weighted_status(
        Message $message,
        SuccessStatus $successStatus,
        SoftLimitTheTitleLengthTo50CharactersStatus $lowWeightStatus,
        LimitTheTitleLengthTo69CharactersStatus $highWeightStatus,
        Validator $successValidator,
        Validator $lowWeightValidator,
        Validator $highWeightValidator
    ) {
        $successStatus->getWeight()->willReturn(0);
        $lowWeightStatus->getWeight()->willReturn(50);
        $highWeightStatus->getWeight()->willReturn(100);

        $successValidator->validate($message)->willReturn($successStatus);
        $lowWeightValidator->validate($message)->willReturn($lowWeightStatus);
        $highWeightValidator->validate($message)->willReturn($highWeightStatus);

        $this->beConstructedWith([$successValidator, $highWeightValidator, $lowWeightValidator]);
        $this->validate($message)->shouldReturn($highWeightStatus);
    }
}
