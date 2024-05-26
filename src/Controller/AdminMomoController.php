<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Produit;
use App\Form\CategoryType;
use App\Form\ProduitType;
use App\Repository\CategoryRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route('/admin')]
class AdminMomoController extends AbstractController
{
    #[Route('/dashboard', name: 'app_admin_momo')]
    public function index(): Response
    {
        return $this->render('admin_momo/index.html.twig', [
            'controller_name' => 'AdminMomoController',
        ]);
    }
    #[Route('/categories/all', name: 'app_admin_category_list', methods: ['GET', 'POST'])]
    public function category_liste(Request $request,CategoryRepository $categoryRepository, EntityManagerInterface $entityManager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            
            // dd($form->getData());
            return $this->redirectToRoute('app_admin_category_list', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin_momo/category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'category' => $category,
            'form' => $form,
        ]);
    }
   
    #[Route('/produits/all', name: 'app_admin_produits_list', methods: ['GET'])]
    public function produitListe(ProduitRepository $produitRepository): Response
    {
        return $this->render('admin_momo/produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }
    #[Route('/produit/new', name: 'app_admin_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produit->setQuantite(100);
            $produit->setImage($form->get('thumbnailFile')->getData()->getClientOriginalName());
            if ( $produit->getPremiereImage() !== null ||  $produit->getSecondeImage() !== null ||  $produit->getDerniereImage() !== null) {
                # code...
                $produit->setPremiereImage($form->get('thumbnailPremiereImage')->getData()->getClientOriginalName());
                $produit->setSecondeImage($form->get('thumbnailSecondeImage')->getData()->getClientOriginalName());
                $produit->setDerniereImage($form->get('thumbnailDerniereImage')->getData()->getClientOriginalName());
            }
            // VICH
            $produit->setThumbnailFile($form->get('thumbnailFile')->getData());
            $produit->setThumbnailPremiereImage($form->get('thumbnailPremiereImage')->getData());
            $produit->setThumbnailSecondeImage($form->get('thumbnailSecondeImage')->getData());
            $produit->setThumbnailDerniereImage($form->get('thumbnailDerniereImage')->getData());
           
            // dd($produit);
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_produits_list', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admin_momo/produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }
}
