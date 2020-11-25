<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Project;
use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 2; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword('passX12*');
            $user->setLastname($faker->lastName);
            $user->setFirstname($faker->firstName($gender = 'male'|'female'));
            $user->setRoles($user->getRoles());
            $manager->persist($user);
            for ($j = 0; $j < 3; $j++) {
                $project = new Project();
                $project->setLabel($faker->sentence($nbWords = 3, $variableNbWords = true));
                $project->setDescription($faker->text($maxNbChars = 150));
                $project->setStatus('todo');
                $project->setDeadline($faker->dateTimeInInterval($startDate = '+10 days', $interval = '+ 90 days', $timezone = 'Europe/Paris'));
                $project->setCreatedAt($project->getCreatedAt());
                $project->setUser($user);
                $manager->persist($project);
                for ($k = 0; $k < 5; $k++) {
                    $task = new Task();
                    $task->setCreatedAt($task->getCreatedAt());
                    $task->setDeadline($faker->dateTimeInInterval($startDate = '+80 days', $interval = '+ 90 days', $timezone = 'Europe/Paris'));
                    $task->setLabel($faker->sentence($nbWords = 3, $variableNbWords = true));
                    $task->setDescription($faker->text($maxNbChars = 350));
                    $task->setStatus('todo');
                    $task->setProject($project);
                    $task->setUser($user);
                    $manager->persist($task);
                }
            }
        }
        $manager->flush();
    }
}
