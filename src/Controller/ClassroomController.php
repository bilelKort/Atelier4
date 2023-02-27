<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    #[Route('/liste',name: 'classroomList')]
    public function list(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Classroom::class);
        $classrooms= $repo->findAll();
        return $this->render('classroom/list.html.twig',[
            'classrooms'  => $classrooms,
        ]);
    }
    #[Route('/addclassroom',name:'addclassroom')]
    public function addclassroom(Request $request)
    {
        $classroom = new Classroom();
        $form = $this->createForm(ClassroomType::class,$classroom);
        $form->add('Ajouter',SubmitType::class);
        
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();
            return $this->redirectToRoute('classroomList');
        }
        return $this->render("classroom/addclassroom.html.twig",array('form'=>$form->createView()));
    }
    #[Route('/update/{id}',name:'updateclassroom')]
    public function updateClassroom(Request $request,$id)
    {
        $classroom = $this->getDoctrine()->getRepository(Classroom::class)->find($id);
        $form = $this->createForm(ClassRoomType::class, $classroom);
        $form->add('modifier',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('classroomList');
        }
        return $this->render("classroom/update.html.twig",array('form'=>$form->createView()));
    }

    #[Route('/supprimer/{id}', name: 'd')]

    public function removeClassroom(ManagerRegistry $doctrine, Classroom $cl): Response
    {
        $repo=$doctrine->getRepository(Classroom::class);
        $repo->remove($cl,true);
        return $this->redirectToRoute("classroomList");
        //return new Response("deleted");
         
    }
}
