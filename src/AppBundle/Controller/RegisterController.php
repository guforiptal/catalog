<?php

namespace AppBundle\Controller;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{
    /**
     * @Route("/registration", name="registration")
     */
    public function registerAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirectToRoute('catalog');
        }
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        $authenticationUtils = $this->get('security.authentication_utils');

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoleUser();

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('main');
        }

        return $this->render('registration.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $form->getErrors(true),
            'form' => $form->createView(),
        ));


    }

    /**
     * @Route("/register", name="register")
     */
    public function registeRedirect()
    {
        return $this->redirectToRoute('registration');
    }
}