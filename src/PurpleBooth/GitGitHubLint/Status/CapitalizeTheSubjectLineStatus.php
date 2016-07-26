<?php

declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint\Status;

use PurpleBooth\GitGitHubLint\Validator\CapitalizeTheSubjectLineValidator;

/**
 * This is the status returned when the CapitalizeTheSubjectLineValidator identifies a problem
 *
 * @see     CapitalizeTheSubjectLineValidator
 *
 * @package PurpleBooth\GitGitHubLint\Status
 */
class CapitalizeTheSubjectLineStatus implements Status
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
        return Status::WEIGHT_ERROR;
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
        return 'Please capitalise the subject line of the commit message';
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
        return Status::STATE_FAILURE;
    }
}
