<?php

namespace App\Controller;

use App\Entity\User;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListUsersController extends AbstractController
{
    /**
     * @Route("/gestion/listUsers", name="list_users")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {

        //TODO Récup la liste des administrés et l'envoyer!

        $listUsers = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        $pageNumber = $request->query->getInt('page', 1);

        $usersPaginated = $paginator->paginate(
            $listUsers,
            $pageNumber,
            8
        );

        return $this->render('list_users/index.html.twig', [
            'title' => 'Liste des moutons',
            'listUsers' => $usersPaginated
        ]);
    }
}
