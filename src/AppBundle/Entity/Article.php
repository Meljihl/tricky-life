<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="app_article")
 */
class Article
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public $name;

    /**
     * @ORM\Column(type="integer")
     */
    public $liked;

    /**
     * @ORM\Column(type="integer")
     */
    public $dislike;

    /**
     * @ORM\Column(type="text")
     */
    public $description;

    /**
     * @var datetime $publishedAt
     *
     * @ORM\Column(name="publishedAt", type="datetime")
     */
    public $publishedAt;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(nullable=true)
     */
    public $category;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=true)
     */
    public $user;

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->liked = 0;
        $this->dislike = 0;
        $this->publishedAt = new DateTime('now');
    }
}