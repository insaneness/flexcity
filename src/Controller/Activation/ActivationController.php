<?php

declare(strict_types=1);

namespace App\Controller\Activation;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ActivationController extends AbstractController
{
    #[Route('/activation')]
    public function index(): Response
    {
        return $this->render('activation/index.html.twig');
    }
}
