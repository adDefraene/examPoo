<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CarRepository $cars): Response
    {
        $carsIntro = $cars->getHomeCars();

        return $this->render('index.html.twig', [
            'cars' => $carsIntro
        ]);
    }
}
