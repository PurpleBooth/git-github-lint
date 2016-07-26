<?php

namespace spec\PurpleBooth\GitGitHubLint\Exception;

use Exception;
use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\Exception\GitHubLintException;

class GitHubLintExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GitHubLintException::class);
        $this->shouldHaveType(Exception::class);
    }
}
