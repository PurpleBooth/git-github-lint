<?php
declare(strict_types = 1);
namespace PurpleBooth\GitGitHubLint;

use PurpleBooth\GitGitHubLint\Status\Status;

/**
 * Validate against a number of validators against a message and return the most high priority status for that message
 *
 * @package PurpleBooth\GitGitHubLint
 */
interface ValidateMessage
{
    /**
     * Test a message against a number of validators
     *
     * @param Message $message
     *
     * @return Status
     */
    public function validate(Message $message) : Status;
}
