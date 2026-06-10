<?php

namespace App\Controller;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ItemController extends AbstractController
{
    #[Route('/items/', name: 'items_list', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $data =  [];
        return $this->json($data, 200);
    }

    #[Route('/item/create', name: 'items_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $item = new Item();
        $item->setName($data['name'] ?? null);
        $item->setContent($data['content'] ?? null);
        $item->setCreatedAt(new \DateTimeImmutable());

//        $em->persist($item);
//        $em->flush();

        return $this->json([
            'id' => $item->getId() ?? null,
            'name' => $item->getName(),
            'content' => $item->getContent(),
        ], 201);
    }
}
