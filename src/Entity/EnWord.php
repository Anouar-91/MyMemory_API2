<?php

namespace App\Entity;

use App\Entity\FrWord;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Patch;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EnWordRepository;
use ApiPlatform\Metadata\ApiResource;
use App\Controller\CreateEnWordController;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: EnWordRepository::class)]
#[ApiResource(
    denormalizationContext: ['groups' => ['enword:write']], 
    operations:[
        new Post(
            controller: CreateEnWordController::class,
            validationContext: ['groups' => ['postValidation']],
        ),
        new Patch(

        )
    ]
)]
class EnWord
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['enword:write'])]
    #[Assert\NotNull([], "Ce champs ne peut pas être vide", groups: ['postValidation'])]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['enword:write'])]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $nbError = null;

    #[ORM\Column]
    private ?int $nbSuccess = null;

    #[Groups(['enword:write'])]
    #[Assert\NotNull([], "Ce champs ne peut pas être vide", groups: ['postValidation'])]
    public string $wordFr;

    #[Groups(['enword:write'])]
    public $frDescription;

    #[ORM\OneToMany(mappedBy: 'enWord', targetEntity: FrWord::class)]
    private Collection $frWords;

    #[ORM\ManyToOne(inversedBy: 'enWords')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;


    public function __construct()
    {
        $this->nbError = 0;
        $this->nbSuccess = 0;
        $this->createdAt = new \DateTime();
        $this->frWords = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getNbError(): ?int
    {
        return $this->nbError;
    }

    public function setNbError(int $nbError): static
    {
        $this->nbError = $nbError;

        return $this;
    }

    public function getNbSuccess(): ?int
    {
        return $this->nbSuccess;
    }

    public function setNbSuccess(int $nbSuccess): static
    {
        $this->nbSuccess = $nbSuccess;

        return $this;
    }

    /**
     * @return Collection<int, FrWord>
     */
    public function getFrWords(): Collection
    {
        return $this->frWords;
    }

    public function addFrWord(FrWord $frWord): static
    {
        if (!$this->frWords->contains($frWord)) {
            $this->frWords->add($frWord);
            $frWord->setEnWord($this);
        }

        return $this;
    }

    public function removeFrWord(FrWord $frWord): static
    {
        if ($this->frWords->removeElement($frWord)) {
            // set the owning side to null (unless already changed)
            if ($frWord->getEnWord() === $this) {
                $frWord->setEnWord(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
