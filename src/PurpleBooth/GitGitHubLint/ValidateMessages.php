<?php
declare(strict_types = 1);
namespace PurpleBooth\GitGitHubLint;

use PurpleBooth\GitLintValidators\Message;

/**
 * This will evaluate messages with a status and set them on the message
 *
 * @package PurpleBooth\GitGitHubLint
 */
interface ValidateMessages
{
    /**
     * Evaluate multiple messages and set the most appropriate status.
     *
     * All status will fail after the first failure
     *
     * @param Message[] $messages
     *
     * @return void
     */
    public function validate(array $messages);
}
