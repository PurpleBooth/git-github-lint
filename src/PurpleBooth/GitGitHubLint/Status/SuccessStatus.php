<?php
declare(strict_types = 1);
namespace PurpleBooth\GitGitHubLint\Status;

use PurpleBooth\GitLintValidators\Status\Status;

/**
 * This is the status returned when a validator does not find any problems and no prior commits have had a problem
 *
 * @package PurpleBooth\GitGitHubLint\Status
 */
class SuccessStatus implements Status
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
        return Status::WEIGHT_SUCCESS;
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
        return 'Commit messages looking good!';
    }

    /**
     * Is true if the status on GitHub would be success
     *
     * @return boolean
     */
    public function isPositive() : bool
    {
        return true;
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
