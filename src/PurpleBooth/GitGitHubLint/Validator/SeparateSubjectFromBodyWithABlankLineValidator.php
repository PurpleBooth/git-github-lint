<?php

declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint\Validator;

use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\SeparateSubjectFromBodyWithABlankLineStatus;
use PurpleBooth\GitGitHubLint\Status\Status;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;

/**
 * This validator will check the subject and the body have a blank line in between te two
 *
 * @see     SeparateSubjectFromBodyWithABlankLineStatus
 * @see     SuccessStatus
 *
 * @package PurpleBooth\GitGitHubLint\Validator
 */
class SeparateSubjectFromBodyWithABlankLineValidator implements Validator
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
        if (!$message->hasBlankLineAfterTitle()) {
            return new SeparateSubjectFromBodyWithABlankLineStatus();
        }

        return new SuccessStatus();
    }
}
