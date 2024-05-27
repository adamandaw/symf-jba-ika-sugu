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

 
            $commande = new Commande();
            $form = $this->createForm(CommandeType::class, $commande);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                // dd("ss");
                $session->set('telephone',$form->get("telephone")->getData());
                return $this->redirectToRoute('app_commande_new', [], Response::HTTP_SEE_OTHER);
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
        $montant = 0;
        $tableauDeCommande=["id"=>null,"quantiteCommander"=> null];
        if ($request->isMethod("POST")) {
            // dd($_POST);
            extract($_POST);
            $leProduit = $produitRepository->findOneBy(['id' => intval($productId)]);
            if ($leProduit !== null) {
                $tableauDeCommande['id']=$leProduit->getId();
                $tableauDeCommande['quantiteCommander']=intval($quantite);

                if (array_key_exists($tableauDeCommande['id'],$tableauDeCommande)) {
                    $tableauDeCommande['quantiteCommander'] = $tableauDeCommande['quantiteCommander'] +  intval($quantite);
                }else {
                    $tableauDeCommande[] =["id"=>$leProduit->getId(),"quantiteCommander"=> intval($quantite),];
                }
                
                // Récupérer la quantité du produit dans la session
                $quantiteCommande = $session->get('qte' . $leProduit->getId(), 0);
        
                // Mettre à jour la quantité dans la session
                $quantiteCommande += intval($quantite);
                $session->set('qte' . $leProduit->getId(), $quantiteCommande);
        
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
        // dd($tableauDeCommande);
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
    #[Route('/panier/delete', name: 'app_trash_panier')]
    public function viderPanier(SessionInterface $session): Response
    {
        $session->remove('panier');
        $session->remove('montant');
        $session->remove('commande_montant');
        return $this->redirectToRoute("app_home");
    }

    
}
