<?php
declare(strict_types = 1);
namespace PurpleBooth\GitGitHubLint;

/**
 * Sets statuses on a SHA on GitHub
 *
 * @package PurpleBooth\GitGitHubLint
 */
interface StatusSendService
{
    /**
     * Set a SHA in GitHub to a state
     *
     * @param string        $organisation
     * @param string        $repository
     * @param GitHubMessage $message
     *
     * @return void
     */
    public function updateStatus(string $organisation, string $repository, GitHubMessage $message);
}
