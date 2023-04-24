<?php
use App\Models\BlogPost;
use App\Models\BlogPostLike;
use App\Models\Enums\BlogPostStatus;
use Tests\TestCase;
use Carbon\Carbon;

class BlogPostTest extends TestCase
{
	public function test_published_scope() 
	{
		BlogPost::factory()->create([
			'date' => '2023-06-01', 
			'status' => BlogPostStatus::PUBLISHED()
		]);

		$this->travelTo(Carbon::make('2023-01-01'));

		$this->assertEquals(0, BlogPost::query()->wherePublished()->count());
		
		$this->travelTo(Carbon::make('2023-06-02'));
		
		$this->assertEquals(1, BlogPost::query()->wherePublished()->count());

		BlogPost::factory()->create([
			'date' => '2022-06-01', 
			'status' => BlogPostStatus::PUBLISHED()
		]);

		$this->assertEquals(2, BlogPost::query()->wherePublished()->count());

		$this->travelTo(Carbon::make('2023-07-01'));
		$this->travel(-2)->weeks();
		$this->travelBack();
	}


	public function test_with_factories()
	{
			$post = BlogPost::factory()
					->has(BlogPostLike::factory()->count(5), 'postLikes')
					->create();

			$this->assertCount(5, $post->postLikes);

			$postLike = BlogPostLike::factory()
					->for(BlogPost::factory()->published())
					->create();

			$this->assertTrue($postLike->blogPost->isPublished());
	}
}