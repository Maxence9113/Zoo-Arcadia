<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\PassewordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(#[CurrentUser] ?User $user, Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(PassewordUserType::class, $user, [
            'passwordHasher' => $passwordHasher
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Mot de passe mis a jour !'
            );
        }

        return $this->render('account/index.html.twig', [
            'user' => $user,
            'modifyPwd' => $form->createView(),
        ]);
    }

}
