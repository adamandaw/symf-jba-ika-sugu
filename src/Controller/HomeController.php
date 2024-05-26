<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Form\FilterProduitByCategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProduitRepository $produitRepository,Request $request,SessionInterface $session): Response
    {
        // dd($this->getUser());
        $form = $this->createForm(FilterProduitByCategoryType::class);
        $form->handleRequest($request);
        $listes=[];
        $listes=$produitRepository->findAll();
        if ($form->isSubmitted() && $form->isValid()) {

            // dd($form->get('libelle')->getData()->getLibelle());
            switch ($form->get('libelle')->getData()->getLibelle()) {
                case 'Epices':
                    // dd("test");
                    $session->set('image_name',"WhatsApp Image 2024-05-25 at 15.07.00.jpeg");
                   
                    return $this->redirectToRoute("app_category_list_produit",['id' => $form->get('libelle')->getData()->getId()] );
                    break;
                    case 'Les Amuse-Gueules':
                        return $this->redirectToRoute("app_category_list_produit",['id' => $form->get('libelle')->getData()->getId()] );
                        break;
                        case 'Fruit':
                            $session->set('image_name',"WhatsApp Image 2024-05-25 at 16.41.34.jpeg");
                        return $this->redirectToRoute("app_category_list_produit",['id' => $form->get('libelle')->getData()->getId()] );
                    break;
                case 'Céréale':
                        return $this->redirectToRoute("app_category_list_produit",['id' => $form->get('libelle')->getData()->getId()] );
                    break;
                case 'Condiment':
                        return $this->redirectToRoute("app_category_list_produit",['id' => $form->get('libelle')->getData()->getId()] );
                    break;
                
                default:
                    # code...
                    break;
            }
            // $listes=$produitRepository->findBy(['category' => $form->get('libelle')->getData(),]);
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
