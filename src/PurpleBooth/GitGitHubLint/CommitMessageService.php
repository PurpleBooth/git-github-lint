<?php
declare(strict_types = 1);
namespace PurpleBooth\GitGitHubLint;

/**
 * Get commit messages from GitHub and turns them into messages
 *
 * @package PurpleBooth\GitGitHubLint
 */
interface CommitMessageService
{
    /**
     * Get an array of commit messages for a specific PR
     *
     * @param string $username
     * @param string $repository
     * @param int    $pullRequestId
     *
     * @return array
     */
    public function getMessages(string $username, string $repository, int $pullRequestId) : array;
}
