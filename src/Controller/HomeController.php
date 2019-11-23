<?php

namespace App\Controller;

use App\Entity\Admin\Messages;
use App\Entity\User;
use App\Form\Admin\MessagesType;
use App\Form\UserType;
use App\Repository\Admin\CategoryRepository;
use App\Repository\Admin\ProductRepository;
use App\Repository\Admin\SettingRepository;
use App\Repository\Admin\ImageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(SettingRepository $settingRepository,CategoryRepository $categoryRepository)
    {
        $data = $settingRepository->findAll();
        $em = $this->getDoctrine()->getManager();
        $sql="SELECT * FROM product WHERE status='True' ORDER BY id DESC LIMIT 5";
        $statement = $em->getConnection()->prepare($sql);

        $p = $this->getDoctrine()->getManager();
        $psql = "SELECT * FROM product WHERE status='True' ORDER BY RAND() LIMIT 8";
        $products = $p->getConnection()->prepare($psql);
        $products->execute();
        $result = $products->fetchAll();

        //$statement->bindValue('parent_id',$parent);

        $statement->execute();
        $sliders=$statement->fetchAll();
        $cats = $this->fetchCategoryTreeList();

        return $this->render('home/index.html.twig', [
            'data' => $data,
            'cats' => $cats,
            'products'=>$result,
            'sliders' => $sliders,
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/hakkimizda", name="hakkimizda")
     */
    public function hakkimizda(SettingRepository $settingRepository)
    {
        $data = $settingRepository->findAll();
        $cats = $this->fetchCategoryTreeList();

        return $this->render('home/hakkimizda.html.twig', [
            'data' => $data,
            'cats' => $cats,
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/referanslar", name="referanslar")
     */
    public function referanslar(SettingRepository $settingRepository)
    {
        $cats = $this->fetchCategoryTreeList();
        $data = $settingRepository->findAll();

        return $this->render('home/referanslar.html.twig', [
            'data' => $data,
            'cats' => $cats,
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/iletisim", name="iletisim",methods="GET|POST")
     */
    public function iletisim (SettingRepository $settingRepository,Request $request)
    {
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        $submittedToken = $request->request->get('token');

        if($form->isSubmitted()) {
            if ($this->isCsrfTokenValid('form-message', $submittedToken)) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();

                return $this->redirectToRoute('iletisim');
            }
        }

        $data = $settingRepository->findAll();
        $cats = $this->fetchCategoryTreeList();

        return $this->render('home/iletisim.html.twig', [
            'data' => $data,
            'cats' => $cats,
            'message' => $message,
            'controller_name' => 'HomeController',
        ]);
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
                $user_tree_array[] = "<a href='/kategori/".$row['id']."'>".$row['title']."</a>";
                $user_tree_array[]="<ul>";
                $user_tree_array = $this->fetchCategoryTreeList($row['id'],$user_tree_array);
                $user_tree_array[]="</ul>";
            }
        }
        return $user_tree_array;
    }

    /**
     * @Route("/kategori/{catid}", name="kategori", methods="GET")
     */
    public function CategoryProducts($catid,CategoryRepository $categoryRepository)
    {
        $cats = $this->fetchCategoryTreeList();
        $data = $categoryRepository->findBy(
            ['id' => $catid]
        );

        $em = $this->getDoctrine()->getManager();
        $sql = 'SELECT * FROM product WHERE status="True" AND kategori_id = :catid';
        $statement = $em->getConnection()->prepare($sql);
        $statement->bindValue('catid',$catid);
        $statement->execute();
        $result = $statement->fetchAll();

        return $this->render('home/urunler.html.twig', [
            'data' => $data,
            'products' => $result,
            'cats' => $cats,
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/product/{id}", name="product_detail", methods="GET")
     */
    public function ProductsDetail($id,ProductRepository $productRepository,ImageRepository $imageRepository)
    {
        $images = $imageRepository->findBy(
            ['product_id' => $id]
        );

        $data = $productRepository->findBy(
            ['id' => $id]
        );
        $cats = $this->fetchCategoryTreeList();

        return $this->render('home/product_detail.html.twig', [
            'images' => $images,
            'data' => $data,
            'cats' => $cats,
            'controller_name' => 'HomeController',
        ]);
    }


    /**
     * @Route("/newuser", name="newuser",methods="GET|POST")
     */
    public function newuser (Request $request,UserRepository $userRepository):Response
    {
        $user = new User();
        $cats = $this->fetchCategoryTreeList();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        $submittedToken = $request->request->get('token');
        if ($this->isCsrfTokenValid('user', $submittedToken)) {
        if($form->isSubmitted()) {
                $emaildata=$userRepository->findBy(
                      ['email' => $user->getEmail()]
                );
                if($emaildata==null) {
                    $em = $this->getDoctrine()->getManager();
                    $user->setRoles("ROLE_USER");
                    $user->setStatus("True");
                    $em->persist($user);
                    $em->flush();
                    return $this->redirectToRoute('app_login');
                }else{
                    echo "Mail daha önceden kayıtlı";
                    return $this->render('home/newuser.html.twig',[
                        'form' => $form->createView(),
                        'user' => $user,
                        'cats' => $cats,
                    ]);
                }
        }
        }
        return $this->render('home/newuser.html.twig',[
            'form' => $form->createView(),
            'user' => $user,
            'cats' => $cats,
        ]);
    }


}
