<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Form\FilterProduitByCategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProduitRepository $produitRepository,Request $request): Response
    {
        // dd($this->getUser());
        $form = $this->createForm(FilterProduitByCategoryType::class);
        $form->handleRequest($request);
        $listes=[];
        $listes=$produitRepository->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $listes=$produitRepository->findBy(['category' => $form->get('libelle')->getData(),]);
            // dd($listes);
        }
        return $this->render('home/index.html.twig', [
            'produits' => $listes,
            'form' => $form->createView(),
        ]);
    }
   
  
   
    #[Route('/presentation', name: 'app_about')]
    public function presentation(): Response
    {
        return $this->render('home/presentation.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
