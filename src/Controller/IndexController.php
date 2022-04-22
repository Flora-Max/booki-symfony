<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Activity;
use App\Entity\Category;
use App\Entity\Hebergement;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index", methods= {"GET"})
     */
    public function index(ManagerRegistry $managerRegistry): JsonResponse
    {
        //cette méthode retourne notre page d'acceuil / partie hebergement
        //return $this->render('index/index.html.twig');
        $entityManager = $managerRegistry->getManager();
        $hebergementRepository = $entityManager->getRepository(Hebergement::class);
        $hebergements = $hebergementRepository->findAll();
        //je retourne une response au format json 
        $response = $this->json($hebergements, 200, [], ['groups' => 'hebergement:read', 'city:read']);
        return $response; 
    }

    /**
     * @Route("/activity", name="app_indexActivity", methods= {"GET"})
     */
    public function indexActivity(ManagerRegistry $managerRegistry): Response
    {
        //cette méthode retourne la partie activités sur la page d'acceuil
        $entityManager = $managerRegistry->getManager();
        $activityRepository = $entityManager->getRepository(Activity::class);
        $activities = $activityRepository->findAll();
        //je retourne une response au format json
        $response = $this->json($activities, 200, [], ['groups' => 'activity:read']);
        return $response; 
    }

    /**
     * @Route("/symfony", name="app_indexSymfony", methods= {"GET"})
     */
    /*public function indexSymfony(ManagerRegistry $managerRegistry): Response
    {
        //cette méthode retourne notre page d'acceuil 
        $entityManager = $managerRegistry->getManager();
        $hebergementRepository = $entityManager->getRepository(Hebergement::class);
        $hebergements = $hebergementRepository->findAll();
        $activityRepository = $entityManager->getRepository(Activity::class);
        $activities = $activityRepository->findAll();
        return $this->render('index/index.html.twig', [
            'activities' => $activities,
            'hebergements' => $hebergements
        ]);
        
    }*/

    /**
     * @Route("/display/{hebergementId}", name="hebergement_display")
     */
    public function display(ManagerRegistry $managerRegistry, int $hebergementId):Response
    {

        //cette méthode retourne une fiche d'etablissement en fonction de son id passé ds l'url
        //Pour communiquer avec notre BDD et la table Hebergement, nous avons besoin de l'Entity Manager et du reposotiry
        $entityManager = $managerRegistry->getManager();
        $hebergementRepository = $entityManager->getRepository(Hebergement::class);
        //on utilise la méthode find() de Repository afin de pouvoir retrouver l'hebergement qui nous interesse
        $hebergement = $hebergementRepository->find($hebergementId);
        //si l'hébergement n'est pas trouvé, on retourne à la page d'accueil
        if(!$hebergement){
            return $this->redirectToRoute("app_indexSymfony");
        }
        //une fois que nous avons trouvé l'hébergement on renvoit une response au format json
        $response = $this->json($hebergement, 200, [], ['groups' => 'hebergement:read']);
        return $response; 
        }
        
    /**
     * @Route("/hebergementBy/{postCode}", name="hebergement_postcode")
     */
    public function hebergementByPostcode(ManagerRegistry $managerRegistry, int $postCode = 0):Response 
    {
        //Cette méthode permet de renvoyer les hebergements appartenant à un même code postale via les renseignements placés dans l'url
        //on récupère l'entity Manager et le Repository pertinent 
        $entityManager = $managerRegistry->getManager();
        $hebergementRepository = $entityManager->getRepository(Hebergement::class);
        $activityRepository = $entityManager->getRepository(Activity::class);
        $activities = $activityRepository->findAll();
   
        //On récupère les hebergements par postCode
        $hebergements = $hebergementRepository->findBy(
            ["postcode" => $postCode]
        );

        foreach($hebergements as $hebergement){
            $postCode =  $hebergement->getPostCode();
        };
       
        //Si la recherche n'aboutie pas on retourne à la page d'acceuil
        if(!$hebergements){
            return $this->redirectToRoute('app_indexSymfony');
        }
        //nous envoyons la liste des Hebergements liés au code postal à notre page d'index Twig
        return $this->render('index/hebergement_display.html.twig', [
            'hebergements' => $hebergements,
            'postCode' => $postCode,
            'activities' => $activities,
            'hebergement' => $hebergement
        ]);

    }


    /**
    * @Route("/activityBy/{postCode}", name="activity_postcode")
    */
    public function activityByPostcode(ManagerRegistry $managerRegistry, int $postCode = 0):Response 
    {
        //Cette méthode permet de renvoyer les activités appartenant à un même code postale via les renseignements placés dans l'url
        //on récupère l'entity Manager et le Repository pertinent 
        $entityManager = $managerRegistry->getManager();
        $activityRepository = $entityManager->getRepository(Activity::class);

        //On récupère les hebergements par postCode
        $activities = $activityRepository->findBy(
            ["postcode" => $postCode]
        );

        foreach($activities as $activity){
            $postCode =  $activity->getPostCode();
        };
       
        //Si la recherche n'aboutie pas on retourne à la page d'acceuil
        if(!$activity){
            return $this->redirectToRoute('app_indexSymfony');
        }
        //nous envoyons la liste des Hebergements liés au code postal à notre page d'index Twig
        return $this->render('index/hebergement_display.html.twig', [
            'postCode' => $postCode,
            'activity' => $activity,
            'activities' => $activities
        ]);

    }
    

    /**
     * @Route("/reservationForm/{hebergementId}", name="reservation_form")
     */
    public function reservationForm(EntityManagerInterface $em, Request $request, SerializerInterface $serializer, ValidatorInterface $validator, int $hebergementId)
    {
    //cette méthode nous permet de créer une réservation sur un hébergement
    /*header('Access-Control-Allow-Origin: *');*/
    //je récupère le corps de la requête
    $jsonRecu = $request->getContent();

    try {
    //je désérialise, j'emet la réservation en fonction de l'hébergement
    /**
    * @var Reservation
    */
    $reservation = $serializer->deserialize($jsonRecu, Reservation::class, 'json');
    $reservation->setHebergement($em->getReference(Hebergement::class, $hebergementId));

    //verif du validator
    $errors = $validator->validate($reservation);

    //si compte d'erreurs sup à 0 : 
    if(count($errors) >0){
        return $this->json($errors, 400);
    }

    //si pas d'erreurs, je persiste
    $em->persist($reservation);
    $em->flush();

    //je renvoie une response au format json
    return $this->json($reservation, 201, [], ['groups' => 'reservation:read']);
        } catch (NotEncodableValueException $e) {
        return $this->json([
            'status' => 400,
            'message' => $e->getMessage()
        ], 400);
    }
    }
}