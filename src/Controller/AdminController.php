<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Activity;
use App\Form\ActivityType;
use App\Entity\Hebergement;
use App\Entity\Reservation;
use App\Form\HebergementType;
use App\Form\ReservationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/display", name="app_admin")
     */
    public function index(ManagerRegistry $managerRegistry): Response
    {
        //cette méthode nous renvoie vers une page nous présentant la liste de tous les hébergements et activtées enregistrés dans notre BDD à des fins de consultations, modifications ou suppression
        //On récupère l'entity et les repository pertinent
        $entityManager = $managerRegistry->getManager();
        //nous récupérons la liste de nos hébergements
        $hebergementRepository = $entityManager->getRepository(Hebergement::class);
        $hebergements = $hebergementRepository->findAll();
        //nous récupérons la liste de nos activités
        $activityRepository = $entityManager->getRepository(Activity::class);
        $activities = $activityRepository->findAll();
        return $this->render('admin/backoffice_admin.html.twig', [
            'hebergements' => $hebergements,
            'activities' => $activities,
        ]);
    }

    /**
     * @Route("/create/hebergement", name="create_hebergement")
     */
    public function createHebergement(ManagerRegistry $managerRegistry, Request $request):Response
    {
        //cette méthode nous permet de créer une nouvelle fiche d'établissement à rentrer en BDD et à présenter à nos utilisateurs
        //on récupère l'entity et les repository pertinent
        $entityManager = $managerRegistry->getManager();
        //on instancie un nouvel objet Hebergement vide
        $hebergement = new Hebergement;
        //nous créons le formulaire que nous lions à notre objet Hebergement
        $hebergementForm = $this->createForm(HebergementType::class, $hebergement);
        //on transmet le contenu du formulaire validé à notre Hebergement
        $hebergementForm->handleRequest($request);
        //si notre hébergement est validé, on l'envoie en BDD
        if($request->isMethod('post') && $hebergementForm->isValid()){
            $entityManager->persist($hebergement);
            $entityManager->flush();
        }

        //on transmet la nouvelle fiche établissement à notre template Twig
        return $this->render('index/dataForm.html.twig', [
            'formName' => "Ajout d'un établissement",
            'dataForm' => $hebergementForm -> createView(),
        ]);
    }

    /**
    * @Route("/update/hebergement/{hebergementId}", name="update_hebergement")
    */
    public function updateHebergement(ManagerRegistry $managerRegistry, Request $request, int $hebergementId): Response 
    {
        //cette méthode nous permet de modifier les valeurs d'une entity Hebergement qui a été persisté en BDD, selon son ID renseigné en BDD
        //on récupère l'entity manager et le repository concerné
        $entityManager = $managerRegistry->getManager();
        $hebergementRepository = $entityManager->getRepository(Hebergement::class);
        $hebergement = $hebergementRepository->find($hebergementId);
        //si notre hebergement n'est pas trouvé on retourne à l'index admin
        if(!$hebergement){
            return $this->redirectToRoute('app_admin');
        }
        //on créé le formulaire que nous lions à notre objet Hebergement
        $hebergementForm = $this->createForm(HebergementType::class, $hebergement);
        //on transmet le contenu de notre hebergement modifié si présent
        $hebergementForm->handleRequest($request);
        if($request->isMethod('post') && $hebergementForm->isValid()){
            $entityManager->persist($hebergement);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }
        //si le formulaire n'est pas rempli, on le présente à l'admin
        return $this->render('index/dataForm.html.twig', [
            'formName' => 'Modification de la fiche établissement',
            'dataForm' => $hebergementForm->createView(),
        ]);
    }


     /**
     * @Route("/hebergement/delete/{hebergementId}", name="delete_hebergement")
     */
    public function deleteHebergement(int $hebergementId, ManagerRegistry $managerRegistry, Request $request):Response
    {
        //cette méthode nous permet de supprimer une fiche d'établissement de la vue et de la bdd 
        $entityManager = $managerRegistry->getManager();
        $hebergementRepository = $entityManager->getRepository(Hebergement::class);
        //ns recherchons le bulletin qui nous interesse
        $hebergement = $hebergementRepository->find($hebergementId);
        //si l'hebergement n'est pas trouvé, retour à l'index admin
        if(!$hebergement){
            return $this->redirectToRoute("app_admin");
        }
        //si le bulletin possède une valeur, ns sommes en possession de l'entity à supp. ns passons dc une requête à l'entity manager
        $entityManager->remove($hebergement);
        $entityManager->flush(); // on applique la requête
        //on revient à l'index
        return $this->redirectToRoute("app_admin");
    }



    /**
    * @Route("/create/activity", name="create_activity")
    */
    public function createActivity(ManagerRegistry $managerRegistry, Request $request):Response
    {
        //cette méthode nous permet de créer une nouvelle fiche d'établissement à rentrer en BDD et à présenter à nos utilisateurs
        //on récupère l'entity et les repository pertinent
        $entityManager = $managerRegistry->getManager();
        //on instancie un nouvel objet Acivity vide
        $activity = new Activity;
        //nous créons le formulaire que nous lions à notre objet Hebergement
        $activityForm = $this->createForm(ActivityType::class, $activity);
        //on transmet le contenu du formulaire validé à notre Hebergement
        $activityForm->handleRequest($request);
        //si notre activité est validé, on l'envoie en BDD
        if($request->isMethod('post') && $activityForm->isValid()){
            $entityManager->persist($activity);
            $entityManager->flush();
        }

        //on transmet la nouvelle fiche établissement à notre template Twig
        return $this->render('index/dataForm.html.twig', [
            'formName' => "Ajout d'une activité",
            'dataForm' => $activityForm -> createView(),
        ]);
    }

    
    /**
    * @Route("/update/activity/{activityId}", name="update_activity")
    */
    public function updateActivity(ManagerRegistry $managerRegistry, Request $request, int $activityId): Response 
    {
        //cette méthode nous permet de modifier les valeurs d'une entity Acivity qui a été persisté en BDD, selon son ID renseigné en BDD
        //on récupère l'entity manager et le repository concerné
        $entityManager = $managerRegistry->getManager();
        $activityRepository = $entityManager->getRepository(Activity::class);
        $activity = $activityRepository->find($activityId);
        //si notre hebergement n'est pas trouvé on retourne à l'index admin
        if(!$activity){
            return $this->redirectToRoute('app_admin');
        }
        //on créé le formulaire que nous lions à notre objet Hebergement
        $activityForm = $this->createForm(ActivityType::class, $activity);
        //on transmet le contenu de notre hebergement modifié si présent
        $activityForm->handleRequest($request);
        if($request->isMethod('post') && $activityForm->isValid()){
            $entityManager->persist($activity);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin');
        }
        //si le formulaire n'est pas rempli, on le présente à l'admin
        return $this->render('index/dataForm.html.twig', [
            'formName' => 'Modification de la fiche établissement',
            'dataForm' => $activityForm->createView(),
        ]);
    }

    /**
    * @Route("/activity/delete/{activityId}", name="delete_activity")
    */
    public function deleteActivity(int $activityId, ManagerRegistry $managerRegistry, Request $request):Response
    {
        //cette méthode nous permet de supprimer une fiche d'établissement de la vue et de la bdd 
        $entityManager = $managerRegistry->getManager();
        $activityRepository = $entityManager->getRepository(Activity::class);
        //ns recherchons le bulletin qui nous interesse
        $activity = $activityRepository->find($activityId);
        //si l'hebergement n'est pas trouvé, retour à l'index admin
        if(!$activity){
            return $this->redirectToRoute("app_admin");
        }
        //si le bulletin possède une valeur, ns sommes en possession de l'entity à supp. ns passons dc une requête à l'entity manager
        $entityManager->remove($activity);
        $entityManager->flush(); // on applique la requête
        //on revient à l'index
        return $this->redirectToRoute("app_admin");
    } 
}
