<?php

namespace AppBundle\Helper;

class CategoryTreeHelper
{
    /**
     * Build a nested array of categories from a flat array list.
     *
     * @param array $categories
     *
     * @return array
     *
     * @throws \Exception
     */
    public static function buildCategoryTree(array $categories)
    {
        $children = [];
        $categoryTree = [];

        foreach($categories as &$category) {
            if (!isset($category['id'])) {
                throw new \Exception('Bad array structure');
            }

            if (empty($category['parent_category_id'])) {
                $categoryTree[] = &$category;
            } else {
                $children[$category['parent_category_id']][] = &$category;
            }
        }

        foreach($categories as &$category) {
            if (isset($children[$category['id']])) {
                $category['children'] = $children[$category['id']];
            }
        }

        return $categoryTree;
    }
} 
