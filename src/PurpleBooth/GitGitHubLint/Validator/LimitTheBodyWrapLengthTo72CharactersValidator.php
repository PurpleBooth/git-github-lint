<?php

declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint\Validator;

use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\LimitTheBodyWrapLengthTo72CharactersStatus;
use PurpleBooth\GitGitHubLint\Status\Status;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;

/**
 * This validator will check the body width is 72 characters wide at the most
 *
 * @see     LimitTheBodyWrapLengthTo72CharactersStatus
 * @see     SuccessStatus
 *
 * @package PurpleBooth\GitGitHubLint\Validator
 */
class LimitTheBodyWrapLengthTo72CharactersValidator implements Validator
{
    const WRAP_LIMIT = 72;

    /**
     * Check if a message passes a specific test, and return a status that identifies if it is or isn't
     *
     * @param Message $message
     *
     * @return Status
     */
    public function validate(Message $message) : Status
    {
        if ($message->getBodyWrapLength() > self::WRAP_LIMIT) {
            return new LimitTheBodyWrapLengthTo72CharactersStatus();
        }

        return new SuccessStatus();
    }
}
