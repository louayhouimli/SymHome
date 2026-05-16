<?php

namespace App\Controller\Client;

use App\Entity\Meuble;
use App\Repository\CategorieRepository;
use App\Repository\MeubleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function listAll(
        Request $request,
        MeubleRepository $meubleRepository,
        CategorieRepository $categorieRepository
    ): Response
    {
        $search = $request->query->get('recherche');
        $categorieId = $request->query->get('categorie');

        $qb = $meubleRepository->createQueryBuilder('m')
            ->join('m.categorie', 'c');

        if ($search) {
            $qb->andWhere('m.nom LIKE :search OR c.libelle LIKE :search')
            ->setParameter('search', '%'.$search.'%');
        }

        if ($categorieId) {
            $qb->andWhere('c.id = :cat')
            ->setParameter('cat', $categorieId);
        }

        $meubles = $qb->getQuery()->getResult();

        return $this->render('client/index.html.twig', [
            'meubles' => $meubles,
            'categories' => $categorieRepository->findAll()
        ]);
    }
    #[Route('/client/meuble/{id}', name: 'client_meuble_details')]
    public function details(Meuble $meuble,CategorieRepository $categorieRepository): Response
    {
        return $this->render('client/details.html.twig', [
            'meuble' => $meuble,
            'categories' => $categorieRepository->findAll()
        ]);
    }
    #[Route('/panier', name: 'app_panier')]
    public function panier(CategorieRepository $categorieRepository): Response
    {
        return $this->render('client/panier.html.twig',['categories' => $categorieRepository->findAll()]);
    }
}