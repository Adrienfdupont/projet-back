<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarRepository;
use Symfony\Component\HttpFoundation\Request;

class LocationController extends AbstractController
{
    #[Route('/location', name: 'location')]
    public function index(CustomerRepository $customerRepository, CarRepository $carRepository): Response
    {
        $user = $this->getUser();

        if ($user == null) {
            return $this->redirectToRoute('app_login');
        }
        $customer = $customerRepository->find($user->getId());

        $locations = $customer->getLocations();
        $cars = $carRepository->findAll();

        return $this->render('location/index.html.twig', [
            'locations' => $locations,
            'cars' => $cars
        ]);
    }

    #[Route('/location/form', name: 'form')]
    public function formAction(Request $request, CustomerRepository $customerRepository, CarRepository $carRepository): Response
    {
        dd($request->request->get('startDate'));
    }
}
