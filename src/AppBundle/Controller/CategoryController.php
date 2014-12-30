<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\CategoryType;
use AppBundle\Helper\CategoryTreeHelper;
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

            return $this->redirect($this->generateUrl('home'));
        }

        $categories = $om->getRepository('AppBundle:Category')->findAllInArray();

        return $this->render(
            ':categories:index.html.twig',
            [
                'form'         => $form->createView(),
                'categoryTree' => CategoryTreeHelper::buildCategoryTree($categories)
            ]
        );
    }
}
