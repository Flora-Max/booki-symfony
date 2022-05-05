<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{
    /**
     * Route utilisé par Lexik JWT pour authentifier l'utilisateur.
     * Visiblement la réponse de la méthode n'est jamais renvoyée.
     * Le plugin renvoie lui même le token JWT encodée en base64.
     * 
     * @Route("/login", name="app_login", methods="post")
     */
    public function login(Request $request): Response
    {
        return $this->json([ 'login' => true ]);
    }

    /**
     * Récupère les informations de l'utilisateur authentifié.
     * Lexik JWT renvoie l'utilisateur authentifié grace au token reçu au moment de la requête.
     * 
     * Cette méthode ne sera pas appelée sinon on a pas un token valid.
     * 
     * @Route("/auth/me", name="app_auth_me", methods="get")
     */
    public function me (): Response {
        /**
         * Notre entité utilisateur.
         * @var User
         */
        $user = $this->getUser();
        
        return $this->json([
            'username' => $user->getUserIdentifier(),
            'isAdmin' => $user->getIsAdmin(),
        ]);
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
        $hashedPassword = $passHasher->hashPassword($user,$passwordRecu);
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
}