<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\LoginFormType;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/login', name: 'user_login')]
    public function login(Request $request): Response
    {
        $user = $userRepository->findOneBy([
            'email' => $email
        ]);
        $form = $this->createForm(LoginFormType::class,$user);
        return $this->render('auth/login.html.twig',['form'=>$form]);
    }
    #[Route('/register', name: 'user_register')]
    public function register(Request $request,EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterFormType::class,$user);
        $form->handleRequest($request);         
        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('password')->getData();
            $hashedPassword = $hasher->hashPassword($user, $plainPassword);
            $user->setPassword($hashedPassword);
            $em->persist($user);
            $em->flush();
        }

        return $this->render('auth/register.html.twig',['form'=>$form]);
    }
}