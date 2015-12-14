<?php

namespace AppBundle\Entity;

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
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $liked;

    /**
     * @ORM\Column(type="integer")
     */
    protected $unliked;

    /**
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var datetime $publishedAt
     *
     * @ORM\Column(name="publishedAt", type="datetime")
     */
    protected $publishedAt;

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->liked = 0;
        $this->unliked = 0;
        $this->publishedAt = new \DateTime(date('now'));
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLiked()
    {
        return $this->liked;
    }

    /**
     * @param mixed $liked
     */
    public function setLiked($liked)
    {
        $this->liked = $liked;
    }

    /**
     * @return mixed
     */
    public function getUnliked()
    {
        return $this->unliked;
    }

    /**
     * @param mixed $unliked
     */
    public function setUnliked($unliked)
    {
        $this->unliked = $unliked;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return date
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * @param date $publishedAt
     */
    public function setPublishedAt($publishedAt)
    {
        $this->publishedAt = $publishedAt;
    }


}