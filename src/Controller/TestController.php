<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    #[Route('/index')]
    public function index(){
        return new Response("hello world");
    }

    #[Route('/name/{name}')]
    public function test(string $name){
        return $this->render("test/test.html.twig",["name" => $name]);
    }
}