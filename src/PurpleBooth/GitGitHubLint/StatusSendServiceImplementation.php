<?php
declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint;

use Github\Api\Repo;
use Github\Client;
use PurpleBooth\GitGitHubLint\Status\Status;

/**
 * Sets statuses on a SHA on GitHub
 *
 * @package PurpleBooth\GitGitHubLint
 */
class StatusSendServiceImplementation implements StatusSendService
{
    const CONTEXT = 'git-git-hub-lint';
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
     * @param string $organisation
     * @param string $repository
     * @param string $sha
     * @param Status $status
     */
    public function updateStatus(string $organisation, string $repository, string $sha, Status $status)
    {
        /** @var Repo $repoApi */
        $repoApi = $this->client->api('repo');
        $repoApi->statuses()
                ->create(
                    $organisation,
                    $repository,
                    $sha,
                    [
                        'state'       => $status->getState(),
                        'description' => $status->getMessage(),
                        'context'     => self::CONTEXT,
                    ]
                );
    }
}
