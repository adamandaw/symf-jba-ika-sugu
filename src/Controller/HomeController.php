<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Form\FilterProduitByCategoryType;
use App\Repository\CategoryRepository;
use App\Service\Impl\TestServiceImpl;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(ProduitRepository $produitRepository,Request $request,SessionInterface $session,CategoryRepository $categoryRepository): Response
    {

        
        $form = $this->createForm(FilterProduitByCategoryType::class);
        $form->handleRequest($request);
        $listes=[];
        $listes=$produitRepository->findAll();
        if ($form->isSubmitted() && $form->isValid()) {

            // dd($form->get('libelle')->getData()->getLibelle());
            switch ($form->get('libelle')->getData()->getLibelle()) {
                case 'Epices':
                    // dd($form->getData()['libelle']->getId());
                    $session->set('image_name',"spices-1191945_640.jpg");
                    $cat=$categoryRepository->findOneBy(['id' =>$form->getData()['libelle']->getId()]);
                    $produits = $produitRepository->findBy(['category' => $cat]);
                    return $this->render('home/category-filtre/epices/index.html.twig', [
                        'produits' => $produits,
                        'categories' => $categoryRepository->findAll(),
                    ]);
                    break;
                    case 'Les Amuse-Gueules':
                        return $this->redirectToRoute("app_category_list_produit",['id' => $form->get('libelle')->getData()->getId()] );
                        break;
                        case 'Fruit':
                            $session->set('image_name',"tangerines-3105628_640.jpg");
                            $cat=$categoryRepository->findOneBy(['id' =>$form->getData()['libelle']->getId()]);
                            $produits = $produitRepository->findBy(['category' => $cat]);
                            return $this->render('home/category-filtre/fruits/index.html.twig', [
                                'produits' => $produits,
                                'categories' => $categoryRepository->findAll(),
                            ]);
                            break;
                            case 'Céréale':
                                $session->set('image_name',"WhatsApp Image 2024-05-25 at 16.40.15 (1).jpeg");
                                $cat=$categoryRepository->findOneBy(['id' =>$form->getData()['libelle']->getId()]);
                                $produits = $produitRepository->findBy(['category' => $cat]);
                                return $this->render('home/category-filtre/cereales/index.html.twig', [
                                    'produits' => $produits,
                                    'categories' => $categoryRepository->findAll(),
                                ]);

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
