<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Trip;
use App\Form\Type\TripType;
use App\Manager\TripManagerInterface;
use App\Model\TripFilter;
use App\Form\Type\TripFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Exception\ExceptionInterface;

class TripController extends AbstractController
{
    /**
     * Отображение списка поездок
     *
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
     * Добавление поездки
     *
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

    /**
     * Получение даты окончания поездки
     *
     * @Route("/trips/end-date", name="trip_end_date")
     * @param Request $request
     * @param TripManagerInterface $tripManager
     * @return Response
     */
    public function getEndDate(Request $request, TripManagerInterface $tripManager): Response
    {
        $startDate = $request->get('start_date');
        $regionId = $request->get('region_id');

        try {
            $endDate = $tripManager->computeEndDate(new \DateTime($startDate), (int)$regionId);
        } catch (ExceptionInterface $e) {
            return new JsonResponse(['error' => ['message' => $e->getMessage()]]);
        } catch (\Throwable $e) {
            return new JsonResponse(['error' => ['message' => 'Некорректный формат даты']]);
        }

        return new JsonResponse([
            'end_date' => $endDate->format('d.m.Y')
        ]);
    }
}