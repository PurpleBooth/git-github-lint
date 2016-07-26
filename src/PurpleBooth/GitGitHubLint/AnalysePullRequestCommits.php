<?php
declare(strict_types = 1);
namespace PurpleBooth\GitGitHubLint;

/**
 * Analyses pull request commit messages
 *
 * @package PurpleBooth\GitGitHubLint
 */
interface AnalysePullRequestCommits
{
    /**
     * Validate the messages in a pull request
     *
     * @param string $username
     * @param string $repository
     * @param int    $pullRequestId
     *
     * @return void
     */
    public function check(string $username, string $repository, int $pullRequestId);
}
