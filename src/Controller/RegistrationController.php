<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;

class RegistrationController extends AbstractFOSRestController
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    private $passwordEncoder;
    private $entityManager;

    public function __construct(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/register', name: 'register')]
    public function index(Request $request)
    {
        
        $email = $request->get('email');
        $password = $request->get('password');

        $user = $this->UserRepository->findOneBy([
            'email' => $email,
        ]);

        if(!is_null($user)){
            return $this->view([
                'message' => 'User already exists'
            ], Response::HTTP_CONFLICT);
        }

        $user = new User();
        $user->setEmail($email);
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $password)
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->view($user, Response::HTTP_CREATED);

    }
}
