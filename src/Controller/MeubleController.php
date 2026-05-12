<?php

namespace App\Controller;

use App\Entity\Meuble;
use App\Form\MeubleType;
use App\Repository\MeubleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MeubleController extends AbstractController
{
    #[Route('/admin/meuble', name: 'admin_meuble_list')]
    public function index(MeubleRepository $repo): Response
    {
        $meubles = $repo->findAll();

        return $this->render('admin/meuble/index.html.twig', [
            'meubles' => $meubles
        ]);
    }

    #[Route('/admin/meuble/add', name: 'meuble_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $meuble = new Meuble();

        $form = $this->createForm(MeubleType::class, $meuble);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {

                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads',
                    $newFilename
                );

                $meuble->setImage($newFilename);
            }

            $em->persist($meuble);
            $em->flush();

            return $this->redirectToRoute('admin_meuble_list');
        }

        return $this->render('admin/meuble/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/meuble/edit/{id}', name: 'meuble_edit')]
    public function edit(
        Meuble $meuble,
        Request $request,
        EntityManagerInterface $em
    ): Response {

        $oldImage = $meuble->getImage();

        $form = $this->createForm(MeubleType::class, $meuble);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $imageFile = $form->get('image')->getData();

            if ($imageFile) {

                if ($oldImage && file_exists(
                    $this->getParameter('kernel.project_dir')
                    . '/public/uploads/'
                    . $oldImage
                )) {

                    unlink(
                        $this->getParameter('kernel.project_dir')
                        . '/public/uploads/'
                        . $oldImage
                    );
                }

                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                $imageFile->move(
                    $this->getParameter('kernel.project_dir').'/public/uploads',
                    $newFilename
                );

                $meuble->setImage($newFilename);
            }

            $em->flush();

            return $this->redirectToRoute('admin_meuble_list');
        }

        return $this->render('admin/meuble/edit.html.twig', [
            'form' => $form->createView(),
            'meuble' => $meuble
        ]);
    }
    #[Route('/admin/meuble/delete/{id}', name: 'meuble_delete')]
    public function delete(
        Meuble $meuble,
        EntityManagerInterface $em
    ): Response {

        $em->remove($meuble);

        $em->flush();

        return $this->redirectToRoute('admin_meuble_list');
    }
}