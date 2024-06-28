<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'app_account')]
    public function index(#[CurrentUser] ?User $user): Response
    {
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('account/index.html.twig', [
            'user' => $user,]);
    }
}
