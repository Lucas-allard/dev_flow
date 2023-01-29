<?php

namespace App\Normalizer;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class UserNormalizer
{
    private array $context;

    public function __construct(private NormalizerInterface $normalizer)
    {
    }

    /**
     * @throws ExceptionInterface
     */
    public function normalize($user): array
    {
        return $this->normalizer->normalize($user, 'json', ['groups' => 'user:read']);
    }
}