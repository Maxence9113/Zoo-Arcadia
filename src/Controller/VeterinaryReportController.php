<?php

namespace App\Controller;

use App\Entity\VeterinaryReport;
use App\Form\VeterinaryReportType;
use App\Repository\VeterinaryReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/veterinaryreport')]
class VeterinaryReportController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'app_veterinary_report_index', methods: ['GET'])]
    public function index(VeterinaryReportRepository $veterinaryReportRepository): Response
    {
        return $this->render('veterinary_report/index.html.twig', [
            'veterinary_reports' => $veterinaryReportRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_veterinary_report_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $user = $this->security->getUser();
        $veterinaryReport = new VeterinaryReport();
        $form = $this->createForm(VeterinaryReportType::class, $veterinaryReport, ['user' => $user]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $veterinaryReport->setEmployee($security->getUser());
            $entityManager->persist($veterinaryReport);
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinary_report_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veterinary_report/new.html.twig', [
            'veterinary_report' => $veterinaryReport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_veterinary_report_show', methods: ['GET'])]
    public function show(VeterinaryReport $veterinaryReport): Response
    {
        return $this->render('veterinary_report/show.html.twig', [
            'veterinary_report' => $veterinaryReport,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_veterinary_report_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VeterinaryReport $veterinaryReport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VeterinaryReportType::class, $veterinaryReport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_veterinary_report_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('veterinary_report/edit.html.twig', [
            'veterinary_report' => $veterinaryReport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_veterinary_report_delete', methods: ['POST'])]
    public function delete(Request $request, VeterinaryReport $veterinaryReport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $veterinaryReport->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($veterinaryReport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_veterinary_report_index', [], Response::HTTP_SEE_OTHER);
    }
}
