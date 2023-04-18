<?php

namespace Tests\Feature\Blog;
use App\Models\BlogPost;
use App\Models\Enums\BlogPostStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogIndexTest extends TestCase
{
	use RefreshDatabase;
	public function test_index_shows_a_list_of_blog_posts()
	{
		# Arrange
		$this->withoutExceptionHandling();

		BlogPost::create([
			'title' => 'Thoughts on event sourcing',
			'date' => '2023-04-18',
			'body' => 'Really interesting blog post',
			'author' => 'Kevin',
			'status' => BlogPostStatus::PUBLISHED()
		]);

		BlogPost::create([
			'title' => 'Fibers',
			'date' => '2023-04-17',
			'body' => 'Really interesting blog post',
			'author' => 'Kevin',
			'status' => BlogPostStatus::PUBLISHED()
		]);

		BlogPost::create([
			'title' => 'Draft post',
			'date' => '2023-04-17',
			'body' => 'Really interesting blog post',
			'author' => 'Kevin'
		]);

		# Act
		# Assert
		$this
		->get('/')
		->assertSee('Thoughts on event sourcing')
		->assertSeeInOrder([
				'Thoughts on event sourcing',
				'Fibers',
		])->assertSuccessful()
		->assertDontSee('Draft post');
		
	}
}