<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="app_comment")
 */
class Comment
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
     * @ORM\ManyToOne(targetEntity="Article", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    public $article;

    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=true)
     */
    public $user;

    /**
     * @ORM\Column(type="integer")
     */
    public $unliked;

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
     * Comment constructor.
     */
    public function __construct()
    {
        $this->liked = 0;
        $this->unliked = 0;
        $this->publishedAt = new DateTime('now');
    }
}