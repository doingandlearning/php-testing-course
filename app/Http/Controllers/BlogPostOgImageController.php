<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogPostOgImageController
{
    public function __invoke(BlogPost $post)
    {
        return view('blog.ogImage', ['post' => $post]);
    }
}
