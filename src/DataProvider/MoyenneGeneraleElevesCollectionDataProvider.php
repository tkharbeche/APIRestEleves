<?php


namespace App\DataProvider;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Eleve;

class MoyenneGeneraleElevesCollectionDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Eleve::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null) : \Generator
    {
        yield new Eleve();
    }

}