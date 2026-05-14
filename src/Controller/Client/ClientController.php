<?php

namespace App\Controller\Client;

use App\Entity\Meuble;
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
        MeubleRepository $meubleRepository
    ): Response
    {
        $search = $request->query->get('recherche');

        if ($search) {

            $meubles = $meubleRepository->createQueryBuilder('m')
                ->join('m.categorie', 'c')
                ->where('m.nom LIKE :search')
                ->orWhere('c.libelle LIKE :search')
                ->setParameter('search', '%'.$search.'%')
                ->getQuery()
                ->getResult();

        } else {

            $meubles = $meubleRepository->findAll();
        }

        return $this->render('client/index.html.twig', [
            'meubles' => $meubles,
        ]);
    }
    #[Route('/client/meuble/{id}', name: 'client_meuble_details')]
    public function details(Meuble $meuble): Response
    {
        return $this->render('client/details.html.twig', [
            'meuble' => $meuble
        ]);
    }
    #[Route('/panier', name: 'app_panier')]
    public function panier(): Response
    {
        return $this->render('client/panier.html.twig');
    }
}