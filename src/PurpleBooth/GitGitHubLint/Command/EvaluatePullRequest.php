<?php
declare(strict_types = 1);

namespace PurpleBooth\GitGitHubLint\Command;

use Github\Client;
use PurpleBooth\GitGitHubLint\GitHubLintImplementation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * A command that allows you to try out the library
 *
 * @package PurpleBooth\GitGitHubLint\Command
 */
class EvaluatePullRequest extends Command
{
    const ARGUMENT_GITHUB_USERNAME   = 'github-username';
    const ARGUMENT_GITHUB_REPOSITORY = 'github-repository';
    const ARGUMENT_PULL_REQUEST_ID   = 'pull-request-id';
    const OPTION_TOKEN               = 'token';
    const COMMAND_NAME               = 'git-github-lint:pr';

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription("Check the style of commit messages in a pull request");

        $help = '';
        $help .= "Evaluates a the commits in a pull request and checks that their messages match the style advised by ";
        $help .= "Git. It will then update the \"status\" in github (that little dot next to the commits).\n";
        $help .= "\n";
        $help .= "\n";
        $help .= "Here are some good articles on commit message style:\n";
        $help .= "\n";
        $help .= "* http://chris.beams.io/posts/git-commit/\n";
        $help .= "* https://git-scm.com/book/ch5-2.html#Commit-Guidelines\n";
        $help .= "* https://github.com/blog/926-shiny-new-commit-styles\n";

        $this->setHelp($help);
        $this->setDefinition(
            new InputDefinition(
                [
                    new InputArgument(
                        self::ARGUMENT_GITHUB_USERNAME,
                        InputArgument::REQUIRED,
                        'GitHub Username'
                    ),
                    new InputArgument(
                        self::ARGUMENT_GITHUB_REPOSITORY,
                        InputArgument::REQUIRED,
                        'GitHub Repository'
                    ),
                    new InputArgument(
                        self::ARGUMENT_PULL_REQUEST_ID,
                        InputArgument::REQUIRED,
                        'The ID of the pull request'
                    ),
                    new InputOption(
                        self::OPTION_TOKEN,
                        't',
                        InputOption::VALUE_REQUIRED,
                        'The token to authenticate to the API with.'
                    ),
                ]
            )
        );
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @return null|int null or 0 if everything went fine, or an error code
     *
     * @see setCode()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io       = new SymfonyStyle($input, $output);
        $config   = new Client();
        $lintTool = new GitHubLintImplementation($config);

        $authenticationType = Client::AUTH_HTTP_TOKEN;

        $config->authenticate(
            $input->getOption(self::OPTION_TOKEN),
            null,
            $authenticationType
        );

        $gitHubUsername   = $input->getArgument(self::ARGUMENT_GITHUB_USERNAME);
        $gitHubRepository = $input->getArgument(self::ARGUMENT_GITHUB_REPOSITORY);
        $pullRequestId    = $input->getArgument(self::ARGUMENT_PULL_REQUEST_ID);
        $printableName    = "$gitHubUsername/$gitHubRepository#$pullRequestId";


        $io->title(self::COMMAND_NAME);
        $io->comment("Analysing PR $printableName");
        $lintTool->analyse(
            $gitHubUsername,
            $gitHubRepository,
            (int)$pullRequestId
        );
        $io->success("Finished!");

        return 0;
    }
}
