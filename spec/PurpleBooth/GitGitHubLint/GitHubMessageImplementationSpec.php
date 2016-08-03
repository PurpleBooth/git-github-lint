<?php

namespace spec\PurpleBooth\GitGitHubLint;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\GitHubMessage;
use PurpleBooth\GitGitHubLint\GitHubMessageImplementation;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;
use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\Status\LimitTheBodyWrapLengthTo72CharactersStatus;
use PurpleBooth\GitLintValidators\Status\SoftLimitTheTitleLengthTo50CharactersStatus;

class GitHubMessageImplementationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $commitMessage
            = <<<COMMIT
This is an example title

Something
COMMIT;

        $this->beConstructedWith("exampleSha", $commitMessage);
        $this->shouldHaveType(GitHubMessageImplementation::class);
        $this->shouldHaveType(GitHubMessage::class);
        $this->shouldHaveType(Message::class);
    }


    function it_has_a_sha()
    {
        $commitMessage
            = <<<COMMIT
This is an example title

Something
COMMIT;

        $this->beConstructedWith($commitMessage, "exampleSha");
        $this->getSha()->shouldReturn("exampleSha");
    }

    function it_can_get_the_highest_weight_status()
    {
        $commitMessage
            = <<<COMMIT
This is an example title

Something
COMMIT;

        $this->beConstructedWith($commitMessage, "exampleSha");

        $expected = new LimitTheBodyWrapLengthTo72CharactersStatus();

        $this->addStatus($expected);
        $this->addStatus(new SuccessStatus());
        $this->addStatus(new SoftLimitTheTitleLengthTo50CharactersStatus());

        $this->getHighestWeightStatus()->shouldReturn($expected);
    }
}
