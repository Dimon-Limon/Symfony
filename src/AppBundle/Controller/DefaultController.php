<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageFileType;
use AppBundle\Form\ImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
class DefaultController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
            $session= new Session();
            $username=$request->get('name');
            $password=$request->get('passwod');
            $em=$this->getDoctrine()->getEntityManager();
            $repos=$em->getRepository('AppBundle:User');

            $user=$repos->findOneBy(array('name'=>$username,'passwod'=>$password));
            if($user){
                $session->set('name',$user->getname());
                $session->set('passwod',$user->getpasswod());
                $session->set('id',$user->getid());
            }

//        return $this->render('index.html.twig',['name'=>$username]);
            return $this->redirectToRoute('show');
    }
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $session= new Session();
        $username= $session->get('name');
        if($username){
            return $this->redirect('/show');
        }
        return $this->render('index.html.twig',['name'=>$username]);
    }
    /**
     * @Route("/show", name="show")
     */
    public function showAction(Request $request)
    {
        $session=new Session();
        $username=$session->get('name');
        if($username){
            $em=$this->getDoctrine()->getEntityManager();
            $repos= $em->getRepository('AppBundle:Image');
            $images =  $repos->findBy(array('userId'=> $session->get('id')));

            $image=new Image();
            $form=$this->createForm(ImageType::class,$image);
                $form->handleRequest($request);
                if($form->isSubmitted()){
                    $em=$this->getDoctrine()->getEntityManager();
                    $em->persist($image);
                    $em->flush();
                    $this->redirectToRoute('show');
                }
            return $this->render('galery/show.html.twig',['images'=>$images,'name'=>$username,'form'=>$form->createView()]);
        }else{
            return $this->redirect('/');
        }

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        $sessioon= new Session();
        $sessioon->clear();
        // replace this example code with whatever you need
        return $this->redirect('/');
    }

}
