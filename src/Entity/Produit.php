<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
#[Vich\Uploadable()]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[Vich\UploadableField(mapping:'thumbnail_produit_image',fileNameProperty:'image')]
    public ?File $thumbnailFile=null;

    #[ORM\Column(length: 255)]
    private ?string $provenance = null;

    #[ORM\Column]
    private ?float $prixDeVente = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $premiereImage = null;
    // 
    #[Vich\UploadableField(mapping:'thumbnail_produit_premier_image',fileNameProperty:'premiereImage')]
    public ?File $thumbnailPremiereImage=null;

    #[ORM\Column(length: 255)]
    private ?string $secondeImage = null;
    // 
    #[Vich\UploadableField(mapping:'thumbnail_produit_seconde_image',fileNameProperty:'secondeImage')]
    public ?File $thumbnailSecondeImage=null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $derniereImage = null;
    //
    #[Vich\UploadableField(mapping:'thumbnail_produit_derniere_image',fileNameProperty:'derniereImage')]
    public ?File $thumbnailDerniereImage=null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, DetailCommande>
     */
    #[ORM\OneToMany(targetEntity: DetailCommande::class, mappedBy: 'produit')]
    private Collection $detailCommandes;

    public function __construct()
    {
        $this->detailCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of thumbnailFile
     */ 
    public function getThumbnailFile()
    {
        return $this->thumbnailFile;
    }

    /**
     * Set the value of thumbnailFile
     *
     * @return  self
     */ 
    public function setThumbnailFile($thumbnailFile):static
    {
        $this->thumbnailFile = $thumbnailFile;

        return $this;
    }

    public function getProvenance(): ?string
    {
        return $this->provenance;
    }

    public function setProvenance(string $provenance): static
    {
        $this->provenance = $provenance;

        return $this;
    }

    public function getPrixDeVente(): ?float
    {
        return $this->prixDeVente;
    }

    public function setPrixDeVente(float $prixDeVente): static
    {
        $this->prixDeVente = $prixDeVente;

        return $this;
    }

    public function getPremiereImage(): ?string
    {
        return $this->premiereImage;
    }

    public function setPremiereImage(?string $premiereImage): static
    {
        $this->premiereImage = $premiereImage;

        return $this;
    }

    public function getSecondeImage(): ?string
    {
        return $this->secondeImage;
    }

    public function setSecondeImage(string $secondeImage): static
    {
        $this->secondeImage = $secondeImage;

        return $this;
    }

    public function getDerniereImage(): ?string
    {
        return $this->derniereImage;
    }

    public function setDerniereImage(?string $derniereImage): static
    {
        $this->derniereImage = $derniereImage;

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

    /**
     * Get the value of thumbnailPremiereImage
     */ 
    public function getThumbnailPremiereImage()
    {
        return $this->thumbnailPremiereImage;
    }

    /**
     * Set the value of thumbnailPremiereImage
     *
     * @return  self
     */ 
    public function setThumbnailPremiereImage($thumbnailPremiereImage):static
    {
        $this->thumbnailPremiereImage = $thumbnailPremiereImage;

        return $this;
    }

    /**
     * Get the value of thumbnailSecondeImage
     */ 
    public function getThumbnailSecondeImage()
    {
        return $this->thumbnailSecondeImage;
    }

    /**
     * Set the value of thumbnailSecondeImage
     *
     * @return  self
     */ 
    public function setThumbnailSecondeImage($thumbnailSecondeImage):static
    {
        $this->thumbnailSecondeImage = $thumbnailSecondeImage;

        return $this;
    }

    /**
     * Get the value of thumbnailDerniereImage
     */ 
    public function getThumbnailDerniereImage()
    {
        return $this->thumbnailDerniereImage;
    }

    /**
     * Set the value of thumbnailDerniereImage
     *
     * @return  self
     */ 
    public function setThumbnailDerniereImage($thumbnailDerniereImage):static
    {
        $this->thumbnailDerniereImage = $thumbnailDerniereImage;

        return $this;
    }

    /**
     * @return Collection<int, DetailCommande>
     */
    public function getDetailCommandes(): Collection
    {
        return $this->detailCommandes;
    }

    public function addDetailCommande(DetailCommande $detailCommande): static
    {
        if (!$this->detailCommandes->contains($detailCommande)) {
            $this->detailCommandes->add($detailCommande);
            $detailCommande->setProduit($this);
        }

        return $this;
    }

    public function removeDetailCommande(DetailCommande $detailCommande): static
    {
        if ($this->detailCommandes->removeElement($detailCommande)) {
            // set the owning side to null (unless already changed)
            if ($detailCommande->getProduit() === $this) {
                $detailCommande->setProduit(null);
            }
        }

        return $this;
    }
}
