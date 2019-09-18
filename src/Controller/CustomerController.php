<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class CustomerController extends AbstractController
{


    /**
     * @Route("/customer/add", name="customer")
     */
    public function add(Request $request)
    {


        $form = $this->createFormBuilder()
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('phone',TextType::class)
            ->add('address', TextType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
         //   var_dump($data);



            $session = new Session();
            // **Thong tin khach hang **
            //firstname
            $a= $session->set('name',$data['name'] );
            //lastname
           $b =  $session->set('email', $data['email'] );
            //email
            $c = $session->set('phone',$data['phone'] );
            // phone
            $d = $session->set('address', $data['address'] );






            $response = new RedirectResponse('/customer');
            $response->prepare($request);

            return $response->send();
        }
        return $this->render('customer/add.html.twig', [
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/customer", name="customer_view")
     */
    public function index()
    {

        if(!isset($session))
        {
            $session = new Session();
            // $session = new Session();

            $name = $session->get('name');
            $phone = $session->get('phone');
            $email = $session->get('email');
            $address = $session->get('address');

            $list = array(
                array($name,$email,$phone,$address)
            );

/*
            $length = count($list);
            for ($row = 0; $row < $length; $row++) {
                echo "<p><b>Row number $row</b></p>";
                echo "<ul>";
                for ($col = 0; $col < 4; $col++) {
                    echo "<li>".$list[$row][$col]."</li>";
                }
                echo "</ul>";
            }
*/

            return $this->render('customer/index.html.twig',['name'=>$name,'phone'=>$phone,'email'=>$email,'address'=>$address]);

        }
        else
        {


            $name = $phone = $email = $address = 'HELLO';
            return $this->render('customer/index.html.twig',['name'=>$name,'phone'=>$phone,'email'=>$email,'address'=>$address]);




        }

    }

}
