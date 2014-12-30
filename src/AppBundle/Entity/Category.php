<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CategoryRepository")
 * @ORM\Table(name="categories")
 */
class Category
{
    /**
     * Entity identifier.
     *
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", options={"unsigned"=true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Category name.
     *
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=64)
     *
     * @Assert\NotBlank()
     * @Assert\Length(max="64")
     */
    private $name;

    /**
     * Parent category. If none (if it is root category) - null.
     *
     * @var Category|null
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="childrenCategories")
     * @ORM\JoinColumn(name="parent_category_id", referencedColumnName="id", nullable=true, unique=false)
     */
    private $parentCategory;

    /**
     * Children categories.
     *
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parentCategory")
     */
    private $childrenCategories;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->parentCategory = null;
        $this->childrenCategories = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get parent category.
     *
     * @return Category
     */
    public function getParentCategory()
    {
        return $this->parentCategory;
    }

    /**
     * Set parent category.
     *
     * @param Category $parentCategory
     */
    public function setParentCategory($parentCategory)
    {
        $this->parentCategory = $parentCategory;
    }

    /**
     * Convert object to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get children categories.
     *
     * @return array
     */
    public function getChildrenCategories()
    {
        return $this->childrenCategories;
    }

    /**
     * Set children categories.
     *
     * @param array $childrenCategories
     */
    public function setChildrenCategories($childrenCategories)
    {
        $this->childrenCategories = $childrenCategories;
    }
}
