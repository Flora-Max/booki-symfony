<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
    public function registerAdmin(Request $request, ManagerRegistry $managerRegistry, UserPasswordHasherInterface $passHasher):Response
    {
        //cette méthode nous permet de créer une nouvelle entity User via l'usage d'un formulaire interne à notre méthode, et avec les privilèges désirés
        $entityManager = $managerRegistry->getManager();
        //nous créons notre formulaire
        $userForm = $this->createFormBuilder()
            ->add('username', TextType::class,[
                'label' => "Nom de l'utilisateur",
                'attr' => [
                    'class' => 'form-control'
                ]  
            ])
            ->add('password', RepeatedType::class, [ //2 types pour la répétition/confirmation du mdp
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ]
            ])
            ->add('role', ChoiceType::class, [
                'label' => 'Privilèges',
                'choices' => [
                    'role: Client' => 'ROLE USER',
                    'Role: Admin' => 'ROLE ADMIN'
                ],
                'expanded' => true,
                'multiple' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
            //nous traitons les données reçues au sein de notre formulaire
            $userForm->handleRequest($request);
            if($request->isMethod('post') && $userForm->isValid()){
                //on récupère les informations de notre formulaire
                $data= $userForm->getData();
                //on créé notre entité User selon les informations enregistréss
                $user = new User;
                $user->setRoles(['ROLE_USER', $data['role']]);
                $user->setUsername($data['username']);
                $user->setPassword($passHasher->hashPassword($user, $data['password']));
                $entityManager->persist($user);
                $entityManager->flush();
                //après la création de l'utilisateur, nous retournons à l'index
                return $this->redirectToRoute('app_indexSymfony');
            }
            //si notre formulaire n'est pas validé, nous le présentons à l'utilisateur
            return $this->render('index/dataform.html.twig', [
                'formName' => "Inscription Utilisateur",
                'dataForm' => $userForm->createView(),
            ]);
            
    }
}
