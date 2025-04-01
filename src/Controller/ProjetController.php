<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjetController extends AbstractController
{
    #[Route('/projets', name: 'app_projets', methods:['GET'])]
    public function index(ProjetRepository $repository): Response
    {
        $projets = $repository->findAll();

        return $this->render('projet/index.html.twig', [
            
            'projets' => $projets,
        ]);
    }

    /** Affiche un projet en détail */
    #[Route('/projet/{id}', name: 'app_projet_detail')]
    public function detail(Projet $projet): Response
    {
        return $this->render('projet/detail.html.twig', [
            'projet' => $projet,
        ]);
    }

    /**
     * Crée un nouveau projet
     */
    #[Route('/projet/ajouter', name: 'app_projet_ajouter')]
    public function ajouter(Request $request, EntityManagerInterface $manager): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($projet);
            $manager->flush();

            return $this->redirectToRoute('app_projets');
        }

        return $this->render('projet/form.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Modifie un projet
     */
    #[Route('/projet/{id}/modifier', name: 'app_projet_modifier')]
    public function modifier(Request $request, Projet $projet, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('app_projet_detail', ['id' => $projet->getId()]);
        }

        return $this->render('projet/form.html.twig', [
            'form' => $form,
            'projet' => $projet
        ]);
    }

    /**
     * Supprime un projet
     */
    #[Route('/projet/{id}/supprimer', name: 'app_projet_supprimer')]
    public function supprimer(Projet $projet, EntityManagerInterface $manager): Response
    {
        $manager->remove($projet);
        $manager->flush();

        return $this->redirectToRoute('app_projets');
    }



}
