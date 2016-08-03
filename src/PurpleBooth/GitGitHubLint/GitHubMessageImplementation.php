<?php
declare(strict_types = 1);
namespace PurpleBooth\GitGitHubLint;

use PurpleBooth\GitLintValidators\Status\Status;
use PurpleBooth\GitLintValidators\MessageImplementation;


/**
 * A GitHub Commit Message
 *
 * @package PurpleBooth\GitGitHubLint
 */
class GitHubMessageImplementation extends MessageImplementation implements GitHubMessage
{
    /**
     * @var string
     */
    private $sha;

    /**
     * GitHubMessageImplementation constructor.
     *
     * @param string $message
     * @param string $sha
     */
    public function __construct(string $message, string $sha)
    {
        parent::__construct($message);
        $this->sha = $sha;
    }

    /**
     * Get the highest weight status associated with this message
     *
     * @return Status
     */
    public function getHighestWeightStatus() : Status
    {
        $statuses = $this->getStatuses();

        usort(
            $statuses,
            function (Status $statusA, Status $statusB) {
                return $statusA->getWeight() <=> $statusB->getWeight();
            }
        );

        return array_pop($statuses);
    }

    /**
     * Get the SHA for this commit
     *
     * @return string
     */
    public function getSha() : string
    {
        return $this->sha;
    }
}
