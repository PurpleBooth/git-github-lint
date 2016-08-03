<?php
declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint;

use Github\Api\Repo;
use Github\Api\Repository\Statuses;
use Github\Client;

/**
 * Sets statuses on a SHA on GitHub
 *
 * @package PurpleBooth\GitGitHubLint
 */
class StatusSendServiceImplementation implements StatusSendService
{
    const CONTEXT               = 'Commit Message Style';
    const GITHUB_STATUS_SUCCESS = 'success';
    const GITHUB_STATUS_FAILURE = 'failure';

    /**
     * @var Client
     */
    private $client;

    /**
     * StatusSendServiceImplementation constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Set a SHA in GitHub to a state
     *
     * @param string        $organisation
     * @param string        $repository
     * @param GitHubMessage $message
     */
    public function updateStatus(string $organisation, string $repository, GitHubMessage $message)
    {
        $status = $message->getHighestWeightStatus();

        /** @var Repo $repoApi */
        $repoApi = $this->client->repo();

        /** @var Statuses $statusesApi */
        $statusesApi = $repoApi->statuses();
        $state       = self::GITHUB_STATUS_SUCCESS;

        if (!$status->isPositive()) {
            $state = self::GITHUB_STATUS_FAILURE;
        }

        $statusesApi->create(
            $organisation,
            $repository,
            $message->getSha(),
            [
                'state'       => $state,
                'description' => $status->getMessage(),
                'context'     => self::CONTEXT,
                'target_url'  => $status->getDetailsUrl(),
            ]
        );
    }
}
