<?php

declare(strict_types=1);

namespace App\Controller\Core;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class JsonController extends AbstractController
{
    #[Route('/json')]
    public function index(): Response
    {
        return $this->render('json/index.html.twig');
    }
}
