<?php

namespace spec\PurpleBooth\GitGitHubLint;

use Github\Api\Repo;
use Github\Api\Repository\Statuses;
use Github\Client;
use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\GitHubMessage;
use PurpleBooth\GitGitHubLint\Status\SuccessStatus;
use PurpleBooth\GitGitHubLint\StatusSendService;
use PurpleBooth\GitGitHubLint\StatusSendServiceImplementation;

class StatusSendServiceImplementationSpec extends ObjectBehavior
{
    function it_is_initializable(Client $client)
    {
        $this->beConstructedWith($client);
        $this->shouldHaveType(StatusSendServiceImplementation::class);
        $this->shouldHaveType(StatusSendService::class);
    }

    function it_passes_the_highest_weight_status_to_github(
        Client $client,
        Repo $repo,
        Statuses $statuses,
        GitHubMessage $message
    ) {
        $this->beConstructedWith($client);

        $client->repo()->willReturn($repo);
        $repo->statuses()->willReturn($statuses);

        $organisation = "organisation";
        $repository   = "repository";
        $status       = new SuccessStatus();

        $message->getSha()->willReturn("a224");
        $message->getHighestWeightStatus()->willReturn($status);

        $statuses->create(
            $organisation,
            $repository,
            "a224",
            [
                'state'       => 'success',
                'description' => $status->getMessage(),
                'context'     => StatusSendServiceImplementation::CONTEXT,
                'target_url'  => $status->getDetailsUrl(),
            ]
        )->shouldBeCalled();

        $this->updateStatus($organisation, $repository, $message);
    }
}
