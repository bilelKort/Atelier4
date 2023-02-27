<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
class StudentController extends AbstractController
{
    public function index()
    {
        return new Response('<h1> Bonjour mes étudiants <h1>');
    }
}



?>