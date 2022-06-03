<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TwigController extends AbstractController
{
    #[Route('/twig', name: 'app_twig')]
    public function index(): Response
    {
        $var = "je suis la variable";
        $a = 12;
        $b = 5;
        $c = $a * $b;
        $tab = [1, 2, 3, 4, 5];
        $currDate = new DateTime();

        return $this->render('twig/twig.html.twig', [
            "text" => $var,
            "result" => $c,
            "direct" => 159,
            "tableau" => $tab,
            "date_jour" => $currDate,
        ]);
    }

    #[Route('/twig-tableau', name: 'app_twig_tableau')]
    public function twigTableau(): Response
    {
        $tab = ["banane", "pomme", "poire", "mangue"];
        $users = [
            ["name" => "bill", "prenom" => "gates"],
            ["name" => "steve", "prenom" => "jobs"],
            ["name" => "jean", "prenom" => "castex"]
        ];
        return $this->render('twig/twig_tableau.html.twig', [
            "fruits" => $tab,
            "users" => $users
        ]);
    }
}
