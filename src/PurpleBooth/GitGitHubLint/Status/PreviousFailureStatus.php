<?php

declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint\Status;

use PurpleBooth\GitLintValidators\Status\Status;

/**
 * This status indicates that there has been a problem in a status prior to this message, however this particular status
 * is fine
 *
 * @package PurpleBooth\GitGitHubLint\Status
 */
class PreviousFailureStatus implements Status
{
    /**
     * Get the importance of this status.
     *
     * The lower the value the less important it is, the higher the more important.
     *
     * @return int
     */
    public function getWeight() : int
    {
        return Status::WEIGHT_OTHER_ERRORS;
    }

    /**
     * A human readable message that describes this state
     *
     * This will be displayed to the user via the GitHub state
     *
     * @return string
     */
    public function getMessage() : string
    {
        return 'This commit message is fine, but the others are not so good.';
    }

    /**
     * Is true if the status on GitHub would be success
     *
     * @return boolean
     */
    public function isPositive() : bool
    {
        return false;
    }

    /**
     * Get a URL with further explanation about this commit message status
     *
     * @return string
     */
    public function getDetailsUrl() : string
    {
        return "http://chris.beams.io/posts/git-commit/";
    }
}
