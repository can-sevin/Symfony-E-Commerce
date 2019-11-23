<?php

namespace App\Controller;

use App\Repository\Admin\SettingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils,SettingRepository $settingRepository): Response
    {
        $cats = $this->fetchCategoryTreeList();
        $data=$settingRepository -> findAll();
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'data' => $data,
            'cats' => $cats,
            'error' => $error]);
    }

    /**
     * @Route("/loginerror", name="app_login_error")
     */
    public function loginerror(AuthenticationUtils $authenticationUtils,SettingRepository $settingRepository): Response
    {
        $cats = $this->fetchCategoryTreeList();
        $data=$settingRepository -> findAll();
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'data' => $data,
            'cats' => $cats,
            'error' => $error]);
    }

    public function fetchCategoryTreeList($parent =0,$user_tree_array = '')
    {
        if(!is_array($user_tree_array))
            $user_tree_array = array();
        $em = $this->getDoctrine()->getManager();
        $sql = "SELECT * FROM category WHERE status='True' AND parent_id=".$parent;
        $statement = $em->getConnection()->prepare($sql);
        // $statement->bindValue('parentid',$parent);
        $statement->execute();
        $result = $statement->fetchAll();

        if(count($result) > 0){
            foreach($result as $row){
                $user_tree_array[] = "<a href='category/".$row['id']."'>".$row['title']."</a>";
                $user_tree_array[]="<ul>";
                $user_tree_array = $this->fetchCategoryTreeList($row['id'],$user_tree_array);
                $user_tree_array[]="</ul>";
            }
        }
        return $user_tree_array;
    }

}
