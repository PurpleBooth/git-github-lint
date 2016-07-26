<?php

declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint\Validator;

use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\DoNotEndTheSubjectLineWithAPeriodStatus;
use PurpleBooth\GitGitHubLint\Status\Status;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;

/**
 * This validator will check if the subject line does not have a full stop at the end
 *
 * @see     DoNotEndTheSubjectLineWithAPeriodStatus
 * @see     SuccessStatus
 *
 * @package PurpleBooth\GitGitHubLint\Validator
 */
class DoNotEndTheSubjectLineWithAPeriodValidator implements Validator
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
        if ($message->hasTitleAFullStop()) {
            return new DoNotEndTheSubjectLineWithAPeriodStatus();
        }

        return new SuccessStatus();
    }
}
