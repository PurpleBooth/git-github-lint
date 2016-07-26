<?php
declare(strict_types = 1);
namespace PurpleBooth\GitGitHubLint;

use PurpleBooth\GitGitHubLint\Exception\GitHubLintException;

/**
 * Courtesy class to make life easier
 *
 * @package PurpleBooth\GitGitHubLint
 */
interface GitHubLint
{
    /**
     * Analyse the commits on a pull request and set the statuses
     *
     * @param string $username
     * @param string $repository
     * @param int    $pullRequest
     *
     * @throws GitHubLintException if an undocumented exception is thrown, it'll be wrapped in this exception.
     *
     * @return void
     */
    public function analyse(string $username, string $repository, int $pullRequest);
}
