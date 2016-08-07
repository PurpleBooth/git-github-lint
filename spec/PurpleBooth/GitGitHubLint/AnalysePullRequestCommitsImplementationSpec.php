<?php

namespace spec\PurpleBooth\GitGitHubLint;

use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\AnalysePullRequestCommits;
use PurpleBooth\GitGitHubLint\AnalysePullRequestCommitsImplementation;
use PurpleBooth\GitGitHubLint\CommitMessageService;
use PurpleBooth\GitGitHubLint\GitHubMessage;
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
        GitHubMessage $message1,
        GitHubMessage $message2
    ) {
        $commitMessageService->getMessages('username', 'repo', 10)
                             ->willReturn([$message1, $message2]);
        $validationService->validate([$message1, $message2])
                          ->shouldBeCalled();

        $statusSendService->updateStatus('username', 'repo', $message1);
        $statusSendService->updateStatus('username', 'repo', $message2);

        $this->beConstructedWith($commitMessageService, $validationService, $statusSendService);

        $this->check('username', 'repo', 10);
    }
}
