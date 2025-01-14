<?php

namespace App\Controller;

use App\Command\AddMeasurementCommand;
use App\Command\DeleteMeasurementCommand;
use App\Command\UpdateMeasurementCommand;
use App\Handler\AddMeasurementHandler;
use App\Handler\DeleteMeasurementHandler;
use App\Handler\DownloadOriginalMeasurementFileHandler;
use App\Handler\GetMeasurementsHandler;
use App\Handler\UpdateMeasurementHandler;
use App\Query\DownloadOriginalMeasurementFileQuery;
use App\Query\GetMeasurementsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/measurements')]
class MeasurementController extends AbstractController
{
    public function __construct(
        private readonly AddMeasurementHandler $addMeasurementHandler,
        private readonly UpdateMeasurementHandler $updateMeasurementHandler,
        private readonly DeleteMeasurementHandler $deleteMeasurementHandler,
        private readonly GetMeasurementsHandler $getMeasurementsHandler,
        private readonly DownloadOriginalMeasurementFileHandler $downloadOriginalMeasurementFileHandler,
    ) {}

    #[Route(name: 'add_measurement', methods: Request::METHOD_POST)]
    public function addMeasurement(AddMeasurementCommand $command): Response
    {
        $this->addMeasurementHandler->__invoke($command);
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(path: '/{uuid}', name: 'update_measurement', methods: Request::METHOD_PATCH)]
    public function updateMeasurement(UpdateMeasurementCommand $command): Response
    {
        $this->updateMeasurementHandler->__invoke($command);
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(path: '/{uuid}', name: 'delete_measurement', methods: Request::METHOD_DELETE)]
    public function deleteMeasurement(DeleteMeasurementCommand $command): Response
    {
        $this->deleteMeasurementHandler->__invoke($command);
        return new Response(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(name: 'get_measurements', methods: Request::METHOD_GET)]
    public function getMeasurements(GetMeasurementsQuery $query): JsonResponse
    {
        return new JsonResponse($this->getMeasurementsHandler->__invoke($query));
    }

    #[Route(path: '/{uuid}/download-original', name: 'download_original_measurement', methods: Request::METHOD_GET)]
    public function downloadOriginalMeasurementFile(DownloadOriginalMeasurementFileQuery $query): Response
    {
        return $this->downloadOriginalMeasurementFileHandler->__invoke($query);
    }
}
