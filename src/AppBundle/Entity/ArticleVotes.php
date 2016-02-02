<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="app_article_votes")
 */
class ArticleVotes
{
    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\Id
     * @ORM\JoinColumn(nullable=false)
     */
    public $user;

    /**
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\Id
     * @ORM\JoinColumn(onDelete="CASCADE", nullable=false)
     */
    public $article;

    /**
     * @ORM\Column(type="string", length=100)
     */
    public $type;

    /**
     * @var datetime $publishedAt
     *
     * @ORM\Column(name="votesAt", type="datetime")
     */
    public $votesAt;

    /**
     * votes constructor.
     */
    public function __construct()
    {
        $this->votesAt = new DateTime('now');
    }
}