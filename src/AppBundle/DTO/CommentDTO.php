<?php
/**
 * Created by PhpStorm.
 * User: Malik
 * Date: 31/01/2016
 * Time: 21:16
 */

namespace AppBundle\DTO;


class CommentDTO
{
    public $id;
    public $name;
    public $liked;
    public $unliked;
    public $description;
    public $publishedAt;
    public $user;

    public function bind($comment, $votesList) {
        $this->id = $comment->id;
        $this->name = $comment->name;
        $this->description = $comment->description;
        $this->publishedAt = $comment->publishedAt;
        $this->user = $comment->user;

        $this->liked = 0;
        $this->unliked = 0;

        foreach($votesList as $vote) {
            if ($vote->type === 'Up') {
                $this->liked++;
            } else {
                $this->unliked++;
            }
        }
    }
}