<?php
declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint;

use Github\Client;

/**
 * Get commit messages from GitHub and turns them into messages
 *
 * @package PurpleBooth\GitGitHubLint
 */
class CommitMessageServiceImplementation implements CommitMessageService
{
    /**
     * @var Client
     */
    private $client;


    /**
     * CommitMessageServiceImplementation constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get an array of commit messages for a specific PR
     *
     * @param string $username
     * @param string $repository
     * @param int    $pullRequestId
     *
     * @return array
     */
    public function getMessages(string $username, string $repository, int $pullRequestId) : array
    {
        /** @var \Github\Api\PullRequest $prApi */
        $prApi    = $this->client->api('pr');
        $response = $prApi->commits($username, $repository, $pullRequestId);

        $messages = [];

        foreach ($response as $commit) {
            $messages[] = new MessageImplementation($commit['sha'], $commit['commit']['message']);
        }

        return $messages;
    }
}
