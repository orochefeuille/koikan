<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/task")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/", name="task_index", methods={"GET"})
     */
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->getTasks($this->getUser()),
        ]);
    }

    /**
     * @Route("/{id}/new", name="task_new", methods={"GET","POST"})
     */
    public function new(Request $request, Project $project, ValidatorInterface $validator): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        $errors = $validator->validate($task);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($this->getUser());
            $task->setProject($project);
            $task->setStatus('todo');
            $task->setCreatedAt(new DateTimeImmutable('now'));

            if(count($errors) === 0) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($task);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'Tâche créée !'
                );
                return $this->redirectToRoute('task_index');
            }
            else{
                $this->addFlash(
                    'danger',
                    'Cette tâche n\'a pu être créée !'
                );
            }
        }

        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="task_show", methods={"GET"})
     */
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="task_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Task $task, ValidatorInterface $validator): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        $errors = $validator->validate($task);

        if ($form->isSubmitted() && $form->isValid()) {
            if(count($errors) === 0) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash(
                    'success',
                    'Tâche mise à jour !'
                );
                return $this->redirectToRoute('task_index');
            }
            else{
                $this->addFlash(
                    'danger',
                    'Cette tâche n\'a pu être mise à jour !'
                );
            }
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="task_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Task $task, ValidatorInterface $validator): Response
    {
        $errors = $validator->validate($task);

        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            if(count($errors) === 0) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($task);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'Tâche supprimée !'
                );
            }
            else{
                $this->addFlash(
                    'danger',
                    'Cette tâche n\'a pu être supprimée !'
                );
            }
        }
        return $this->redirectToRoute('task_index');
    }
}
