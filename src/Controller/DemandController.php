<?php

namespace App\Controller;

use App\Entity\Demand;
use App\Repository\DemandRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemandController extends AbstractController
{
    /**
     * @Route("/demand", name="demand")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();
        $demands = $user->getDemands();


        $pageNumber = $request->query->getInt('page', 1);

        $demandsPaginated = $paginator->paginate(
            $demands,
            $pageNumber,
            4
        );

        return $this->render('demand/index.html.twig', [
            'title' => 'Faire une demande',
            'demandCreated' => false,
            'demands' => $demandsPaginated,
            'allDemands' => $demands
        ]);
    }


    /**
     * @Route("/demand/validate", name="demand_validate")
     */
    public function validate(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $demand = new Demand();
        $demand->setUser($this->getUser());
        $demand->setDate(new \DateTime());
        $demand->setAcceptation(false);

        $entityManager->persist($demand);
        $entityManager->flush();

        return $this->render('demand/index.html.twig', [
            'title' => 'Demande faite',
            'demandCreated' => true
        ]);
    }
}
