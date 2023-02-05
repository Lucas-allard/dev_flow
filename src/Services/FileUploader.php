<?php

namespace App\Services;

use App\Entity\EntityInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 *
 */
class FileUploader
{
    /**
     * @var string
     */
    private string $targetDirectory;

    /**
     * @param $targetDirectory
     */
    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    /**
     * @param UploadedFile $file
     * @param EntityInterface $entity
     * @return void
     */
    public function upload(UploadedFile $file, EntityInterface $entity): void
    {

        $file->move($this->targetDirectory, $file->getFilename());

        if ($file->move($this->targetDirectory, $file->getFilename())) {
            $this->removePreviousPicture($entity);
        }

    }

    /**
     * @param EntityInterface $entity
     * @return void
     */
    public
    function removePreviousPicture(EntityInterface $entity): void
    {
        $previousPicture = $entity->getProfilPicture();
        if ($previousPicture) {
            unlink($this->targetDirectory . '/' . $previousPicture);
        }
    }
}
