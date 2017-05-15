<?php
/**
 * Created by PhpStorm.
 * User: Samuel
 * Date: 15/05/2017
 * Time: 14:50
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table
 */
class RecipeStep
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Recipe")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     */
    private $recipe;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Step")
     * @ORM\JoinColumn(name="step_id", referencedColumnName="id")
     */
    private $step;

    /**
     * @ORM\Column(type="integer")
     */
    private $rang;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipe = new \Doctrine\Common\Collections\ArrayCollection();
        $this->step = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set rang
     *
     * @param integer $rang
     *
     * @return RecipeStep
     */
    public function setRang($rang)
    {
        $this->rang = $rang;

        return $this;
    }

    /**
     * Get rang
     *
     * @return integer
     */
    public function getRang()
    {
        return $this->rang;
    }

    /**
     * Add recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return RecipeStep
     */
    public function addRecipe(\AppBundle\Entity\Recipe $recipe)
    {
        $this->recipe[] = $recipe;

        return $this;
    }

    /**
     * Remove recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     */
    public function removeRecipe(\AppBundle\Entity\Recipe $recipe)
    {
        $this->recipe->removeElement($recipe);
    }

    /**
     * Get recipe
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Add step
     *
     * @param \AppBundle\Entity\Step $step
     *
     * @return RecipeStep
     */
    public function addStep(\AppBundle\Entity\Step $step)
    {
        $this->step[] = $step;

        return $this;
    }

    /**
     * Remove step
     *
     * @param \AppBundle\Entity\Step $step
     */
    public function removeStep(\AppBundle\Entity\Step $step)
    {
        $this->step->removeElement($step);
    }

    /**
     * Get step
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set recipe
     *
     * @param \AppBundle\Entity\Recipe $recipe
     *
     * @return RecipeStep
     */
    public function setRecipe(\AppBundle\Entity\Recipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Set step
     *
     * @param \AppBundle\Entity\Step $step
     *
     * @return RecipeStep
     */
    public function setStep(\AppBundle\Entity\Step $step = null)
    {
        $this->step = $step;

        return $this;
    }
}
