<?php
declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint;

use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\Status\Status;

/**
 * A commit message from GitHub
 *
 * @package PurpleBooth\GitGitHubLint
 */
interface GitHubMessage extends Message
{

    /**
     * Get the SHA that identifies this commit
     *
     * @return string
     */
    public function getSha() : string;

    /**
     * Get the highest weight status associated with this message
     *
     * @return Status
     */
    public function getHighestWeightStatus() : Status;
}
