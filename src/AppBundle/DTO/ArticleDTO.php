<?php

namespace AppBundle\DTO;


class ArticleDTO
{
    public $id;
    public $name;
    public $liked;
    public $dislike;
    public $description;
    public $publishedAt;
    public $category;
    public $user;
    public $commentsNumber;

    public function bind($article, $commentsNumber, $votesList) {
        $this->id = $article->id;
        $this->name = $article->name;
        $this->description = $article->description;
        $this->publishedAt = $article->publishedAt;
        $this->category = $article->category;
        $this->user = $article->user;
        $this->commentsNumber = $commentsNumber;

        $this->liked = 0;
        $this->dislike = 0;

        foreach($votesList as $vote) {
            if ($vote->type === 'Up') {
                $this->liked++;
            } else {
                $this->dislike++;
            }
        }
    }
}