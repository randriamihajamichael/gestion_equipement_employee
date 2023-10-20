<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EquipmentsRepository;
use App\Repository\EmployeeRepository;
use App\Entity\Equipments;
use App\Entity\Employee;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class EquipmentController extends AbstractController
{

    public function listesEquipments(EquipmentsRepository $equipmentsRepository, SerializerInterface $serializer): JsonResponse
    {
        $listesEquipment = $equipmentsRepository->findAll();

        $jsonEquipmentList = $serializer->serialize($listesEquipment, 'json', ['groups' => 'getEquipments']);
        return new JsonResponse($jsonEquipmentList, Response::HTTP_OK, [], true);
    }

    public function getDetailEquipment(int $id, SerializerInterface $serializer, EquipmentsRepository $equipmentsRepository): JsonResponse {

        if ($id) {
            $equipment = $equipmentsRepository->find($id);

            $jsonEquipment = $serializer->serialize($equipment, 'json',  ['groups' => 'getEquipments']);
            return new JsonResponse($jsonEquipment, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    public function createEquipment(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, EmployeeRepository $mployeeRepository): JsonResponse
    {

        $equipment = $serializer->deserialize($request->getContent(), Equipments::class, 'json');

        $content = $request->toArray();


        $idEmployee = $content['employee_id'] ?? -1;

        $equipment->setEmployee($mployeeRepository->find($idEmployee));


        $em->persist($equipment);
        $em->flush();
        $jsonEquipment = $serializer->serialize($equipment, 'json', ['groups' => 'getEquipments']);


        return new JsonResponse($jsonEquipment, Response::HTTP_CREATED,[],true);
    }


    //...
    #[Route('/api/books/{id}', name:"updateBook", methods:['PUT'])]

    public function updateEquipment(Request $request, SerializerInterface $serializer, Equipments $equipments, EntityManagerInterface $em, EmployeeRepository $employeeRepository): JsonResponse
    {
        $updatedBook = $serializer->deserialize($request->getContent(),
            Equipments::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $equipments]);
        $content = $request->toArray();
        $idEmployee = $content['employee_id'] ?? -1;
        $updatedBook->setEmployee($employeeRepository->find($idEmployee));

        $em->persist($updatedBook);
        $em->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

    public function deleteEquipment(int $id, SerializerInterface $serializer, EquipmentsRepository $equipmentsRepository): JsonResponse
    {

        if ($id) {
            $equipmentsRepository->deleteEquipment($id);
            return new JsonResponse(null, Response::HTTP_NO_CONTENT);
        }
        return new JsonResponse(null, Response::HTTP_OK);
    }


}
