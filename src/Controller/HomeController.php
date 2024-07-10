<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CommentRepository $commentRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Votre commentaire sera publié après validation. Merci !'
            );


            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        $comments = $commentRepository->findBy([], ['createdAt' => 'DESC']);;
        return $this->render('home/index.html.twig', [
            'comments' => $comments,
            'comment_form' => $form,
        ]);
    }
}
