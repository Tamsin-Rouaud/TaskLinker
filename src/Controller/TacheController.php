<?php

namespace App\Controller;


use App\Entity\Projet;
use App\Entity\Tache;
use App\Form\TacheType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TacheController extends AbstractController
{

    /** Affiche les tâches d’un projet */
    #[Route('/projet/{id}/taches', name: 'app_taches_projet', methods:['GET'])]
    public function index(Projet $projet): Response
    {
       
        return $this->render('tache/index.html.twig', [
            'projet' => '$projet',
            'taches' => $projet->getTaches(),
        ]);
    }

    /** Ajoute une nouvelle tâche à un projet */
    #[Route('/projet/{id}/tache/ajouter', name: 'app_tache_ajouter')]
    public function ajouter(Request $request, Projet $projet, EntityManagerInterface $manager): Response
    {
        $tache = new Tache();
        // lie la tâche au projet
        $tache->setProjet($projet); 

        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($tache);
            $manager->flush();

            return $this->redirectToRoute('app_taches_projet', ['id' => $projet->getId()]);
        }

        return $this->render('tache/form.html.twig', [
            'form' => $form,
            'projet' => $projet
        ]);
    }

    /** Modifie une tâche existante */
    #[Route('/tache/{id}/modifier', name: 'app_tache_modifier')]
    public function modifier(Request $request, Tache $tache, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(TacheType::class, $tache);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();
            return $this->redirectToRoute('app_taches_projet', ['id' => $tache->getProjet()->getId()]);
        }

        return $this->render('tache/form.html.twig', [
            'form' => $form,
            'projet' => $tache->getProjet()
        ]);
    }

    /** Supprime une tâche */
    #[Route('/tache/{id}/supprimer', name: 'app_tache_supprimer')]
    public function supprimer(Tache $tache, EntityManagerInterface $manager): Response
    {
        $projetId = $tache->getProjet()->getId();

        $manager->remove($tache);
        $manager->flush();

        return $this->redirectToRoute('app_taches_projet', ['id' => $projetId]);
    }



}
