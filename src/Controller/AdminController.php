<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Activity;
use App\Form\ActivityType;
use App\Entity\Hebergement;
use App\Entity\Reservation;
use App\Form\HebergementType;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/display", name="app_admin")
     */
    /*public function index(ManagerRegistry $managerRegistry): Response
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
    }*/

    /**
     * @Route("/create/hebergement", name="create_hebergement")
     */
    public function createHebergement(ManagerRegistry $managerRegistry, Request $request, EntityManagerInterface $em, SerializerInterface $serializer)
    {
        //cette méthode nous permet de créer un nouvel hébergement et le pousser en bdd
        //je récupère le coprs de la requ$ete
        $jsonRecu = $request->getContent();
        //Je désérialise, et je persiste en BDD le nouvel hébergement
        try {
        $hebergement = $serializer->deserialize($jsonRecu, Hebergement::class, 'json');
        $em->persist($hebergement);
        $em->flush();

        return $this->json($hebergement, 201, [], ['groups' => 'hebergement:write']);
        //cath d'erreurs
        } catch (NotEncodableValueException $e) {
        return $this->json([
        'status' => 400,
        'message' => $e->getMessage()  ], 400);
    }
    }

    /**
    * @Route("/update/hebergement/{hebergementId}", name="update_hebergement")
    * @ParamConverter("hebergement")
    */
    public function updateHebergement(ManagerRegistry $managerRegistry, Request $request, int $hebergementId, ValidatorInterface $validator, SerializerInterface $serializer, EntityManagerInterface $em):Response
    {
        //cette méthode nous permet de mettre à jour un hébergement de notre bdd
        //Je récupère le corps de la requête
        $jsonRecu = $request->getContent();
        //Je récupère l'hébergement en fonction de son id
        $hebergementRepository = $em->getRepository(Hebergement::class);
        $hebergementToUpdate = $hebergementRepository->find($hebergementId);
        //je désérialise
        $hebergementUpdated = $serializer->deserialize($jsonRecu, Hebergement::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $hebergementToUpdate]);   
        try{
            $em->persist($hebergementUpdated);
            $em->flush();
            return $this->json($hebergementUpdated, 201, [], ['groups' => 'hebergement:write']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
            'status' => 400,
            'message' => $e->getMessage()], 400);
        }}

    /**
     * @Route("/hebergement/delete/{hebergementId}", name="delete_hebergement")
     */
    public function deleteHebergement(int $hebergementId, ManagerRegistry $managerRegistry,EntityManagerInterface $em)
    {
        //cette méthode nous permet de supprimer un hebergement de notre bdd
        $em = $managerRegistry->getManager();
        $hebergementRepository = $em->getRepository(Hebergement::class);
        $hebergement = $hebergementRepository->find($hebergementId);
        try {
            $em->remove($hebergement);
            $em->flush();
            return $this->json($hebergement, 201, [], ['groups' => 'hebergement:read']);
        }
        catch (NotEncodableValueException $e) {
            return $this->json([
        'status' => 400,
        'message' => $e->getMessage()], 400);
        }
    }



    /**
    * @Route("/create/activity", name="create_activity")
    */
    public function createActivity(ManagerRegistry $managerRegistry, Request $request, SerializerInterface $serializer, EntityManagerInterface $em):Response
    {
        //cette méthode nous permet de créer une nouvelle activitée et le pousser en bdd
        //je récupère le coprs de la requ$ete
        $jsonRecu = $request->getContent();
        //Je désérialise, et je persiste en BDD le nouvel hébergement
        try {
        $activity = $serializer->deserialize($jsonRecu, Activity::class, 'json');
        $em->persist($activity);
        $em->flush();

        return $this->json($activity, 201, [], ['groups' => 'hebergement:write']);
        //cath d'erreurs
        } catch (NotEncodableValueException $e) {
        return $this->json([
        'status' => 400,
        'message' => $e->getMessage()  ], 400);
        }
    }

    
    /**
    * @Route("/update/activity/{activityId}", name="update_activity")
    * @ParamConverter("activity")
    */
    public function updateActivity(Request $request, int $activityId, EntityManagerInterface $em, SerializerInterface $serializer): Response 
    {
        //cette méthode nous permet de mettre à jour une activitée de notre bdd
        //Je récupère le corps de la requête
        $jsonRecu = $request->getContent();
        //Je récupère l'activité en fonction de son id
        $activityRepository = $em->getRepository(Activity::class);
        $activityToUpdate = $activityRepository->find($activityId);
    
        //$form = $this->createForm(HebergementType::class, $hebergementToUpdate);
        //je sédérialise
        $activityUpdated = $serializer->deserialize($jsonRecu, Activity::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $activityToUpdate]);
            
        try{
            $em->persist($activityUpdated);
            $em->flush();
            return $this->json($activityUpdated, 201, [], ['groups' => 'activity:write']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
            'status' => 400,
            'message' => $e->getMessage()], 400);
        }
    }

    /**
    * @Route("/activity/delete/{activityId}", name="delete_activity")
    */
    public function deleteActivity(int $activityId, ManagerRegistry $managerRegistry, EntityManagerInterface $em)
    {
        //cette méthode nous permet de supprimer une activité de la vue et de la bdd 
        $entityManager = $managerRegistry->getManager();
        $activityRepository = $entityManager->getRepository(Activity::class);
        //ns recherchons l'activité qui nous interesse
        $activity = $activityRepository->find($activityId);
        try {
            $em->remove($activity);
            $em->flush();
            return $this->json($activity, 201, [], ['groups' => 'activity:read']);
        }
        catch (NotEncodableValueException $e) {
            return $this->json([
        'status' => 400,
        'message' => $e->getMessage()], 400);
        }
    }
}
