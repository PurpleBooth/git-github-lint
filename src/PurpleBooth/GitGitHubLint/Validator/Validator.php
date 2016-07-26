<?php
declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint\Validator;

use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\Status\Status;

/**
 * Checks if a message meets a specific rule, and returns a status appropriate for the test passing or not passing
 *
 * @package PurpleBooth\GitGitHubLint\Validator
 */
interface Validator
{
    /**
     * Check if a message passes a specific test, and return a status that identifies if it is or isn't
     *
     * @param Message $message
     *
     * @return Status
     */
    public function validate(Message $message) : Status;
}
