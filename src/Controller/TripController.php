<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Trip;
use App\Form\Type\TripType;
use App\Manager\TripManagerInterface;
use App\Model\TripFilter;
use App\Form\Type\TripFilterType;
use App\Manager\TripManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Exception\ExceptionInterface;

class TripController extends AbstractController
{
    /**
     * @Route("/")
     * @param Request $request
     * @param TripManagerInterface $tripManager
     * @return Response
     */
    public function show(Request $request, TripManagerInterface $tripManager): Response
    {
        $tripFilter = new TripFilter();
        $form = $this->createForm(TripFilterType::class, $tripFilter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trips = $tripManager->getTrips($tripFilter);
        }

        return $this->render('trip/index.html.twig', [
            'form' => $form->createView(),
            'trips' => $trips ?? []
        ]);
    }

    /**
     * @Route("/trips/add", name="trip_add")
     * @param Request $request
     * @param TripManagerInterface $tripManager
     * @return Response
     */
    public function add(Request $request, TripManagerInterface $tripManager): Response
    {
        $trip = new Trip();
        $form = $this->createForm(TripType::class, $trip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $tripManager->addTrip($trip);
            } catch (ExceptionInterface $e) {
                $form->addError(new FormError($e->getMessage()));
            }
        }

        return $this->render('trip/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}