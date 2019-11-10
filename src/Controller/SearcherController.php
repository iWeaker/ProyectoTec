<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearcherController extends AbstractController
{
    /**
     * @Route("/searcher" , name="search")
     * @param Request $request
     * @return Response
     */
    public function search() {
        $request = Request::createFromGlobals();
        $s = $request->query->get('s');
        return $this->render('searcher/index.html.twig' ,[
            's' => $s
        ]);
    }


}
