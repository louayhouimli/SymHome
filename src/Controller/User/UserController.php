<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\LoginFormType;
use App\Form\RegisterFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class UserController extends AbstractController
{
    #[Route('/login', name: 'user_login')]
    public function login(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $hasher,
        TokenStorageInterface $tokenStorage
    ): Response
    {
        $user = new User();
        $form = $this->createForm(LoginFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $plainPassword = $form->get('password')->getData();
            $foundUser = $userRepository->findOneBy([
                'email' => $email
            ]);
            if (!$foundUser || !$hasher->isPasswordValid($foundUser, $plainPassword)) {
                return $this->render('auth/login.html.twig', [
                    'form' => $form->createView()
                ]);
            }
            if (!$foundUser->isActive()) {

                return $this->render('auth/login.html.twig', [
                    'form' => $form->createView(),
                    'error' => 'Votre compte est en attente de validation.'
                ]);
            }

            if ($foundUser->isBlocked()) {

                return $this->render('auth/login.html.twig', [
                    'form' => $form->createView(),
                    'error' => 'Votre compte a été bloqué.'
                ]);
            }
            $token = new UsernamePasswordToken(
                $foundUser,
                'main',
                $foundUser->getRoles()
            );

            $tokenStorage->setToken($token);
            $request->getSession()->set('_security_main', serialize($token));
            if (in_array('ROLE_ADMIN', $foundUser->getRoles())) {

                return $this->redirectToRoute('admin_meuble_list');

            } else {

                return $this->redirectToRoute('app_client');
            }

        }

        return $this->render('auth/login.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/register', name: 'user_register')]
    public function register(
    Request $request,
    EntityManagerInterface $em,
    UserPasswordHasherInterface $hasher,
    UserRepository $userRepository
  ): Response
  {
      $user = new User();

      $form = $this->createForm(RegisterFormType::class, $user);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {

          $existingUser = $userRepository->findOneBy([
              'email' => $user->getEmail()
          ]);

          if ($existingUser) {

              return $this->render('auth/register.html.twig', [
                  'form' => $form->createView(),
                  'error' => 'Cet email existe déjà.'
              ]);
          }

          $plainPassword = $form->get('password')->getData();

          $hashedPassword = $hasher->hashPassword($user, $plainPassword);

          $user->setPassword($hashedPassword);

          $user->setRoles(['ROLE_CLIENT']);

          $user->setIsActive(false);

          $user->setIsBlocked(false);

          $em->persist($user);

          $em->flush();

          return $this->redirectToRoute('user_login');
      }

      return $this->render('auth/register.html.twig', [
          'form' => $form->createView()
      ]);
  }
}