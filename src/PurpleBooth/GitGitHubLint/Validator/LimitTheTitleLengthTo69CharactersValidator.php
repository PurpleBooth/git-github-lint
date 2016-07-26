<?php

declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint\Validator;

use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\LimitTheTitleLengthTo69CharactersStatus;
use PurpleBooth\GitGitHubLint\Status\Status;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;

/**
 * This validator will check the title length is at most 69 characters long
 *
 * @see     LimitTheTitleLengthTo69CharactersStatus
 * @see     SuccessStatus
 *
 * @package PurpleBooth\GitGitHubLint\Validator
 */
class LimitTheTitleLengthTo69CharactersValidator implements Validator
{
    const CHARACTER_LIMIT = 69;

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
            return new LimitTheTitleLengthTo69CharactersStatus();
        }

        return new SuccessStatus();
    }
}
