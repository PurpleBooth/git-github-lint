<?php
declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint;

use Github\Client;
use PhpSpec\Exception\Exception;
use PurpleBooth\GitGitHubLint\Exception\GitHubLintException;
use PurpleBooth\GitLintValidators\ValidatorFactoryImplementation;

/**
 * A vanity interface to make it easier to use this library
 *
 * @package PurpleBooth\GitGitHubLint
 */
class GitHubLintImplementation implements GitHubLint
{
    /**
     * @var AnalysePullRequestCommits
     */
    private $analyser;

    /**
     * GitHubLintImplementation constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $validatorFactory = new ValidatorFactoryImplementation();

        $this->analyser = new AnalysePullRequestCommitsImplementation(
            new CommitMessageServiceImplementation($client),
            new ValidateMessagesImplementation(
                $validatorFactory->getMessageValidator()
            ),
            new StatusSendServiceImplementation($client)
        );
    }

    /**
     * Analyse the commits on a pull request and set the statuses
     *
     * @param string $username
     * @param string $repository
     * @param int    $pullRequest
     *
     * @throws GitHubLintException if an undocumented exception is thrown, it'll be wrapped in this exception.
     */
    public function analyse(string $username, string $repository, int $pullRequest)
    {
        try {
            $this->analyser->check($username, $repository, $pullRequest);
        } catch (Exception $exception) {
            throw new GitHubLintException("An unexpected error has occurred", 0, $exception);
        }
    }
}
