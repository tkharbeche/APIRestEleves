<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"note:read"}},
 *     denormalizationContext={"groups"={"note:write"}},
 *
 *     collectionOperations={"post"},
 *     itemOperations={"get"}
 * )
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @Groups("note:write")
     */
    private $score;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups("note:write")
     */
    private $matiere;

    /**
     * @ORM\ManyToOne(targetEntity=Eleve::class, inversedBy="notes", cascade={"remove"})
     * @ORM\JoinColumn(name="eleve_id", nullable=false, onDelete="CASCADE")
     *
     * @Groups("note:write")
     */
    private $eleves;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->matiere;
    }

    public function setMatiere(?string $matiere): self
    {
        $this->matiere = $matiere;

        return $this;
    }

    public function getEleves(): ?Eleve
    {
        return $this->eleves;
    }

    public function setEleves(?Eleve $eleves): self
    {
        $this->eleves = $eleves;

        return $this;
    }
}
