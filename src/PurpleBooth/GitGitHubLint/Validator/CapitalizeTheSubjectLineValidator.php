<?php

declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint\Validator;

use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\CapitalizeTheSubjectLineStatus;
use PurpleBooth\GitGitHubLint\Status\Status;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;

/**
 * This validator will check if the subject line is capitalised in the message
 *
 * @see     CapitalizeTheSubjectLineStatus
 * @see     SuccessStatus
 *
 * @package PurpleBooth\GitGitHubLint\Validator
 */
class CapitalizeTheSubjectLineValidator implements Validator
{
    /**
     * Check if a message passes a specific test, and return a status that identifies if it is or isn't
     *
     * @param Message $message
     *
     * @return Status
     */
    public function validate(Message $message) : Status
    {
        if ($message->isTitleCapitalised()) {
            return new SuccessStatus();
        }

        return new CapitalizeTheSubjectLineStatus();
    }
}
