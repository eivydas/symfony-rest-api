<?php

namespace App\Api\Client;

interface ClientInterface
{
    public function getMyIssues(array $params = []);

    public function getIssues(array $params = []);

    public function createIssueComment(int $issueId, string $comment);
}
