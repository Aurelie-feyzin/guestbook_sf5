<?php


namespace App\Message;


class CommentMessage
{
    private $id;
    private $reviewUrl;
    private $context;


    public function __construct(int $id, string $reviewUrl, array $context = [])
    {
        $this->id = $id;
        $this->reviewUrl = $reviewUrl;
        $this->context = $context;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getReviewUrl()
    {
        return $this->reviewUrl;
    }

    public function getContext()
    {
        return $this->context;
    }
}