<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Form\CommandeType;
use App\Form\PanierAddQuantiteType;
use App\Repository\CategoryRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/mon-panier/list', name: 'app_panier', methods: ['GET', 'POST'])]
    public function index(Request $request,CategoryRepository $categoryRepository,SessionInterface $session,ProduitRepository $produitRepository): Response
    {
        $panier = $session->get('panier');

        if ($session->has('panier')) {
            
            $commande = new Commande();
            $form = $this->createForm(CommandeType::class, $commande);
            $form->handleRequest($request);
        }
        // $session->remove('panier');
        $maListe=[];
        if ($panier !== null ) {
            foreach ($panier as   $id) {
                $produit= $produitRepository->findOneBy(['id' => $id]);
                if ($produit !== null) {
                    $maListe[]=$produit;
                }
            }
        }

        // dd($panier);        
        $montant=0;
        if ($request->isMethod("POST") ) {
            extract($_POST);
            // dd($_POST);        
            // faire des comparaison sur la qte disponible etc 
            $leProduit= $produitRepository->findOneBy(['id' => intval($productId)]);
            if ($leProduit !== null) {
                $tableau[] = $leProduit->getId();
        
                // Récupérer la quantité du produit dans la session
                $quantiteCommande = $session->get('qte_' . $leProduit->getId(), 0);
                
                // Mettre à jour la quantité dans la session
                $quantiteCommande += intval($quantite);
                $session->set('qte_' . $leProduit->getId(), $quantiteCommande);
                
                 // Récupérer le montant total actuel depuis la session
                $montantTotal = $session->get('commande_montant', 0);

                // Calculer le nouveau montant
                $nouveauMontant = $leProduit->getPrixDeVente() * intval($quantite);
                // Mettre à jour le montant total
                $montantTotal += $nouveauMontant;
                $session->set('commande_montant', $montantTotal);
                // Mettre à jour le montant de la requête
                $montant = $montantTotal;
                $session->set('montant', $montant);

               
            }
        }
        
        return $this->render('panier/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'maListe' => $maListe,
            'montant' => $montant,
            'formAction' => $_ENV['APP_URL'],
            'formCommande' => $form,
        ]);
    }
   
    #[Route('/add-panier-produit-{id}', name: 'app_add_panier_home')]
    public function addPanier($id ,SessionInterface $session,ProduitRepository $produitRepository): Response
    {
        $produit= $produitRepository->findOneBy(['id' => $id]);
        if ($produit === null) {
            dd("error");
        }
        $panier = $session->get('panier', []);
        if (!in_array($produit->getId(), $panier)) {
            $panier[] = $produit->getId();
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute("app_home");
    }
   
    #[Route('/produit/{id}/detail/panier', name: 'app_add_panier_produit_detail')]
    public function addPanierThenShowDetailPage($id ,SessionInterface $session,ProduitRepository $produitRepository): Response
    {
        $produit= $produitRepository->findOneBy(['id' => $id]);
        if ($produit === null) {
            dd("error");
        }
        $panier = $session->get('panier', []);

        if (!in_array($produit->getId(), $panier)) {
            $panier[] = $produit->getId();
        }

        $session->set('panier', $panier);
        return $this->redirectToRoute("app_produit_show",['id' => $id]);
    }
}
