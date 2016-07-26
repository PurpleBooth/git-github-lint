<?php

namespace spec\PurpleBooth\GitGitHubLint;

use Github\Client;
use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\GitHubLint;
use PurpleBooth\GitGitHubLint\GitHubLintImplementation;

class GitHubLintImplementationSpec extends ObjectBehavior
{
    function it_is_initializable(Client $client)
    {
        $this->beConstructedWith($client);
        $this->shouldHaveType(GitHubLintImplementation::class);
        $this->shouldHaveType(GitHubLint::class);
    }
}
