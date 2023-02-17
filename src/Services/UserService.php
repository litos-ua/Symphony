<?php

namespace App\Services;

use App\Entity\User;
use App\Exceptions\ObjectCantSaveException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

class UserService
{
    protected ObjectManager $em;
    protected ObjectRepository $userRepository;

    public function __construct(protected ManagerRegistry $doctrine)
    {
        $this->em = $this->doctrine->getManager();
        $this->userRepository = $this->doctrine->getRepository(User::class);
    }

    /**
     * @param string $login
     * @param string $password
     * @return bool
     * @throws ObjectCantSaveException
     */
    public function  createUser (string $login, string $password):bool
    {
        try {
            $user = new User($login,$password);
            $this->em->persist($user);
            $this->em->flush();
        } catch (\Exception $e) {
            throw new ObjectCantSaveException('User not saved', previous: $e);
        }
        return true;
    }
}