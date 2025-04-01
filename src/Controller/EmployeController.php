<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeType;
use App\Repository\EmployeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EmployeController extends AbstractController
{


    /** Liste tous les employés */
    #[Route('/employes', name: 'app_employes')]
    public function index(EmployeRepository $repository): Response
    {
        return $this->render('employe/index.html.twig', [
            'employes' => $repository->findAll(),
        ]);
    }

    /** Affiche les détails d’un employé */
    #[Route('/employe/{id}', name: 'app_employe_detail')]
    public function detail(Employe $employe): Response
    {
        return $this->render('employe/detail.html.twig', [
            'employe' => $employe,
        ]);
    }

    /**
     * Modifier un employé
     */
    #[Route('/employe/{id}/modifier', name: 'app_employe_modifier')]
    public function modifier(Request $request, Employe $employe, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(EmployeType::class, $employe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('employe_detail', ['id' => $employe->getId()]);
        }

        return $this->render('employe/form.html.twig', [
            'form' => $form,
            'employe' => $employe
        ]);
    }

    /** Supprimer un employé */
    #[Route('/employe/{id}/supprimer', name: 'app_employe_supprimer')]
    public function supprimer(Employe $employe, EntityManagerInterface $manager): Response
    {
        $manager->remove($employe);
        $manager->flush();

        return $this->redirectToRoute('app_employes');
    }
}
