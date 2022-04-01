<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Activity;
use App\Entity\Category;
use App\Entity\Hebergement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class HebergementFixtures extends Fixture 
{
    public function load(ObjectManager $manager): void 
    {
        //Tableau de tableaux associatifs contenant les informations pour les attributs de chaque object Hebergement à instancier (name, description, type, prix et l'instance de category)
        $hebergementArray = [
            ["name" => "Auberge la Cannebiere",
            "description" => "Lorem ipsum dolor sit amet. Quo rerum aliquid ut perferendis sapiente 33 tempore cumque ut nihil asperiores est fuga Quis et culpa odio. Non dignissimos debitis aut tenetur temporibus non vitae culpa?

            Sed ratione enim sit dolor temporibus ab quasi optio aut harum reprehenderit vel animi autem et dolores velit et praesentium praesentium. Vel possimus animi At laboriosam libero et similique corrupti non tempore facilis non exercitationem ratione ad architecto dolore ut ducimus enim. Ut numquam sequi qui labore dolorem sit similique repellendus qui dolorem cumque 33 eius fugiat est voluptatem natus. Aut atque odio non labore totam id consequatur repellat qui quisquam fuga est quae quos est voluptas accusamus.",
            "type" => "hotel",
            "price" => 25,
            "category" => "economique",
            "Ville" => "marseille",
            "postcode" => 13
            ],
            ["name" => "Hotel du port",
            "description" => "Lorem ipsum dolor sit amet. Quo rerum aliquid ut perferendis sapiente 33 tempore cumque ut nihil asperiores est fuga Quis et culpa odio. Non dignissimos debitis aut tenetur temporibus non vitae culpa?

            Sed ratione enim sit dolor temporibus ab quasi optio aut harum reprehenderit vel animi autem et dolores velit et praesentium praesentium. Vel possimus animi At laboriosam libero et similique corrupti non tempore facilis non exercitationem ratione ad architecto dolore ut ducimus enim. Ut numquam sequi qui labore dolorem sit similique repellendus qui dolorem cumque 33 eius fugiat est voluptatem natus. Aut atque odio non labore totam id consequatur repellat qui quisquam fuga est quae quos est voluptas accusamus.",
            "type" => "hotel",
            "price" => 52,
            "category" => "romantique",
            "ville"=> "marseille",
            "postcode" => 13
            ],
            ["name"=> "Hotel le mouettes",
            "description" => "Lorem ipsum dolor sit amet. Quo rerum aliquid ut perferendis sapiente 33 tempore cumque ut nihil asperiores est fuga Quis et culpa odio. Non dignissimos debitis aut tenetur temporibus non vitae culpa?

            Sed ratione enim sit dolor temporibus ab quasi optio aut harum reprehenderit vel animi autem et dolores velit et praesentium praesentium. Vel possimus animi At laboriosam libero et similique corrupti non tempore facilis non exercitationem ratione ad architecto dolore ut ducimus enim. Ut numquam sequi qui labore dolorem sit similique repellendus qui dolorem cumque 33 eius fugiat est voluptatem natus. Aut atque odio non labore totam id consequatur repellat qui quisquam fuga est quae quos est voluptas accusamus.",
            "type" => "hotel",
            "price" => 76,
            "category" => "animauxok",
            "ville" => "cannes",
            "postcode" => 06
            ],
            ["name" => "Hotel de la mer",
            "description" => "Lorem ipsum dolor sit amet. Quo rerum aliquid ut perferendis sapiente 33 tempore cumque ut nihil asperiores est fuga Quis et culpa odio. Non dignissimos debitis aut tenetur temporibus non vitae culpa?

            Sed ratione enim sit dolor temporibus ab quasi optio aut harum reprehenderit vel animi autem et dolores velit et praesentium praesentium. Vel possimus animi At laboriosam libero et similique corrupti non tempore facilis non exercitationem ratione ad architecto dolore ut ducimus enim. Ut numquam sequi qui labore dolorem sit similique repellendus qui dolorem cumque 33 eius fugiat est voluptatem natus. Aut atque odio non labore totam id consequatur repellat qui quisquam fuga est quae quos est voluptas accusamus.",
            "type" => "hotel",
            "price" => 46,
            "category" => "familial",
            "ville" => "antibes",
            "postcode" => 06
            ],
            ["name" => "Auberge le panier",
            "description" => "Lorem ipsum dolor sit amet. Quo rerum aliquid ut perferendis sapiente 33 tempore cumque ut nihil asperiores est fuga Quis et culpa odio. Non dignissimos debitis aut tenetur temporibus non vitae culpa?

            Sed ratione enim sit dolor temporibus ab quasi optio aut harum reprehenderit vel animi autem et dolores velit et praesentium praesentium. Vel possimus animi At laboriosam libero et similique corrupti non tempore facilis non exercitationem ratione ad architecto dolore ut ducimus enim. Ut numquam sequi qui labore dolorem sit similique repellendus qui dolorem cumque 33 eius fugiat est voluptatem natus. Aut atque odio non labore totam id consequatur repellat qui quisquam fuga est quae quos est voluptas accusamus.",
            "type" => "auberge",
            "price" => 23,
            "category" => "economique",
            "ville" => "lyon",
            "postcode" => 69
            ],
            ["name" => "Au coeur de l'eau",
            "description" => "Lorem ipsum dolor sit amet. Quo rerum aliquid ut perferendis sapiente 33 tempore cumque ut nihil asperiores est fuga Quis et culpa odio. Non dignissimos debitis aut tenetur temporibus non vitae culpa?

            Sed ratione enim sit dolor temporibus ab quasi optio aut harum reprehenderit vel animi autem et dolores velit et praesentium praesentium. Vel possimus animi At laboriosam libero et similique corrupti non tempore facilis non exercitationem ratione ad architecto dolore ut ducimus enim. Ut numquam sequi qui labore dolorem sit similique repellendus qui dolorem cumque 33 eius fugiat est voluptatem natus. Aut atque odio non labore totam id consequatur repellat qui quisquam fuga est quae quos est voluptas accusamus.",
            "type" => "chambre d'hote",
            "price" => 71,
            "category" => "animauxok",
            "ville" => "toulouse",
            "postcode" => 31
            ],
            ["name" => "Le rivage",
            "description" => "Lorem ipsum dolor sit amet. Quo rerum aliquid ut perferendis sapiente 33 tempore cumque ut nihil asperiores est fuga Quis et culpa odio. Non dignissimos debitis aut tenetur temporibus non vitae culpa?

            Sed ratione enim sit dolor temporibus ab quasi optio aut harum reprehenderit vel animi autem et dolores velit et praesentium praesentium. Vel possimus animi At laboriosam libero et similique corrupti non tempore facilis non exercitationem ratione ad architecto dolore ut ducimus enim. Ut numquam sequi qui labore dolorem sit similique repellendus qui dolorem cumque 33 eius fugiat est voluptatem natus. Aut atque odio non labore totam id consequatur repellat qui quisquam fuga est quae quos est voluptas accusamus.",
            "type" => "auberge de jeunesse",
            "price" => 17,
            "category" => "economique",
            "ville" => "carcasonne",
            "postcode" => 11
            ],
            ["name" => "Hotel le soleil du matin",
            "description" => "Lorem ipsum dolor sit amet. Quo rerum aliquid ut perferendis sapiente 33 tempore cumque ut nihil asperiores est fuga Quis et culpa odio. Non dignissimos debitis aut tenetur temporibus non vitae culpa?

            Sed ratione enim sit dolor temporibus ab quasi optio aut harum reprehenderit vel animi autem et dolores velit et praesentium praesentium. Vel possimus animi At laboriosam libero et similique corrupti non tempore facilis non exercitationem ratione ad architecto dolore ut ducimus enim. Ut numquam sequi qui labore dolorem sit similique repellendus qui dolorem cumque 33 eius fugiat est voluptatem natus. Aut atque odio non labore totam id consequatur repellat qui quisquam fuga est quae quos est voluptas accusamus.",
            "type" => "hotel",
            "price" => 128,
            "category" => "romantique",
            "ville" => "cabourg",
            "postcode" => 14
            ],
            ["name" => "Au bord du lac",
            "description" => "Lorem ipsum dolor sit amet. Quo rerum aliquid ut perferendis sapiente 33 tempore cumque ut nihil asperiores est fuga Quis et culpa odio. Non dignissimos debitis aut tenetur temporibus non vitae culpa?

            Sed ratione enim sit dolor temporibus ab quasi optio aut harum reprehenderit vel animi autem et dolores velit et praesentium praesentium. Vel possimus animi At laboriosam libero et similique corrupti non tempore facilis non exercitationem ratione ad architecto dolore ut ducimus enim. Ut numquam sequi qui labore dolorem sit similique repellendus qui dolorem cumque 33 eius fugiat est voluptatem natus. Aut atque odio non labore totam id consequatur repellat qui quisquam fuga est quae quos est voluptas accusamus.",
            "type"=> "chambre d'hote",
            "price" => 25,
            "category" => "familial",
            "ville" => "annecy",
            "postcode" => 74
            ]
        ];

        //Description générique via faux texte
        $lorem = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed at sapien ut sem convallis euismod. Phasellus eu condimentum augue. Praesent feugiat sem dolor, quis pharetra risus ullamcorper sed. Vivamus quis lacus id mi mollis vehicula ac in leo. Etiam aliquam sagittis euismod. Pellentesque sed viverra arcu, in tristique leo. Ut dui mauris, ullamcorper ut enim sit amet, vehicula gravida eros.
        Maecenas quis sapien a lorem tempor semper. Donec tempor mollis vestibulum. Integer a posuere eros. Aenean feugiat ut velit non tincidunt. Vivamus egestas nisi sit amet magna pharetra facilisis. Nam finibus dictum turpis, vel feugiat orci rhoncus pulvinar. Nunc pretium pretium purus sit amet vulputate. Nulla et erat nulla. Nam eget nisi massa. ';


         //la liste de nos différentes catégories sous forme d'un tableau associatif, contenant une identification du type catégorie sous la clé et l'objet Category en valeur
         $categoryArray = ['familial' => null, 'economique' => null, 'romantique' => null, 'animauxok'=> null];

         //Renseignement et implémentation de la liste des Category
         foreach($categoryArray as $key => &$value){ //nous récupérons le tableau des catégories à implémenter
         //le & avant value indique une référence, ce qui signifie que nous récupérons la variable en tant que telle plutot que sa valeur, ce qui nous permet de modifier notre tableau $categoryArray plutot qu'une copie de $value qui sera supprimée après la boucle
             $value = new Category; //A chaque valeur est attribué à un nouvel objet Category
             $value->setName(ucfirst($key)); //Le nom est la clé de l'index
             $value->setDescription($lorem); //La description est un lorem générique
             $manager->persist($value);//Demande de persistance de notre nouvelle Category
 
        }

       //Tableau de tableaux assoc contenant les informations pour les attributs de chaque objet City à instancier
        $cityArray = [
            ["name" => "marseille",
            "activity" => null,
            "postcode" => 13
            ],
            ["name" => "cannes",
            "activity" => null,
            "postcode" => 06
            ],
            ["name" => "antibes",
            "activity" => null,
            "postcode" => 06
            ],
            ["name" => "cabourg",
            "activity" => null,
            "postcode" => 14
            ],
            ["name" => "annecy",
            "activity" => null,
            "postcode" => 74
            ]
        ];

        //on lie le tableau $cityArray grâce à une boucle foreach et on persiste chaque nouvelle City renseigné par les infos du tab assoc parcouru
        foreach ($cityArray as $cityData){
            $city = new City;
            $city->setName($cityData['name']);
            $city->setActivity($cityData['activity']);
            $city->setPostcode($cityData['postcode']);     
            $manager->persist($city);
        }


        $activityArray = [
            ["name" => "notre dame de la garde",
            "description" => $lorem,
            "postcode" => 13,
            "city" => $city
            ],
            ["name" => "iles de frioul",
            "description" => $lorem,
            "postcode" => 06,
            "city" => $city
            ],
            ["name" => "plage de cabourg",
            "description" => $lorem,
            "postcode" => 14,
            "city" => $city
            ],
            ["name" => "lac d annecy",
            "description" => $lorem,
            "postcode" => 74,
            "city" => $city
            ],
        ];

        //on lie le tableau $ActivityArray grâce à une boucle foreach et on persiste chaque nouvelle Activity renseigné par les infos du tab assoc parcouru
        foreach ($activityArray as $activityData){
            $activity = new Activity;
            $activity->setName($activityData['name']);
            $activity->setDescription($activityData['description']);
            $activity->setPostcode($activityData['postcode']);  
            $activity->setCity($city);   
            $manager->persist($activity);
        }


        //Renseignement et implémentation de la liste des City
        //foreach($cityArray as $key => &$value){ 
                /*$value = new City; //A chaque valeur est attribué à un nouvel objet City
                $value->setName(ucfirst($key)); //Le nom est la clé de l'index
                $value->addActivity($activityArray['name']);

                $manager->persist($value);//Demande de persistance du produit
    
           }

        //Renseignement et implémentation de la liste des Activity
        foreach($activityArray as $key => &$value){ 
                $value = new Activity; //A chaque valeur est attribué à un nouvel objet Activity
                $value->setName(ucfirst($key)); //Le nom est la clé de l'index
                $value->setDescription($lorem); //La description est un lorem générique
                $value->setCity($cityArray[$activityData['city']]);

                $manager->persist($value);//Demande de persistance du produit   
        }*/
   

        //Nous lions le tableau $hebergementArray grâce à une boucle foreach et nous persistons chaque nouveau Hebergement renseigné par les infos du tab assoc parcouru
        foreach ($hebergementArray as $hebergementData){ //on créé un nouveau produit avant de le renseigner
            $hebergement = new Hebergement;
            $hebergement->setName($hebergementData['name']);
            $hebergement->setDescription($hebergementData['description']);
            $hebergement->setPrice($hebergementData['price']);
            $hebergement->setPostcode($hebergementData['postcode']);
            //nous récupérons l'objet de categoryArray tenu par la clef donc le nom est fourni par la valeur de "category" de $hebergementData
            $hebergement->setCategory($categoryArray[$hebergementData['category']]);
            $manager->persist($hebergement);//Demande de persistance du produit

        }


        $manager->flush();

    }
}