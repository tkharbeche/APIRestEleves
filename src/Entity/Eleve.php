<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\MoyenneEleve;
use App\Controller\MoyenneGeneraleClasse;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "post",
 *          "get_moyenne_generale" = {
 *              "method" = "GET",
 *              "path" = "/eleves/moyenneGenerale",
 *              "controller" = MoyenneGeneraleClasse::class,
 *              "normalization_context"={"groups"={"moyenneGeneraleClasse"}},
 *              "attributes"={"id"=true}
 *          },
 *     },
 *     itemOperations={
 *          "put",
 *          "delete",
 *          "get",
 *          "get_moyenne_eleve" = {
 *              "method" = "GET",
 *              "path" = "/eleves/{id}/moyenne",
 *              "controller" = MoyenneEleve::class,
 *              "normalization_context"={"groups"={"moyenneEleve"}},
 *          },
 *
 *      },
 *
 *     normalizationContext={"groups"={"eleve:read"}},
 *     denormalizationContext={"groups"={"eleve:write"}}
 * )
 * @ORM\Entity(repositoryClass=EleveRepository::class)
 */
class Eleve
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"eleve:write", "eleve:read", "moyenneEleve", "moyenneGeneraleClasse"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"eleve:write", "eleve:read", "moyenneEleve", "moyenneGeneraleClasse"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="datetime")
     *
     * @Groups({"eleve:write", "eleve:read", "moyenneEleve", "moyenneGeneraleClasse"})
     *
     */
    private $dateNaissance;

    /**
     * @ORM\OneToMany(targetEntity=Note::class, mappedBy="eleves")
     *
     * @Groups({"moyenneEleve"})
     */
    private $notes;

    /**
     * @param string $name Retrieve a Eleve moyenne .
     * @ORM\Column(type="float", nullable= true)
     *
     * @Groups({"eleve:read","moyenneEleve", "moyenneGeneraleClasse"})
     */
    private $moyenne;


    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * @return Collection|Note[]
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): self
    {
        if (!$this->notes->contains($note)) {
            $this->notes[] = $note;
            $note->setEleves($this);
        }

        return $this;
    }

    public function removeNote(Note $note): self
    {
        if ($this->notes->contains($note)) {
            $this->notes->removeElement($note);
            // set the owning side to null (unless already changed)
            if ($note->getEleves() === $this) {
                $note->setEleves(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMoyenne() : ?float
    {
        return $this->moyenne;
    }

    /**
     * @param mixed $moyenne
     * @return Eleve
     */
    public function setMoyenne($moyenne) : self
    {
        $this->moyenne = $moyenne;
        return $this;
    }
}
