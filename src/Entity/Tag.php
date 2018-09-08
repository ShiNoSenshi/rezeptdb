<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tags")
 */
class Tag {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=100)
	 */
	private $label;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Recipe", mappedBy="tags"))
	 */
	private $recipes;

	public function getId() {
		return $this->id;
	}

	public function getLabel(): ?string {
		return $this->label;
	}

	public function setLabel(string $label): self {
		$this->label = $label;

		return $this;
	}

	/**
	 * @return Recipe[]|ArrayCollection
	 */
	public function getRecipes() {
		return $this->recipes;
	}

	/**
	 * @param Recipe[]|ArrayCollection $recipes
	 */
	public function setRecipes($recipes): void {
		$this->recipes = $recipes;
	}

}
