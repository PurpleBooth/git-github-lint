<?php

namespace spec\PurpleBooth\GitGitHubLint;

use Github\Api\PullRequest;
use Github\Client;
use PhpSpec\ObjectBehavior;
use PurpleBooth\GitGitHubLint\CommitMessageService;
use PurpleBooth\GitGitHubLint\CommitMessageServiceImplementation;
use PurpleBooth\GitGitHubLint\Message;
use PurpleBooth\GitGitHubLint\MessageImplementation;

class CommitMessageServiceImplementationSpec extends ObjectBehavior
{
    function it_is_initializable(Client $client)
    {
        $this->beConstructedWith($client);
        $this->shouldHaveType(CommitMessageServiceImplementation::class);
        $this->shouldHaveType(CommitMessageService::class);
    }

    function it_will_get_the_commits_for_a_pull_request(
        Client $client,
        PullRequest $pullRequestApi
    ) {
        $client->api('pr')->willReturn($pullRequestApi);

        $apiResponse
            = '[
   {
      "url":"https://api.github.com/repos/octocat/Hello-World/commits/6dcb09b5b57875f334f61aebed695e2e4193db5e",
      "sha":"6dcb09b5b57875f334f61aebed695e2e4193db5e",
      "html_url":"https://github.com/octocat/Hello-World/commit/6dcb09b5b57875f334f61aebed695e2e4193db5e",
      "comments_url":"https://api.github.com/repos/octocat/Hello-World/commits/6dcb09b5b57875f334f61aebed695e2e4193db5e/comments",
      "commit":{
         "url":"https://api.github.com/repos/octocat/Hello-World/git/commits/6dcb09b5b57875f334f61aebed695e2e4193db5e",
         "author":{
            "name":"Monalisa Octocat",
            "email":"support@github.com",
            "date":"2011-04-14T16:00:49Z"
         },
         "committer":{
            "name":"Monalisa Octocat",
            "email":"support@github.com",
            "date":"2011-04-14T16:00:49Z"
         },
         "message":"Fix all the bugs",
         "tree":{
            "url":"https://api.github.com/repos/octocat/Hello-World/tree/6dcb09b5b57875f334f61aebed695e2e4193db5e",
            "sha":"6dcb09b5b57875f334f61aebed695e2e4193db5e"
         },
         "comment_count":0,
         "verification":{
            "verified":true,
            "reason":"valid",
            "signature":"-----BEGIN PGP MESSAGE-----\n...\n-----END PGP MESSAGE-----",
            "payload":"tree 6dcb09b5b57875f334f61aebed695e2e4193db5e\n..."
         }
      },
      "author":{
         "login":"octocat",
         "id":1,
         "avatar_url":"https://github.com/images/error/octocat_happy.gif",
         "gravatar_id":"",
         "url":"https://api.github.com/users/octocat",
         "html_url":"https://github.com/octocat",
         "followers_url":"https://api.github.com/users/octocat/followers",
         "following_url":"https://api.github.com/users/octocat/following{/other_user}",
         "gists_url":"https://api.github.com/users/octocat/gists{/gist_id}",
         "starred_url":"https://api.github.com/users/octocat/starred{/owner}{/repo}",
         "subscriptions_url":"https://api.github.com/users/octocat/subscriptions",
         "organizations_url":"https://api.github.com/users/octocat/orgs",
         "repos_url":"https://api.github.com/users/octocat/repos",
         "events_url":"https://api.github.com/users/octocat/events{/privacy}",
         "received_events_url":"https://api.github.com/users/octocat/received_events",
         "type":"User",
         "site_admin":false
      },
      "committer":{
         "login":"octocat",
         "id":1,
         "avatar_url":"https://github.com/images/error/octocat_happy.gif",
         "gravatar_id":"",
         "url":"https://api.github.com/users/octocat",
         "html_url":"https://github.com/octocat",
         "followers_url":"https://api.github.com/users/octocat/followers",
         "following_url":"https://api.github.com/users/octocat/following{/other_user}",
         "gists_url":"https://api.github.com/users/octocat/gists{/gist_id}",
         "starred_url":"https://api.github.com/users/octocat/starred{/owner}{/repo}",
         "subscriptions_url":"https://api.github.com/users/octocat/subscriptions",
         "organizations_url":"https://api.github.com/users/octocat/orgs",
         "repos_url":"https://api.github.com/users/octocat/repos",
         "events_url":"https://api.github.com/users/octocat/events{/privacy}",
         "received_events_url":"https://api.github.com/users/octocat/received_events",
         "type":"User",
         "site_admin":false
      },
      "parents":[
         {
            "url":"https://api.github.com/repos/octocat/Hello-World/commits/6dcb09b5b57875f334f61aebed695e2e4193db5e",
            "sha":"6dcb09b5b57875f334f61aebed695e2e4193db5e"
         }
      ]
   }
]';

        $pullRequestApi->commits('octocat', 'changes', 93)
                       ->willReturn(json_decode($apiResponse, true));

        $this->beConstructedWith($client);
        $this->getMessages("octocat", 'changes', 93)
             ->shouldContainMessages(
                 [
                     new MessageImplementation('6dcb09b5b57875f334f61aebed695e2e4193db5e', "Fix all the bugs"),
                 ]
             );
    }

    public function getMatchers()
    {
        return [
            'containMessages' => function (array $actualMessages, array $expectedMessages) {
                $getShas = function (Message $message) {
                    return $message->getSha();
                };

                $actualShas   = array_map(
                    $getShas,
                    $actualMessages
                );
                $expectedShas = array_map(
                    $getShas,
                    $expectedMessages
                );

                return $actualShas === $expectedShas;
            },
        ];
    }
}
