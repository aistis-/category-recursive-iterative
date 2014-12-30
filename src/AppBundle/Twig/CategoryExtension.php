<?php

namespace AppBundle\Twig;

class CategoryExtension extends \Twig_Extension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('categoryRecursively', array($this, 'categoryRecursivelyFunction')),
            new \Twig_SimpleFunction('categoryIteratively', array($this, 'categoryIterativelyFunction')),
        );
    }

    /**
     * Print categories tree recursively.
     *
     * @param array $categoryTree
     *
     * @return string
     */
    public function categoryRecursivelyFunction(array $categoryTree)
    {
        $output = '';

        if (0 < count($categoryTree)) {

            $output .= '<ul>';

            foreach ($categoryTree as $category) {
                $output .= '<li>';
                $output .= htmlspecialchars($category['name']);
                $output .= '</li>';

                if (isset($category['children'])) {
                    $output .= $this->categoryRecursivelyFunction($category['children']);
                }
            }

            $output .= '</ul>';
        }

        return $output;
    }

    /**
     * Print categories tree iteratively using a stack.
     *
     * @param array $categoryTree
     *
     * @return string
     */
    public function categoryIterativelyFunction(array $categoryTree)
    {
        $output = '';

        $stack = [];

        foreach ($categoryTree as $category) {
            array_push($stack, $category);
        }

        $stack = array_reverse($stack);

        $output .= '<ul>';

        while (0 < count($stack)) {

            $category = array_pop($stack);

            if (false === $category) {
                $output .= '</ul>';

                continue;
            }

            $output .= '<li>';
            $output .= htmlspecialchars($category['name']);
            $output .= '</li>';

            if (isset($category['children'])) {
                $output .= '<ul>';

                array_push($stack, false);

                $category['children'] = array_reverse($category['children']);

                foreach ($category['children'] as $childCategory) {
                    array_push($stack, $childCategory);
                }
            }
        }

        $output .= '</ul>';

        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'category_extension';
    }
}
