<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CategorieController extends AbstractController
{
    #[Route('/admin/categorie', name: 'admin_categorie_list')]
    public function index(CategorieRepository $repo): Response
    {
        return $this->render('admin/categorie/index.html.twig', [
            'categories' => $repo->findAll()
        ]);
    }

    #[Route('/admin/categorie/add', name: 'categorie_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $categorie = new Categorie();

        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($categorie);

            $em->flush();

            return $this->redirectToRoute('admin_categorie_list');
        }

        return $this->render('admin/categorie/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/categorie/edit/{id}', name: 'categorie_edit')]
    public function edit(
        Categorie $categorie,
        Request $request,
        EntityManagerInterface $em
    ): Response {

        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('admin_categorie_list');
        }

        return $this->render('admin/categorie/edit.html.twig', [
            'form' => $form->createView(),
            'categorie' => $categorie
        ]);
    }

    #[Route('/admin/categorie/delete/{id}', name: 'categorie_delete')]
    public function delete(
        Categorie $categorie,
        EntityManagerInterface $em
    ): Response {

        $em->remove($categorie);

        $em->flush();

        return $this->redirectToRoute('admin_categorie_list');
    }
}