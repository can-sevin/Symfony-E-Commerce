<?php

namespace App\Controller\UserPanel;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/userpanel")
 */
class UserPanelController extends AbstractController
{
    /**
     * @Route("/", name="userpanel")
     */
    public function index()
    {
        return $this->redirectToRoute('userpanel_show');
    }

    /**
     * @Route("/edit", name="userpanel_edit",methods="GET|POST")
     */

    public function edit(Request $request):Response
    {
        $usersession =$this->getUser();

        $user = $this->getDoctrine()->getRepository(User::class)
            ->find($usersession->getid());

        $cats = $this->fetchCategoryTreeList();
        if($request->isMethod('POST')) {
            $submittedToken = $request->request->get('token');
            if ($this->isCsrfTokenValid('user-form', $submittedToken)) {
                $user->setName($request->request->get("name"));
                $user->setPassword($request->request->get("password"));
                $user->setAddress($request->request->get("address"));
                $user->setCity($request->request->get("city"));
                $user->setPhone($request->request->get("phone"));
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('userpanel_show');
            }
        }
        return $this->render('user_panel/edit.html.twig',['user' => $user,'cats' => $cats]);
    }

    /**
     * @Route("/show", name="userpanel_show",methods="GET")
     */

    public function show(){
        $cats = $this->fetchCategoryTreeList();
        return $this->render('user_panel/show.html.twig',['cats' => $cats]);
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
                $user_tree_array[] = "<a href='kategori/".$row['id']."'>".$row['title']."</a>";
                $user_tree_array[]="<ul>";
                $user_tree_array = $this->fetchCategoryTreeList($row['id'],$user_tree_array);
                $user_tree_array[]="</ul>";
            }
        }
        return $user_tree_array;
    }

}
