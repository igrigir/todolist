<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    #[Route('/tasks', name: 'task_list')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $query = $em->getRepository(Task::class)->createQueryBuilder('t');

        $status = $request->query->all('status'); // array
        $priceMin = $request->query->get('priceMin');
        $priceMax = $request->query->get('priceMax');
        $durationMin = $request->query->get('durationMin');
        $durationMax = $request->query->get('durationMax');

        if ($status && is_array($status)) {
            $query->andWhere('t.status IN (:status)')
                ->setParameter('status', $status);
        }

        if ($priceMin !== null) {
            $query->andWhere('t.price >= :priceMin')
                ->setParameter('priceMin', (float)$priceMin);
        }

        if ($priceMax !== null) {
            $query->andWhere('t.price <= :priceMax')
                ->setParameter('priceMax', (float)$priceMax);
        }

        $query->orderBy('t.createdAt', 'DESC');
        $results = $query->getQuery()->getResult();

        if ($durationMin !== null || $durationMax !== null) {
            $results = array_filter($results, function (Task $task) use ($durationMin, $durationMax) {
                $duration = 0;
                if ($task->getFinishedAt()) {
                    $interval = $task->getCreatedAt()->diff($task->getFinishedAt());
                    $duration = $interval->days * 24 + $interval->h + $interval->i / 60;
                }
                if ($durationMin !== null && $duration < (float)$durationMin) return false;
                if ($durationMax !== null && $duration > (float)$durationMax) return false;
                return true;
            });
        }

        return $this->render('task/index.html.twig', [
            'tasks' => $results,
        ]);
    }

    #[Route('/tasks/add', name: 'task_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $task = new Task();
            $task->setTitle($request->request->get('title'));
            $task->setDescription($request->request->get('description'));
            $task->setIsDone(false);
            $task->setCreatedAt(new \DateTime());
            $task->setPrice((float)$request->request->get('price'));

            $em->persist($task);
            $em->flush();
            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/add.html.twig');
    }

    #[Route('/tasks/{id}/edit', name: 'task_edit')]
    public function edit(int $id, Request $request, EntityManagerInterface $em): Response
    {
        $task = $em->getRepository(Task::class)->find($id);
        if (!$task) {
            throw $this->createNotFoundException('Zadatak nije pronađen.');
        }

        if ($request->isMethod('POST')) {
            $task->setTitle($request->request->get('title'));
            $task->setDescription($request->request->get('description'));
            $task->setIsDone($request->request->get('isDone') === 'on');
            $task->setPrice((float)$request->request->get('price'));
            $em->flush();

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', ['task' => $task]);
    }

    #[Route('/tasks/{id}/delete', name: 'task_delete')]
    public function delete(int $id, EntityManagerInterface $em): Response
    {
        $task = $em->getRepository(Task::class)->find($id);
        if ($task) {
            $em->remove($task);
            $em->flush();
        }
        return $this->redirectToRoute('task_list');
    }

    #[Route('/tasks/{id}/finish', name: 'task_finish')]
public function finish(int $id, EntityManagerInterface $em): Response
{
    $task = $em->getRepository(Task::class)->find($id);
    if (!$task) {
        throw $this->createNotFoundException("Zadatak nije pronađen.");
    }

    $task->setStatus(2);
    $task->setFinishedAt(new \DateTime());
    $em->flush();

    return $this->redirectToRoute('task_list');
}
}
