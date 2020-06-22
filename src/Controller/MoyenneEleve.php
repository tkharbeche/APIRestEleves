<?php

namespace App\Controller;

use ApiPlatform\Core\Serializer\JsonEncoder;
use App\Entity\Eleve;
use App\Repository\EleveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\SerializerInterface;

class MoyenneEleve
{

    protected $em;
    protected $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->serializer = $serializer;

    }

    public function __invoke(Eleve $data): JsonResponse
    {
        $cpt = 0;
        $addition = 0;
        foreach ($data->getNotes() as $note){
            $addition += $note->getScore();
            $cpt++;
        }
        $moyenne = $addition / $cpt;
        $data->setMoyenne($moyenne);
        $this->em->persist($data);
        $this->em->flush();
        $json = $this->serializer->serialize($data, 'json');

        return new JsonResponse($json, 200);

    }
}
