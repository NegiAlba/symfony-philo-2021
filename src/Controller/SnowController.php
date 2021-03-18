<?php

namespace App\Controller;

use App\Repository\SnowflakeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SnowController extends AbstractController
{
    /**
     * @Route("/random", name="app_random")
     */
    public function random(): Response
    {
        $number = random_int(0, 100);
        // dd($number); //? Signifie dump and die, donc fais un dumping de mon instruction et "tue" le script.

        return $this->render('snow/random.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/", name="app_index")
     */
    public function index(SnowflakeRepository $snowflakeRepository): Response
    {
        $snowflakes = $snowflakeRepository->findAll();

        // dd($snowflakes);

        return $this->render('snow/index.html.twig', [
            'snowflakes' => $snowflakes,
        ]);
    }
}
