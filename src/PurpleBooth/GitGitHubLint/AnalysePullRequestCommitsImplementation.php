<?php
declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint;

/**
 * Analyses pull request commit messages
 *
 * @package PurpleBooth\GitGitHubLint
 */
class AnalysePullRequestCommitsImplementation implements AnalysePullRequestCommits
{
    /**
     * @var CommitMessageService
     */
    private $commitMessageService;
    /**
     * @var ValidateMessages
     */
    private $validationService;
    /**
     * @var StatusSendService
     */
    private $statusSendService;

    /**
     * AnalyseAndReportOnCommitImplementation constructor.
     *
     * @param CommitMessageService $commitMessageService
     * @param ValidateMessages      $validationService
     * @param StatusSendService    $statusSendService
     */
    public function __construct(
        CommitMessageService $commitMessageService,
        ValidateMessages $validationService,
        StatusSendService $statusSendService
    ) {
        $this->commitMessageService = $commitMessageService;
        $this->validationService    = $validationService;
        $this->statusSendService    = $statusSendService;
    }

    /**
     * Validate the messages in a pull request
     *
     * @param string $username
     * @param string $repository
     * @param int    $pullRequestId
     */
    public function check(string $username, string $repository, int $pullRequestId)
    {
        $messages = $this->commitMessageService->getMessages($username, $repository, $pullRequestId);
        $this->validationService->validate($messages);

        /** @var Message $message */
        foreach ($messages as $message) {
            $this->statusSendService->updateStatus($username, $repository, $message->getSha(), $message->getStatus());
        }
    }
}
