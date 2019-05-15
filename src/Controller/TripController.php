<?php declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\TripFilterType;
use App\Manager\TripManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TripController extends AbstractController
{
    /**
     * @Route("/")
     * @param Request $request
     * @param TripManager $tripManager
     * @return Response
     */
    public function show(Request $request, TripManager $tripManager)
    {
        $form = $this->createForm(TripFilterType::class);
        $form->handleRequest($request);

        $trips = $tripManager->getTrips([
           // 'start_date' => new \DateTime('2018-01-01')
        ]);

        return $this->render('trip/index.html.twig', [
            'form' => $form->createView(),
            'trips' => $trips
        ]);
    }
}