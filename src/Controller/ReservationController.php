<?php

namespace App\Controller;

use App\Entity\Hebergement;
use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;


/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="app_reservation")
     */
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }

    /**
    * @Route("/client/backoffice", name="client_backoffice")
    */
    public function clientBackoffice(ManagerRegistry $managerRegistry):Response
    {
        //cette méthode permet d'afficher la liste des réservations enregistrées dans  notre BDD pour un client connecté en tant que user
        //nous avons besoin de l'entity manager et du repository pertinent
        //on récupère l'utilisateur
        $user = $this->getUser(); // permet de récupérer l'utilisateur en cours
        $entityManager = $managerRegistry->getManager();
        $hebergementRepository = $entityManager->getRepository(Hebergement::class);
        $hebergements = $hebergementRepository->findAll();
        $reservationRepository = $entityManager->getRepository(Reservation::class);
        $reservations = $reservationRepository->findAll();
        if(!$user){
            
        }
        //on transmet les reservations à twig
        return $this->render('admin/backoffice_client.html.twig', [
            'reservations' => $reservations,
            'hebergements' => $hebergements
        ]);
    }

    /**
     * @Route("/reservationForm/{hebergementId}", name="reservation_form")
     */
    public function reservationForm(EntityManagerInterface $em, Request $request, SerializerInterface $serializer, ValidatorInterface $validator, int $hebergementId)
    {
    //cette méthode nous permet de créer une réservation sur un hébergement
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
    return $this->json($reservation, 201, [], ['groups' => 'reservation:write']);
        } catch (NotEncodableValueException $e) {
        return $this->json([
            'status' => 400,
            'message' => $e->getMessage()
        ], 400);
    }
    }

    /**
    * @Route("/update/{reservationId}", name="update_reservation")
    */
    public function updateReservation(ManagerRegistry $managerRegistry, Request $request, int $reservationId): Response 
    {
        //cette méthode nous permet de modifier les valeurs d'une entity Reservation qui a été persisté en BDD, selon son ID renseigné en BDD et selon son utilisateur
        //on récupère l'utilisateur
        $user = $this->getUser();
        //on récupère l'entity manager et le repository concerné
        $entityManager = $managerRegistry->getManager();
        $reservationRepository = $entityManager->getRepository(Reservation::class);
        $reservation = $reservationRepository->find($reservationId);
        //si notre hebergement n'est pas trouvé on retourne à l'index admin
        if(!$reservation){
            return $this->redirectToRoute('client_backoffice');
        }
        //on créé le formulaire que nous lions à notre objet Hebergement
        $reservationForm = $this->createForm(ReservationType::class, $reservation);
        //on transmet le contenu de notre hebergement modifié si présent
        $reservationForm->handleRequest($request);
        if($request->isMethod('post') && $reservationForm->isValid()){
            $entityManager->persist($reservation);
            $entityManager->flush();
            return $this->redirectToRoute('client_backoffice');
        }
        //si le formulaire n'est pas rempli, on le présente à l'admin
        return $this->render('index/dataForm.html.twig', [
            'formName' => 'Modification de la réservation',
            'dataForm' => $reservationForm->createView(),
        ]);
    }

    /**
     * @Route("/delete/{reservationId}", name="delete_reservation")
     */
    public function deleteReservation(ManagerRegistry $managerRegistry, int $reservationId):Response
    {
        //cette méthode permet à l'utilisateur de supprimer une réservation qui à été instanciée en BDD 
        //nous avons besoin de l'entity et du repository pertinent
        //on récupère l'utilisateur
        $user = $this->getUser();
        $entityManager = $managerRegistry->getManager();
        $reservationRepository = $entityManager->getRepository(Reservation::class);
        $reservation = $reservationRepository->find($reservationId);
        if(!$reservation){
            return $this->redirectToRoute('client_backoffice');
        }
        $entityManager->persist($reservation);
        $entityManager->remove($reservation);
        $entityManager->flush();
        return $this->redirectToRoute('client_backoffice');
    }
}
