<?php
declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint;

use PurpleBooth\GitGitHubLint\Status\PreviousFailureStatus;
use PurpleBooth\GitGitHubLint\Status\Status;

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
     * @param Message[] $messages
     *
     * @return null
     */
    public function validate(array $messages)
    {
        $seenFailedStatus = null;

        /** @var Message $message */
        foreach ($messages as $message) {
            /** @var Status $status */
            $status = $this->validateMessage->validate($message);

            if (!$status->isPositive()) {
                $message->setStatus($status);
                $seenFailedStatus = new PreviousFailureStatus();
            } else {
                if ($seenFailedStatus) {
                    $message->setStatus($seenFailedStatus);
                } else {
                    $message->setStatus($status);
                }
            }
        }
    }
}
