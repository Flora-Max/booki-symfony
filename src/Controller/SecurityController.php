<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\Serializer;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * @Route("/register", name="register")
     */
    public function registerAdmin(Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passHasher, EntityManagerInterface $em, SerializerInterface $serializer)
    {
            //je récupère le corps de la requête
            $jsonRecu = $request->getContent();
            try{
                //je désérialise
                $user = $serializer->deserialize($jsonRecu, User::class, 'json');

                //je sécurise le password avec une fonction de hashage 
                $passwordRecu = $user->getPassword();
                $hashedPassword = $passHasher->hashPassword(
                    $user,
                    $passwordRecu
                );
                $user->setPassword($hashedPassword);
                //si pas d'erreurs, je persiste
                $em->persist($user);
                $em->flush();
                return $this->json($user, 201, [], ['groups' => 'user:read']);

            } catch (NotEncodableValueException $e) {
            return $this->json([
            'status' => 400,
            'message' => $e->getMessage()
            ], 400);
        
    }
}
/**
 * @Route("/user", name="user")
 */
public function user(ManagerRegistry $managerRegistry)
{
    $entityManager = $managerRegistry->getManager();
    $userRepository = $entityManager->getRepository(User::class);
    $user = $userRepository->findAll();

    $response = $this->json($user, 200, [], ['groups' => 'user:read']);
        return $response; 
    }
}