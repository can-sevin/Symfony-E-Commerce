<?php

namespace App\Controller\Admin;

use App\Form\Admin\NameType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->render('admin/user/index.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/admin/user/new", name="admin_user_new",methods="GET|POST")
     */

    public function new(Request $request):Response
    {
        $user = new User();
        $form = $this->createForm(NameType::class, $user);
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('admin_user');
            }
        return $this->render('admin/user/create_form.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/user/edit/{id}", name="admin_user_edit",methods="GET|POST")
     */

    public function edit(Request $request,User $user):Response
    {
        $form = $this->createForm(NameType::class, $user);
        $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('admin_user');
            }
        return $this->render('admin/user/edit_form.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/user/delete/{id}", name="admin_user_delete",methods="GET|POST")
     */

    public function delete(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('admin_user');
    }
}
