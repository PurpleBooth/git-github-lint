<?php

declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint\Validator;

use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\SoftLimitTheTitleLengthTo50CharactersStatus;
use PurpleBooth\GitGitHubLint\Status\Status;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;

/**
 * This validator will check the subject is not longer than 50 characters
 *
 * @see     SoftLimitTheTitleLengthTo50CharactersStatus
 * @see     SuccessStatus
 *
 * @package PurpleBooth\GitGitHubLint\Validator
 */
class SoftLimitTheTitleLengthTo50CharactersValidator implements Validator
{
    const CHARACTER_LIMIT = 50;

    /**
     * Check if a message passes a specific test, and return a status that identifies if it is or isn't
     *
     * @param Message $message
     *
     * @return Status
     */
    public function validate(Message $message) : Status
    {
        if ($message->getTitleLength() > self::CHARACTER_LIMIT) {
            return new SoftLimitTheTitleLengthTo50CharactersStatus();
        }

        return new SuccessStatus();
    }
}
