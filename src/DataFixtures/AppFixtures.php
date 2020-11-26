<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Car;
use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    //CARS MANAGEMENT
        for($i=1; $i <= 10; $i++){
        //INITIALIZE OBJECT
            $car = new Car();

        //FAKER VARS TO BE DEFINED
            //ARRAY OF BRANDS
            $brand = array('Citroen', 'Peugeot', 'Renault', 'Volkswagen', 'Opel', 'Honda', 'Mazda', 'Toyota', 'Nissan');
            //ARRAYS OF MODELS
            $model = array (
                'Citroen' => array('C1', 'C2', 'C3', 'Saxo', 'C4 Cactus'),
                'Peugeot' => array('106', '206', '306', '405', '806'),
                'Renault' => array('Safrane', 'Lutecia', 'Twingo', 'Espace'),
                'Volkswagen' => array('Golf', 'Polo', 'Scirocco', 'Fox', 'Lupo'),
                'Opel' => array('Corsa', 'Astra'),
                'Honda' => array('Civic', 'Jazz'),
                'Mazda' => array('MX-5', 'Mazda 2', 'Mazda 3', 'Mazda 6'),
                'Toyota' => array('Yaris', 'Auris', 'Corolla'),
                'Nissan' => array('Leaf', 'Juke'),
            );
            //ARRAYS OF OPTIONS
            $options = array("Cruise control", "Dégivrage électrtique avant", "Radio mp3", "Vitres électriques", "Air conditionné");

        //INITIALIZE FAKER
            $faker = Factory::create();

        //FAKE BRAND AND ITS MODEL + OPTIONS
            $fakedBrand = $faker->randomElement($brand);
            $fakedModel = $faker->randomElement($model[$fakedBrand]);
            $fakedOptions = $faker->randomElements($options, 3);
            $fakedOptionsString = implode(", ", $fakedOptions);
                

        //SET CARs INFOS
            $car->setBrand($fakedBrand)
                ->setModel($fakedModel)
                ->setCoverImage("https://picsum.photos/id/".mt_rand(1,200)."/1200/720")
                ->setMileage(mt_rand(50,175)*1000)
                ->setPrice(mt_rand(15, 125)*100)
                ->setOldOwner(mt_rand(1,3))
                ->setEngineCc(mt_rand(11,18)*100)
                ->setEnginePower(mt_rand(50,86))
                ->setFuel($faker->randomElement(array("Diesel", "Essence")))
                ->setYearRelease(mt_rand(1995,2008))
                ->setTransmission($faker->randomElement(array("Automatique", "Manuelle")))
                ->setDescription('<p>'.join('</p><p>', $faker->paragraphs(4)).'</p>')
                ->setOptions($fakedOptionsString);
                
        //CAR PERSIST
            $manager->persist($car);

        //IMAGES MANAGEMENT
            for($j=1; $j <= rand(2,5); $j++){
            //INIT NEW IMAGE
                $image = new Image();
            //SET IMAGE INFOS
                $image->setPicture("https://picsum.photos/id/".mt_rand(201,1000)."/1200/720")
                    ->setCar($car);
            //IMAGE PERSIST
                $manager->persist($image);
            }
        }
    //BIG FLUSH
        $manager->flush();
    }
}
