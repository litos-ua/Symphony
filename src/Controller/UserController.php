<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Persistence\ManagerRegistry;
use ReflectionClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class UserController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{

    public function __construct(
        protected EntityManagerInterface $entityManager,
        //protected EntityRepository $entityRepository
    )
    {

    }

    #[Route(
        '/user/id/{id}',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
   public function findUserById (mixed $id)
     {

         $user = $this->entityManager->getRepository(User::class)->find($id);

         $refObj = new ReflectionClass($user);
         $pubProp = [];

         foreach ($refObj->getProperties() as $property) {
             $property->setAccessible(true);
             $pubProp[$property->getName()] = $property->getValue($user);
         }

         return  new JsonResponse($pubProp);
     }

    #[Route(
        '/user/log/{login}',
        requirements: ['login' => '[0-9,a-z,A-Z,_,-]+'],
        methods: ['GET']
    )]
    public function findUserByLogin(mixed $login) : Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['login'=>$login]);

        $refObj = new ReflectionClass($user);
        $pubProp = [];

        foreach ($refObj->getProperties() as $property) {
            $property->setAccessible(true);
            $pubProp[$property->getName()] = $property->getValue($user);
        }

        return  new JsonResponse($pubProp);
    }

    #[Route('/users')]
    public function getUsers(ManagerRegistry $doctrine): Response
    {
        $users = $doctrine->getRepository(User::class)->findAll();
        $result = '';
        foreach ($users as $user) {
            $result .= $user->getId()
                . ' - ' . $user->getLogin()
//            . ' - ' . $user->getPhones()->current()->getPhone()
                . '<br>'
            ;
        }
        return new Response(
            $result
        );
    }

    #[Route(
            '/user/generate',
            methods: ['GET']
    )]

    public function userGenerate(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $login = 'IrenaKolodziejska';
        $pass  = md5('HH7767kjh');
        $user = new User($login,$pass);
        $entityManager->persist($user);
        $entityManager->flush();

        return new Response('Ok');
    }

}