<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController

{
    #[Route('/api')]
    public function apiDocAction()
    {
        return new Response('Api Controller in action');
    }
}