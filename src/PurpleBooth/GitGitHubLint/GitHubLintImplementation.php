<?php
declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint;

use Github\Client;
use PhpSpec\Exception\Exception;
use PurpleBooth\GitGitHubLint\Exception\GitHubLintException;
use PurpleBooth\GitGitHubLint\Validator\CapitalizeTheSubjectLineValidator;
use PurpleBooth\GitGitHubLint\Validator\DoNotEndTheSubjectLineWithAPeriodValidator;
use PurpleBooth\GitGitHubLint\Validator\LimitTheBodyWrapLengthTo72CharactersValidator;
use PurpleBooth\GitGitHubLint\Validator\LimitTheTitleLengthTo69CharactersValidator;
use PurpleBooth\GitGitHubLint\Validator\SeparateSubjectFromBodyWithABlankLineValidator;
use PurpleBooth\GitGitHubLint\Validator\SoftLimitTheTitleLengthTo50CharactersValidator;

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
        $this->analyser = new AnalysePullRequestCommitsImplementation(
            new CommitMessageServiceImplementation($client),
            new ValidateMessagesImplementation(
                new ValidateMessageImplementation(
                    [
                        new CapitalizeTheSubjectLineValidator(),
                        new DoNotEndTheSubjectLineWithAPeriodValidator(),
                        new LimitTheBodyWrapLengthTo72CharactersValidator(),
                        new LimitTheTitleLengthTo69CharactersValidator(),
                        new SeparateSubjectFromBodyWithABlankLineValidator(),
                        new SoftLimitTheTitleLengthTo50CharactersValidator(),
                    ]
                )
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
