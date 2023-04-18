<?php
use App\Models\BlogPost;
use App\Models\BlogPostLike;
use Tests\TestCase;

class BlogPostTest extends TestCase
{
	public function test_with_factories()
	{
		$post = BlogPost::factory()
			->has(BlogPostLike::factory()
				->has(User::factory(), 'author')
				->count(5), 'postLikes')
			->create();

		$this->assertCount(5, $post->postLikes);

		$postLike = BlogPostLike::factory()
			->for(BlogPost::factory()->published())
			->create();

		$this->assertTrue($postLike->blogPost->isPublished());
	}
}