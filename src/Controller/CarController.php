<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Image;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class CarController extends AbstractController
{
    /**
     * Function that display the "catalogue" page
     * @Route("/catalogue", name="catalogue")
     */
    public function catalogue(CarRepository $cars): Response
    {
        $catalogueCars = $cars->findAll();

        return $this->render('car/catalogue.html.twig', [
            'cars' => $catalogueCars
        ]);
    }


    /**
     * Function that displays the form to add a new Car in our DB
     *  (placed before to avoid being treated as a slug)
     * @Route("/car/new", name="car_new")
     *
     * @return Response
     */ 
    public function new(Request $req, EntityManagerInterface $manager): Response
    {
    //CREATE NEW CAR
        $car = new Car();

    //HANDLE THE FORM
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($req);

    //IF FORM SENT
        if($form->isSubmitted() && $form->isValid()){
        //INIT SLUG
            $car->setSlug('');

        //TREAT EACH IMAGES
            foreach($car->getImages() as $key => $picture){
                //dump($picture);
                //dump($picture['picture']);
                //CREATE THE OBJECT
                $image = new Image();

                $file = $picture['picture'];
                if(!empty($file)){

                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();
                    try{
                        $file->move(
                            $this->getParameter('uploads_directory'),
                            $newFilename
                        );
                    }
                    catch(FileException $e)
                    {
                        return $e->getMessage();
                    }
                    //SET THE CORRECT FILE
                    $image->setPicture($newFilename);
                }

                //SET THE CAR
                $image->setCar($car);
                //FUNCTION THAT REPLACE THE FILE SENT BY THE CORRECT ENTITY
                $car->removeWrongImage($key, $image);
                //PERSIST THE NEW ENTITY
                $manager->persist($image);
                //dump($car);
            }


        //TREAT THE CARs INFOS
            //COVER IMAGE
            $fileCover = $form['coverImage']->getData();
            
            if(!empty($fileCover)){

                $originalFilenameCover = pathinfo($fileCover->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilenameCover = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilenameCover);
                $newFilenameCover = $safeFilenameCover.'-'.uniqid().'.'.$fileCover->guessExtension();
                try{
                    $fileCover->move(
                        $this->getParameter('uploads_directory'),
                        $newFilenameCover
                    );
                }
                catch(FileException $e)
                {
                    return $e->getMessage();
                }
                
                $car->setCoverImage($newFilenameCover);
            }
            dump($car);
            $manager->persist($car);
            
            $manager->flush();

        //SET THE MESSAGE
            $this->addFlash(
                "success",
                "La voiture <strong>{$car->getBrand()} - {$car->getModel()}</strong> a été correctement ajoutée !"
            );
        //REDIRECT
            return $this->redirectToRoute('car', ['slug' => $car->getSlug()]);
        }

        return $this->render('car/new.html.twig', [
            'new_form' => $form->createView()
        ]);
    }


    /**
     * Function that display the specific page of a car
     * @Route("/car/{slug}", name="car")
     *
     * @param Car $car
     */
    public function car(Car $car): Response
    {
        return $this->render('car/car.html.twig', [
            'car' => $car
        ]);
    }
}
