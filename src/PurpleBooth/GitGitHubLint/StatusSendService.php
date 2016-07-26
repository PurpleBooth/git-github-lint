<?php
declare(strict_types = 1);
namespace PurpleBooth\GitGitHubLint;

use PurpleBooth\GitGitHubLint\Status\Status;

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
     * @param string $organisation
     * @param string $repository
     * @param string $sha
     * @param Status $status
     *
     * @return void
     */
    public function updateStatus(string $organisation, string $repository, string $sha, Status $status);
}
