<?php


namespace App\Controller;


use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Entity\Eleve;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class MoyenneGeneraleClasse
{
    protected $em;
    protected $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;

    }

    public function __invoke($data): JsonResponse
    {

        $eleveRepo = $this->em->getRepository("App:Eleve");
        $eleves = $eleveRepo->findAll();

        $totalNotes = 0;
        $cpt = 0;
        foreach ($eleves as $eleve) {
            $totalNotes += $eleve->getMoyenne();
            $cpt++;
        }
        $moyenneGClasse = $totalNotes / $cpt;

        $tab ['moyenneGeneraleClasse'] = $moyenneGClasse;
        $json = $this->serializer->serialize($tab, 'json', ["classe" => "moyenneGeneraleClasse"]);

        return new JsonResponse($json, 200);

    }

}