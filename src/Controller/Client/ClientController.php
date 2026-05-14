<?php

namespace App\Controller\Client;

use App\Repository\MeubleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ClientController extends AbstractController
{
    #[Route('/client', name: 'app_client')]
    public function listAll(MeubleRepository $MeubleRepository,): Response
    {
        $meubles = $MeubleRepository->findAll();
        return $this->render('client/index.html.twig', [
            'meubles' => $meubles,
        ]);
    }
}
