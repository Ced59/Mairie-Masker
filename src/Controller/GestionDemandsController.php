<?php

namespace App\Controller;

use App\Entity\Demand;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionDemandsController extends AbstractController
{
    /**
     * @Route("/gestion/demands", name="gestion_demands")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $demands = $this->getDoctrine()
            ->getRepository(Demand::class)
            ->findBy(
                ['acceptation' => false],
                ['date' => 'ASC']
            );;

        $pageNumber = $request->query->getInt('page', 1);

        $demandsPaginated = $paginator->paginate(
            $demands,
            $pageNumber,
            8
        );


        return $this->render('gestion_demands/index.html.twig', [
            'demands' => $demandsPaginated,
            'demandValidated' => null
        ]);
    }

    /**
     * @Route("/gestion/demands/validated/{idValidated}", name="gestion_demands_validated")
     * @param int $idValidated
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function indexValidated(int $idValidated, PaginatorInterface $paginator, Request $request): Response
    {
        $repositoryDemands = $this->getDoctrine()->getRepository(Demand::class);

        $demands = $repositoryDemands->findBy(
            ['acceptation' => false],
            ['date' => 'ASC']
        );

        $demandValidated = $repositoryDemands->find($idValidated);

        $demandsPaginated = $paginator->paginate(
            $demands,
            $request->query->getInt('page', 1),
            8
        );

        return $this->render('gestion_demands/index.html.twig', [
            'demands' => $demandsPaginated,
            'demandValidated' => $demandValidated
        ]);
    }

    /**
     * @Route("/gestion/demands/{id}", name="gestion_demands_validate")
     * @param int $id
     * @return RedirectResponse
     */
    public function validate(int $id): RedirectResponse
    {
        $demand = $this->getDoctrine()->getRepository(Demand::class)->find($id);

        $demand->setAcceptation(true);


        $demandsManager = $this->getDoctrine()->getManager();
        $demandsManager->persist($demand);
        $demandsManager->flush();


        return $this->redirectToRoute("gestion_demands_validated", ['idValidated' => $demand->getId()]);
    }
}
