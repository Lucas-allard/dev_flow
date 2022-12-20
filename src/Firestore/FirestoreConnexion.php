<?php

namespace App\Firestore;

use MrShan0\PHPFirestore\FirestoreClient;

class FirestoreConnexion
{
    private FirestoreClient $client;
    private string $projectId = "dev-flow-chat";
    private string $apiKey = "31f2507d298ff81d98fb43e1e8c7c652006bbf84";

    public function __construct()
    {
        $this->client = new FirestoreClient($this->projectId, $this->apiKey, [
            'database' => "(default)"
        ]);
    }

    public function getClient()
    {
        return $this->client;
    }

}