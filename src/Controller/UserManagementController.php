<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/users')]
final class UserManagementController extends AbstractController
{
    #[Route('', name: 'admin_user_list')]
    public function index(UserRepository $repo): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $repo->findAll()
        ]);
    }

    #[Route('/toggle/{id}', name: 'admin_user_toggle')]
    public function toggle(
        User $user,
        EntityManagerInterface $em
    ): Response {

        $user->setIsBlocked(!$user->isBlocked());

        $em->flush();

        return $this->redirectToRoute('admin_user_list');
    }
}