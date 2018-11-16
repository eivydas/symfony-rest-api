<?php

namespace App\Controller;

use App\Api\Client\GithubClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IssueController extends AbstractController
{
    public function index(Request $request, GithubClient $client)
    {
        $params = $request->query->all();

        try {
            return $this->json($client->getIssues($params), 200);
        } catch (\Exception $exception) {
            return $this->json(['code' => $exception->getCode(), 'message' => $exception->getMessage()], $exception->getCode());
        }
    }

    public function my(Request $request, GithubClient $client)
    {
        $params = $request->query->all();

        try {
            return $this->json($client->getMyIssues($params), 200);
        } catch (\Exception $exception) {
            return $this->json(['code' => $exception->getCode(), 'message' => $exception->getMessage()], $exception->getCode());
        }
    }

    public function comments(Request $request, GithubClient $client, $issueId)
    {
        $comment = $request->query->get('body') ?? '';

        try {
            return $this->json($client->createIssueComment($issueId, $comment), 201);
        } catch (\Exception $exception) {
            return $this->json(['code' => $exception->getCode(), 'message' => $exception->getMessage()], $exception->getCode());
        }
    }
}
