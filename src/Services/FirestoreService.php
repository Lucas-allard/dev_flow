<?php

namespace App\Services;

use App\Firestore\FirestoreConnexion;
use MrShan0\PHPFirestore\FirestoreClient;

class FirestoreService
{
    private FirestoreClient $firestore;

    /**
     * @param FirestoreConnexion $connexion
     */
    public function __construct(FirestoreConnexion $connexion)
    {
        $this->firestore = $connexion->getClient();
    }

    public function addDocument(string $collectionName, array $data)
    {
        // add document to firestore
        $this->firestore->addDocument($collectionName, $data);
    }

    public function isSuccess(): bool
    {
        $response = $this->firestore->getLastResponse();
        return $response->getStatusCode() === 200;
    }

}