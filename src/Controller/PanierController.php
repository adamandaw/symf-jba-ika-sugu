<?php

namespace App\Controller;

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
    #[Route('/mon-panier/list', name: 'app_panier')]
    public function index(Request $request,CategoryRepository $categoryRepository,SessionInterface $session,ProduitRepository $produitRepository): Response
    {
        $panier = $session->get('panier');
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
        $form = $this->createForm(PanierAddQuantiteType::class);
        $form->handleRequest($request);

        $cart=[];
        if ($form->isSubmitted() && $form->isValid()) {
            extract($_POST);
            $quantite=$form->get("quantite")->getData();
            // dd(intval($quantite) );
            // faire des comparaison sur la qte disponible etc 

            $leProduit= $produitRepository->findOneBy(['id' => $produit]);
            $cart[]=$leProduit;
            // return $this->redirectToRoute('app_category_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('panier/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'maListe' => $maListe,
            'form' => $form,
            'cart' => $cart,
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
