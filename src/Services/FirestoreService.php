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
        $this->firestore->addDocument($collectionName, $data);
    }

}