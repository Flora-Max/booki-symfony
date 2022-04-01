<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Activity;
use App\Entity\Category;
use App\Entity\Hebergement;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class IndexController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        //cette méthode retourne notre page d'acceuil
        return $this->render('index/index.html.twig');
    }

    /**
     * @Route("/display/{hebergementId}", name="hebergement_display")
     */
    public function display(ManagerRegistry $managerRegistry, Request $request, int $hebergementId):Response
    {
        //cette méthode retourne une fiche d'etablissement en fonction de son id passé ds l'url
        //Pour communiquer avec notre BDD et la table Hebergement, nous avons besoin de l'Entity Manager et du reposotiry
        $entityManager = $managerRegistry->getManager();
        $hebergementRepository = $entityManager->getRepository(Hebergement::class);
        $reservationRepository = $entityManager->getRepository(Reservation::class);
        $reservation= $reservationRepository->findAll();
        //on récupère les Catégories à afficher
        $categoryRepository = $entityManager->getRepository(Category::class);
        $categories = $categoryRepository->findAll();
        //on utilise la méthode find() de Repository afin de pouvoir retrouver le Product qui nous interesse
        $hebergement = $hebergementRepository->find($hebergementId);
        //si l'hébergement n'est pas trouvé, on retourne à la page d'accueil
        if(!$hebergement){
            return $this->redirectToRoute("app_index");
        }
     
        //Une fois que nous avons trouvé notre hébergement, on l'affiche
        return $this->render('index/hebergement_display.html.twig', [
            'hebergement' => $hebergement,
            'categories' => $categories,
        ]);

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
        //on récupère la liste de nos villes
        $cityRepository = $entityManager->getRepository(City::class);
        $cities = $cityRepository->findAll();

        //On récupère les hebergements par postCode
        $hebergements = $hebergementRepository->findBy(
            ["postcode" => $postCode]
        );

        foreach($hebergements as $hebergement){
            $postCode =  $hebergement->getPostCode();
        };
       
        //Si la recherche n'aboutie pas on retourne à la page d'acceuil
        if(!$hebergements){
            return $this->redirectToRoute('app_index');
        }
        //nous envoyons la liste des Hebergements liés au code postal à notre page d'index Twig
        return $this->render('index/hebergement_display.html.twig', [
            'cities' => $cities,
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
        //on récupère la liste de nos villes
        $cityRepository = $entityManager->getRepository(City::class);
        $cities = $cityRepository->findAll();

        //On récupère les hebergements par postCode
        $activities = $activityRepository->findBy(
            ["postcode" => $postCode]
        );

        foreach($activities as $activity){
            $postCode =  $activity->getPostCode();
        };
       
        //Si la recherche n'aboutie pas on retourne à la page d'acceuil
        if(!$activity){
            return $this->redirectToRoute('app_index');
        }
        //nous envoyons la liste des Hebergements liés au code postal à notre page d'index Twig
        return $this->render('index/hebergement_display.html.twig', [
            'postCode' => $postCode,
            'cities' => $cities,
            'activity' => $activity,
            'activities' => $activities
        ]);

    }
    


    /**
    * @Route("/category/{categoryName}", name="index_category")
    */
    public function displayByCategory(string $categoryName, ManagerRegistry $managerRegistry): Response
    {
        //cette page affiche la liste des hebergements correspondant à la catégorie mentionnée ds l'URL
        //nous récupérons l'entity manager et le Repository concerné
        $entityManager = $managerRegistry->getManager();
        $hebergementRepository = $entityManager->getRepository(Hebergement::class);
        $categoryRepository = $entityManager->getRepository(Category::class);
        //nous récupérons la liste de nos hebergements
        $hebergements = $hebergementRepository->findAll();
        // nous récupérons la category dont le nom correspond
        $category = $categoryRepository->findOneBy(
            ['name' => $categoryName],
        );
        
        foreach($hebergements as $hebergement){
            $hebergements =  $category->getHebergements();
            };
        //si notre tableau de hebergement est vide, ns retournons à l'index
        if(!$hebergements){
            return $this->redirectToRoute('app_index');
        }
        //si jamais notre recherche à mené à des résultats, ns en publions la liste
        return $this->render('index/hebergement_display.html.twig', [
            'hebergements' => $hebergements,
            'name' => $categoryName,
            'hebergement' => $hebergement,
            'category' => $category
        ]);
    } 



    /**
    * @Route("/displayBy/{cityName}", name="index_city")
    */
    public function displayByCity(string $cityName, ManagerRegistry $managerRegistry): Response
    {
        //cette page affiche la liste des hebergements correspondant à la ville mentionnée ds l'URL
        //nous récupérons l'entity manager et le Repository concerné
        $entityManager = $managerRegistry->getManager();
        $hebergementRepository = $entityManager->getRepository(Hebergement::class);
        $cityRepository = $entityManager->getRepository(City::class);
        // nous récupérons la ville dont le nom correspond
        $city = $cityRepository->findOneBy(
            ['name' => $cityName],
        );
        $hebergements =  $city->getHebergements();
        //si notre tableau de hebergement est vide, ns retournons à l'index
        if(!$hebergements){
            return $this->redirectToRoute('app_index');
        }
        //si jamais notre recherche à mené à des résultats, ns en publions la liste
        return $this->render('index/hebergement_display.html.twig', [
            'hebergements' => $hebergements,
            'name' => $cityName,
            'city' => $city,
        ]);
    } 
    

    /**
     * @Route("/reservationForm", name="reservation_form")
     */
    public function reservationForm(ManagerRegistry $managerRegistry, Request $request):Response
    {
        //cette méthode nous permet de renvoyer notre utilisateur vers un formulaire de réservation au click sur le bouton réserver de l'établissement souhaité et de créer une nouvelle instance de notre classe Reservation qu'on envoie en BDD
        //on récupère l'entity pertinent
        $entityManager = $managerRegistry->getManager();
        //on instancie un nouvel objet Reservation vide
        $reservation = new Reservation;
        //nous créons le formulaire que nous lions à notre obj Reservation
        $reservationForm = $this->createForm(ReservationType::class, $reservation);
        $reservationForm->handleRequest($request);
           if($request->isMethod('post') && $reservationForm->isSubmitted()){
               //on vérifie que la date de début de séjour n'est pas antérieur à la date de création de la réservation
               if($reservation->getFirstNightDate() > $reservation->getCreationDate()){
                $entityManager->persist($reservation);
                $entityManager->flush();
               }
                else {
                return $this->redirectToRoute('app_index');
            }
               
           }
   
        return $this->render('index/dataForm.html.twig', [
           'dataForm' => $reservationForm->createView(),
           'formName' => "Reservation"
        ]);

    }

   





}