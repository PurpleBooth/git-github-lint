<?php

namespace spec\PurpleBooth\GitGitHubLint;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\AnalysePullRequestCommits;
use PurpleBooth\GitGitHubLint\AnalysePullRequestCommitsImplementation;
use PurpleBooth\GitGitHubLint\CommitMessageService;
use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\LimitTheBodyWrapLengthTo72CharactersStatus;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;
use PurpleBooth\GitGitHubLint\StatusSendService;
use PurpleBooth\GitGitHubLint\ValidateMessages;

class AnalysePullRequestCommitsImplementationSpec extends ObjectBehavior
{
    function it_is_initializable(
        CommitMessageService $commitMessageService,
        ValidateMessages $validationService,
        StatusSendService $statusSendService
    ) {
        $this->beConstructedWith($commitMessageService, $validationService, $statusSendService);
        $this->shouldHaveType(AnalysePullRequestCommitsImplementation::class);
        $this->shouldHaveType(AnalysePullRequestCommits::class);
    }

    function it_gets_the_messages_analyses_them_then_updates_them(
        CommitMessageService $commitMessageService,
        ValidateMessages $validationService,
        StatusSendService $statusSendService,
        Message $message1,
        Message $message2
    ) {
        $commitMessageService->getMessages('username', 'repo', 10)
                             ->willReturn([$message1, $message2]);
        $validationService->validate([$message1, $message2])
                          ->shouldBeCalled();

        $successStatus = new SuccessStatus();
        $message1->getSha()->willReturn("a12345");
        $message1->getStatus()->willReturn($successStatus);

        $failureStatus = new LimitTheBodyWrapLengthTo72CharactersStatus();
        $message2->getSha()->willReturn("b12345");
        $message2->getStatus()->willReturn($failureStatus);

        $statusSendService->updateStatus('username', 'repo', "a12345", $successStatus);
        $statusSendService->updateStatus('username', 'repo', "b12345", $failureStatus);

        $this->beConstructedWith($commitMessageService, $validationService, $statusSendService);

        $this->check('username', 'repo', 10);
    }

}
