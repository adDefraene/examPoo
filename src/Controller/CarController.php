<?php

namespace App\Controller;

use App\Entity\Car;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
