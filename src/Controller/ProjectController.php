<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @IsGranted("ROLE_USER")
 * @Route("/")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/")
     * @Route("/project", name="project_index", methods={"GET"})
     */
    public function index(ProjectRepository $projectRepository): Response
    {
         return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->getProjects($this->getUser()),
        ]);
    }

    /**
     * @Route("/new", name="project_new", methods={"GET","POST"})
     */
    public function new(Request $request, ValidatorInterface $validator): Response
    {
        $project = new Project();
        setlocale(LC_TIME, "fr_FR");
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        $user = $this->getUser();
        $errors = $validator->validate($project);

        if ($form->isSubmitted() && $form->isValid()) {
            $project->setUser($user);
            $project->setStatus('todo');
            $project->setCreatedAt(new DateTimeImmutable('now'));

            if(count($errors) === 0) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($project);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Projet créé !'
                );
                return $this->redirectToRoute('project_index');
            }
            else {
                $this->addFlash(
                'danger',
                'Ce projet n\'a pu être créé !'
                );
            }
        }

        return $this->render('project/new.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="project_show", methods={"GET"})
     */
    public function show(int $id, ProjectRepository $projectRepository): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $projectRepository->getProject($id, $this->getUser()),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="project_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Project $project, ValidatorInterface $validator): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);
        $errors = $validator->validate($project);

        if ($form->isSubmitted() && $form->isValid()) {
            if(count($errors) === 0) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash(
                    'success',
                    'Projet mis à jour !'
                );
                return $this->redirectToRoute('project_index');
            }
            else{
                $this->addFlash(
                    'danger',
                    'Ce projet n\'a pu être mis à jour !'
                );
            }
        }
        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="project_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Project $project, ValidatorInterface $validator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $errors = $validator->validate($project);
            if(count($errors) === 0) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($project);
                $entityManager->flush();

                $this->addFlash(
                    'success',
                    'Le projet a été supprimé !'
                );
            }
            else{
                $this->addFlash(
                    'danger',
                    'Ce projet n\'a pu être supprimé !'
                );
            }
        }
        return $this->redirectToRoute('project_index');
    }

    /**
     * @Route("/{id}/archive", name="project_archive", methods={"UPDATE"})
     */
    public function archive(Request $request, Project $project, ValidatorInterface $validator): Response
    {
        if ($this->isCsrfTokenValid('stored'.$project->getId(), $request->request->get('_token'))) {
            $project->setStatus('stored');
            $errors = $validator->validate($project);
            if(count($errors) === 0) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($project);
                $entityManager->flush();
                
                $this->addFlash(
                    'success',
                    'Le projet a été archivé !'
                );
            }
            else{
                $this->addFlash(
                    'danger',
                    'Ce projet n\'a pu être archivé !'
                );
            }
        }

        return $this->redirectToRoute('project_index');
    }

    /**
     * @Route("/archive", name="project_archived", methods={"GET"})
     */
    public function indexArchive(ProjectRepository $projectRepository): Response
    {
        return $this->render('project/showArchive.html.twig', [
            'projects' => $projectRepository->getProjects($this->getUser()),
        ]);
    }

    /**
     * @Route("/{id}/change_status", name="project_change_status")
     */
    public function changeStatus(Project $project, ProjectRepository $projectRepository): Response
    {
        $status = $projectRepository->getProject($project->getId(), $this->getUser())->getStatus();
        if($status == "todo") {
            $status = "in progress";
        }
        elseif($status == "in progress"){
            $status = "done";
        }
        else {
            $status = "todo";
        }

        $project->setStatus($status);
        $this->getDoctrine()->getManager()->flush();
        return $this->json(['code' => 200, 'message' => 'Statut changé', 'statusText' => $status], 200);
    }
}
