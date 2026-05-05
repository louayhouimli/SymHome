<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\AuthFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/login', name: 'user_login')]
    public function create(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(AuthFormType::class,$user);
        return $this->render('auth/login.html.twig',['form'=>$form]);
    }
}