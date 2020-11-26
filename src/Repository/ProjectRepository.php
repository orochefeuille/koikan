<?php

namespace App\Repository;

use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }

    public function getProjects(User $user)
    {
        return $this->createQueryBuilder('p')
            ->where('p.user = :user')
            ->setParameters([
              "user" => $user
            ])
            ->orderBy("p.deadline", "ASC")
            ->getQuery()
            ->getResult()
        ;
    }

    public function getProject(int $id, User $user): ?Project
    {
        return $this->createQueryBuilder('p')
            ->leftJoin("p.tasks", "t")
            ->addSelect("t")
            ->where('p.id = :id')
            ->andWhere('p.user = :user')
            ->setParameters([
              "id" => $id,
              "user" => $user
            ])
            ->orderBy("t.deadline", "ASC")
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
