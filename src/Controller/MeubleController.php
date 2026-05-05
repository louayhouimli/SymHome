<?php

namespace App\Controller;

use App\Repository\MeubleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MeubleController extends AbstractController
{
    #[Route('/admin/meuble', name: 'admin_meuble_list')]
    public function index(MeubleRepository $repo): Response
    {
        $meubles = $repo->findAll();

        return $this->render('meuble/index.html.twig', [
            'meubles' => $meubles
        ]);
    }
}
