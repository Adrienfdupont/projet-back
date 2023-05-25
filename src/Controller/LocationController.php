<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Customer;
use App\Form\LocationType;
use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class LocationController extends AbstractController
{
    #[Route('/location', name: 'location')]
    public function index(CarRepository $carRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        /** @var Customer $user */
        $user = $this->getUser();

        if ($user == null) {
            return $this->redirectToRoute('app_login');
        }

        $newLocation = new Location();
        $newLocation->setCustomer($user);
        $form = $this->createForm(LocationType::class, $newLocation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager->persist($newLocation);
            $entityManager->flush();

            return $this->redirectToRoute('location');
        }

        return $this->render('location/index.html.twig', [
            'locations' => $user->getLocations(),
            'cars' => $carRepository->findAll(),
            'locationForm' => $form,
        ]);
    }
}
