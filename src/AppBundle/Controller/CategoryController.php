<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\CategoryType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Category controller.
 */
class CategoryController extends Controller
{
    /**
     * Index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {
        $om = $this->getDoctrine()->getManager();

        $form = $this->createForm(new CategoryType());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $om->persist($form->getData());
            $om->flush();
        }

        $categories = $om->getRepository('AppBundle:Category')->findAllInArray();

        ///// This should be in service/helper/util etc. ///////////////////////////
        $children = [];
        $categoriesTree = [];

        foreach($categories as &$category) {
            if (null === $category['parent_category_id']) {
                $categoriesTree[] = &$category;
            } else {
                $children[$category['parent_category_id']][] = &$category;
            }
        }

        foreach($categories as &$category) {
            if (isset($children[$category['id']])) {
                $category['children'] = $children[$category['id']];
            }
        }
        ////////////////////////////////////////////////////////////////////////////

        return $this->render(
            ':categories:index.html.twig',
            [
                'form'       => $form->createView(),
                'categories' => $categoriesTree
            ]
        );
    }
}
