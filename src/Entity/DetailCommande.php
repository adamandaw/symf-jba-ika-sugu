<?php

namespace App\Entity;

use App\Repository\DetailCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailCommandeRepository::class)]
class DetailCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantiteCommande = null;

    #[ORM\ManyToOne(inversedBy: 'detailCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $produit = null;

    #[ORM\ManyToOne(inversedBy: 'detailCommandes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteCommande(): ?int
    {
        return $this->quantiteCommande;
    }

    public function setQuantiteCommande(int $quantiteCommande): static
    {
        $this->quantiteCommande = $quantiteCommande;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }
}
