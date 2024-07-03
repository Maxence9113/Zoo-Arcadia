<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\PictureAnimal;
use App\Form\PictureAnimalType;
use App\Repository\PictureAnimalRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/picture_animaux')]
class PictureAnimalController extends AbstractController
{
    #[Route('/', name: 'app_picture_animal_index', methods: ['GET'])]
    public function index(PictureAnimalRepository $pictureAnimalRepository): Response
    {
        return $this->render('picture_animal/index.html.twig', [
            'picture_animals' => $pictureAnimalRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_picture_animal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader): Response
    {
        $pictureAnimal = new PictureAnimal();
        $form = $this->createForm(PictureAnimalType::class, $pictureAnimal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureFile = $form->get('picture_animal')->getData();

            if ($pictureFile) {
                $brochureFileName = $fileUploader->upload($pictureFile);
                $pictureAnimal->setPicture($brochureFileName);
            }

            $entityManager->persist($pictureAnimal);
            $entityManager->flush();

            return $this->redirectToRoute('app_picture_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('picture_animal/new.html.twig', [
            'picture_animal' => $pictureAnimal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_picture_animal_show', methods: ['GET'])]
    public function show(PictureAnimal $pictureAnimal): Response
    {
        return $this->render('picture_animal/show.html.twig', [
            'picture_animal' => $pictureAnimal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_picture_animal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PictureAnimal $pictureAnimal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PictureAnimalType::class, $pictureAnimal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_picture_animal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('picture_animal/edit.html.twig', [
            'picture_animal' => $pictureAnimal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_picture_animal_delete', methods: ['POST'])]
    public function delete(Request $request, PictureAnimal $pictureAnimal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pictureAnimal->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($pictureAnimal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_picture_animal_index', [], Response::HTTP_SEE_OTHER);
    }
}
