<?php

namespace AppBundle\Tests\Helper;

use AppBundle\Helper\CategoryTreeHelper;

class CategoryTreeHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyBuildCategoryTree()
    {
        $this->assertEquals([], CategoryTreeHelper::buildCategoryTree([]));
    }

    public function testBadStructureBuildCategoryTree()
    {
        $categoryTree = [
            'id' => 1,
            'name' => 'test',
            'parent_category_id' => null
        ];

        $this->setExpectedException('Exception', 'Bad array structure');

        CategoryTreeHelper::buildCategoryTree($categoryTree);
    }

    public function testLevel1BuildCategoryTree()
    {
        $categoryTree = [
            [
                'id' => 1,
                'name' => 'test',
                'parent_category_id' => null
            ],
            [
                'id' => 2,
                'name' => 'test',
                'parent_category_id' => null
            ],
            [
                'id' => 3,
                'name' => 'test',
                'parent_category_id' => null
            ],
        ];

        $this->assertEquals($categoryTree, CategoryTreeHelper::buildCategoryTree($categoryTree));
    }

    public function testLevel2BuildCategoryTree()
    {
        $categoryTree = [
            [
                'id' => 1,
                'name' => 'test',
                'parent_category_id' => null
            ],
            [
                'id' => 2,
                'name' => 'test',
                'parent_category_id' => 1
            ],
            [
                'id' => 3,
                'name' => 'test',
                'parent_category_id' => null
            ],
            [
                'id' => 4,
                'name' => 'test',
                'parent_category_id' => null
            ],
            [
                'id' => 5,
                'name' => 'test',
                'parent_category_id' => 1
            ],
        ];

        $categoryTreeExpected = [
            [
                'id' => 1,
                'name' => 'test',
                'parent_category_id' => null,
                'children' => [
                    [
                        'id' => 2,
                        'name' => 'test',
                        'parent_category_id' => 1
                    ],
                    [
                        'id' => 5,
                        'name' => 'test',
                        'parent_category_id' => 1
                    ],
                ]
            ],
            [
                'id' => 3,
                'name' => 'test',
                'parent_category_id' => null
            ],
            [
                'id' => 4,
                'name' => 'test',
                'parent_category_id' => null
            ],
        ];

        $this->assertEquals($categoryTreeExpected, CategoryTreeHelper::buildCategoryTree($categoryTree));
    }

    public function testLevel3BuildCategoryTree()
    {
        $categoryTree = [
            [
                'id' => 1,
                'name' => 'test',
                'parent_category_id' => null
            ],
            [
                'id' => 2,
                'name' => 'test',
                'parent_category_id' => 1
            ],
            [
                'id' => 3,
                'name' => 'test',
                'parent_category_id' => null
            ],
            [
                'id' => 4,
                'name' => 'test',
                'parent_category_id' => null
            ],
            [
                'id' => 5,
                'name' => 'test',
                'parent_category_id' => 1
            ],
            [
                'id' => 6,
                'name' => 'test',
                'parent_category_id' => 1
            ],
            [
                'id' => 7,
                'name' => 'test',
                'parent_category_id' => 8
            ],
            [
                'id' => 8,
                'name' => 'test',
                'parent_category_id' => 1
            ],
            [
                'id' => 9,
                'name' => 'test',
                'parent_category_id' => 8
            ],
        ];

        $categoryTreeExpected = [
            [
                'id' => 1,
                'name' => 'test',
                'parent_category_id' => null,
                'children' => [
                    [
                        'id' => 2,
                        'name' => 'test',
                        'parent_category_id' => 1
                    ],
                    [
                        'id' => 5,
                        'name' => 'test',
                        'parent_category_id' => 1
                    ],
                    [
                        'id' => 6,
                        'name' => 'test',
                        'parent_category_id' => 1
                    ],
                    [
                        'id' => 8,
                        'name' => 'test',
                        'parent_category_id' => 1,
                        'children' => [
                            [
                                'id' => 7,
                                'name' => 'test',
                                'parent_category_id' => 8
                            ],
                            [
                                'id' => 9,
                                'name' => 'test',
                                'parent_category_id' => 8
                            ],
                        ],
                    ],
                ]
            ],
            [
                'id' => 3,
                'name' => 'test',
                'parent_category_id' => null
            ],
            [
                'id' => 4,
                'name' => 'test',
                'parent_category_id' => null
            ],
        ];

        $this->assertEquals($categoryTreeExpected, CategoryTreeHelper::buildCategoryTree($categoryTree));
    }
}
