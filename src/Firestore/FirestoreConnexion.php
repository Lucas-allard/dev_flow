<?php

namespace App\Firestore;

use MrShan0\PHPFirestore\FirestoreClient;

class FirestoreConnexion
{
    private FirestoreClient $client;
    private string $projectId;
    private string $apiKey;

    public function __construct(string $projectId, string $apiKey)
    {
        $this->projectId = $projectId;
        $this->apiKey = $apiKey;

        $this->client = new FirestoreClient($this->projectId, $this->apiKey, [
            'database' => "(default)"
        ]);
    }

    public function getClient()
    {
        return $this->client;
    }

}