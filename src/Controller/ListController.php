<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractFOSRestController
{
    /**
     * @Route("/list", name="list")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ListController.php',
        ]);
    }

    /**
     * @Rest\Post("/update", name="app_update")
     */
    public function update()
    {
        return ['message' => 'update',];
    }


}
