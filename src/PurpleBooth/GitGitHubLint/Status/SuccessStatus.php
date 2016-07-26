<?php
declare(strict_types = 1);
namespace PurpleBooth\GitGitHubLint\Status;

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
        return 'Commit message looking good!';
    }

    /**
     * Is true if the status on GitHub would be success
     *
     * @return boolean
     */
    public function isPositive() : bool
    {
        return $this->getState() == Status::STATE_SUCCESS;
    }

    /**
     * The GitHub equivalent of this state
     *
     * Can be one of pending, success, error, or failure.
     *
     * @return string
     */
    public function getState() : string
    {
        return Status::STATE_SUCCESS;
    }
}
