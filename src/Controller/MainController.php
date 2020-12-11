<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/")
*/
class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'Mon Grand Fou',
        ]);
    }

    /**
     * @Route("/search/{query<\d*>}", name="search" , priority=5)
     * @IsGranted("ROLE_USER")
     */
    public function search(int $query = 1): Response
    {
        return $this->render('main/search.html.twig', [
            'query' => $query
        ]);
    }

    /**
     * @Route("/search/22", name="search22")
     */
    public function search22(): Response
    {
        return $this->render('main/search.html.twig', [
            'query' => 42
        ]);
    }
}
