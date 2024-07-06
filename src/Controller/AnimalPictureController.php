<?php

namespace App\Controller;

use App\Entity\AnimalPicture;
use App\Form\AnimalPictureType;
use App\Repository\AnimalPictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/animal_picture')]
class AnimalPictureController extends AbstractController
{
    #[Route('/', name: 'app_animal_picture_index', methods: ['GET'])]
    public function index(AnimalPictureRepository $animalPictureRepository): Response
    {
        return $this->render('animal_picture/index.html.twig', [
            'animal_pictures' => $animalPictureRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_animal_picture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animalPicture = new AnimalPicture();
        $form = $this->createForm(AnimalPictureType::class, $animalPicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($animalPicture);
            $entityManager->flush();

            return $this->redirectToRoute('app_animal_picture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animal_picture/new.html.twig', [
            'animal_picture' => $animalPicture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_animal_picture_show', methods: ['GET'])]
    public function show(AnimalPicture $animalPicture): Response
    {
        return $this->render('animal_picture/show.html.twig', [
            'animal_picture' => $animalPicture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_animal_picture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AnimalPicture $animalPicture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnimalPictureType::class, $animalPicture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_animal_picture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animal_picture/edit.html.twig', [
            'animal_picture' => $animalPicture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_animal_picture_delete', methods: ['POST'])]
    public function delete(Request $request, AnimalPicture $animalPicture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animalPicture->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($animalPicture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_animal_picture_index', [], Response::HTTP_SEE_OTHER);
    }
}
