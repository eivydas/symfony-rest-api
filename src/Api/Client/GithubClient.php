<?php

namespace App\Api\Client;

use App\Api\Entity\Comment;
use App\Api\Entity\Issue;
use App\Api\Entity\User;
use Github\Client;

class GithubClient implements ClientInterface
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getMyIssues(array $params = []): array
    {
        $user = $this->currentUser();

        return $this->getIssues(array_merge($params, ['creator' => $user['login']]));
    }

    public function getIssues(array $params = [])
    {
        return $this->convertIssue($this->client->api('issue')->all(getenv('GITHUB_USER_ORG'), getenv('GITHUB_REPOSITORY'), $params));
    }

    public function createIssueComment(int $issueId, string $comment)
    {
        $user = $this->currentUser();

        return $this->convertComment($this->client->api('issue')->comments()->create(getenv('GITHUB_USER_ORG'), getenv('GITHUB_REPOSITORY'), $issueId, ['creator' => $user['login'], 'body' => $comment]));
    }

    private function currentUser()
    {
        return $this->client->me()->show();
    }

    private function convertIssue(array $array)
    {
        $data = [];
        foreach ($array as $key => $value) {
            $user = new User();
            $user->setId($value["user"]["id"]);
            $user->setLogin($value["user"]["login"]);

            $issue = new Issue();
            $issue->setId($value["id"]);
            $issue->setTitle($value["title"]);
            $issue->setState($value["state"]);
            $issue->setCreatedAt($value["created_at"]);
            $issue->setUpdatedAt($value["updated_at"]);
            $issue->setLabels(array_column($value["labels"], 'name'));
            $issue->setUser($user);

            array_push($data, $issue);
        }

        return $data;
    }

    private function convertComment(array $value)
    {
        $data = [];

        $user = new User();
        $user->setId($value["user"]["id"]);
        $user->setLogin($value["user"]["login"]);

        $comment = new Comment();
        $comment->setId($value["id"]);
        $comment->setComment($value["body"]);
        $comment->setCreatedAt($value["created_at"]);
        $comment->setUpdatedAt($value["updated_at"]);
        $comment->setUser($user);

        array_push($data, $comment);

        return $data;
    }
}