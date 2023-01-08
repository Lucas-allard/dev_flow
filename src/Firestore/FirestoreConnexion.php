<?php

namespace App\Firestore;

use MrShan0\PHPFirestore\FirestoreClient;

class FirestoreConnexion
{
    private FirestoreClient $client;
    private string $projectId ;
    private string $apiKey;

    public function __construct()
    {
        $this->projectId = getenv('GOOGLE_PROJECT_ID');
        $this->apiKey = getenv('GOOGLE_API_KEY');

        $this->client = new FirestoreClient($this->projectId, $this->apiKey, [
            'database' => "(default)"
        ]);
    }

    public function getClient()
    {
        return $this->client;
    }

}