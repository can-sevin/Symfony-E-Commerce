<?php

namespace App\Controller;

use App\Entity\ShopCart;
use App\Form\ShopCartType;
use App\Repository\ShopCartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/shopcart")
 */
class ShopCartController extends AbstractController
{
    /**
     * @Route("/", name="shop_cart_index", methods="GET")
     */
    public function index(ShopCartRepository $shopCartRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        $cats = $this->fetchCategoryTreeList();

        $em = $this->getDoctrine()->getManager();
        $sql="SELECT p.title,p.sprice,s.*
        FROM shop_cart s,product p WHERE s.productid = p.id AND userid= :userid";

        $statement = $em->getConnection()->prepare($sql);
        $statement->bindValue('userid',$user->getid());
        $statement->execute();
        $shopcarts=$statement->fetchAll();

        return $this->render('shop_cart/index.html.twig', ['shopcarts' => $shopcarts,'cats' => $cats]);
    }

    /**
     * @Route("/new", name="shop_cart_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $shopCart = new ShopCart();
        $form = $this->createForm(ShopCartType::class, $shopCart);
        $form->handleRequest($request);
        $cats = $this->fetchCategoryTreeList();

        $submmittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('add-item', $submmittedToken)) {

            if ($form->isSubmitted()) {

                $em = $this->getDoctrine()->getManager();
                $user = $this->getUser();
                //$shopCart->setQuantity($request->request->get('quantity'));
                $shopCart->setUserid($user->getid());

                $em->persist($shopCart);
                $em->flush();

                return $this->redirectToRoute('shop_cart_index');
            }
        }
        return $this->render('shop_cart/new.html.twig', [
            'shopcart' => $shopCart,
            'cats' => $cats,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/{id}", name="shop_cart_show", methods="GET")
     */
    public function show(ShopCart $shopCart): Response
    {
        $cats = $this->fetchCategoryTreeList();
        return $this->render('shop_cart/show.html.twig', ['shopcart' => $shopCart]);
    }

    /**
     * @Route("/{id}/edit", name="shop_cart_edit", methods="GET|POST")
     */
    public function edit(Request $request, ShopCart $shopCart): Response
    {
        $cats = $this->fetchCategoryTreeList();
        $form = $this->createForm(ShopCartType::class, $shopCart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('shop_cart_edit', ['id' => $shopCart->getId()]);
        }

        return $this->render('shop_cart/edit.html.twig', [
            'shopcart' => $shopCart,
            'form' => $form->createView(),
            'cats' => $cats,
        ]);
    }

    /**
     * @Route("/{id}/del", name="shop_cart_del", methods="GET|POST")
     */
    public function del(Request $request, ShopCart $shopCart): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($shopCart);
        $em->flush();

        return $this->redirectToRoute('shop_cart_index');

    }
        /**
     * @Route("/{id}", name="shop_cart_delete", methods="DELETE")
     */
    public function delete(Request $request, ShopCart $shopCart): Response
    {
        if($this->isCsrfTokenValid('delete'.$shopCart->getId(),$request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($shopCart);
            $em->flush();
        }
        return $this->redirectToRoute('shop_cart_index');
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
