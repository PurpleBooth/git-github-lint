<?php
declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint;

use PurpleBooth\GitGitHubLint\Status\PreviousFailureStatus;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;
use PurpleBooth\GitLintValidators\Message;
use PurpleBooth\GitLintValidators\ValidateMessage;

/**
 * This will evaluate messages with a status and set them on the message
 *
 * @package PurpleBooth\GitGitHubLint
 */
class ValidateMessagesImplementation implements ValidateMessages
{
    /**
     * @var ValidateMessage
     */
    private $validateMessage;


    /**
     * ValidateServiceImplementation constructor.
     *
     * @param ValidateMessage $validateMessage
     */
    public function __construct(ValidateMessage $validateMessage)
    {
        $this->validateMessage = $validateMessage;
    }

    /**
     * Evaluate multiple messages and set the most appropriate status.
     *
     * All status will fail after the first failure
     *
     * @param Message[] $messages
     *
     * @return void
     */
    public function validate(array $messages)
    {
        $previousFailedStatus = null;

        /** @var Message $message */
        foreach ($messages as $message) {
            $this->validateMessage->validate($message);

            if (count($message->getStatuses()) < 1) {
                if ($previousFailedStatus) {
                    $message->addStatus($previousFailedStatus);
                } else {
                    $message->addStatus(new SuccessStatus());
                }
            } else {
                $previousFailedStatus = new PreviousFailureStatus();
            }
        }
    }
}
