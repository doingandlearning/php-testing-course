<?php

namespace App\Events;
use App\Models\BlogPost;

class PostPublished
{
    public BlogPost $post;
    public function __construct(BlogPost $post)
    {
        $this->post = $post;
    }
}
