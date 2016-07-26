<?php
declare(strict_types = 1);
namespace PurpleBooth\GitGitHubLint;

use PurpleBooth\GitGitHubLint\Status\Status;
use PurpleBooth\GitGitHubLint\Validator\Validator;

/**
 * Validate against a number of validators against a message and return the most high priority status for that message
 *
 * @package PurpleBooth\GitGitHubLint
 */
class ValidateMessageImplementation implements ValidateMessage
{
    /**
     * @var array
     */
    private $validators;

    /**
     * ValidationServiceImplementation constructor.
     *
     * @param array $validators
     */
    public function __construct(array $validators)
    {
        $this->validators = $validators;

        if (count($validators) < 1) {
            new \LogicException("You need to provide the validation service with at least 1 validator");
        }
    }

    /**
     * Test a message against a number of validators
     *
     * @param Message $message
     *
     * @return Status
     */
    public function validate(Message $message) : Status
    {
        $statuses = [];

        /** @var Validator $validator */
        foreach ($this->validators as $validator) {
            $statuses[] = $validator->validate($message);
        }

        usort(
            $statuses,
            function (Status $statusA, Status $statusB) {
                return $statusA->getWeight() <=> $statusB->getWeight();
            }
        );

        return array_pop($statuses);
    }
}
