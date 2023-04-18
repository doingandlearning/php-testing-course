<?php

namespace Tests\Feature\Blog;

use App\Models\BlogPost;
use App\Models\Enums\BlogPostStatus;
use Tests\TestCase;

class BlogIndexTest extends TestCase
{
	public function test_index_shows_a_list_of_blog_posts()
	{
		# Arrange
		$this->withoutExceptionHandling();
		BlogPost::factory()
			->published()
			->count(2)
			->sequence(
				['title' => 'Thoughts on event sourcing', 'date' => '2023-04-18'],
				['title' => 'Fibers', 'date' => '2023-04-17'],
			)
			->create();

		BlogPost::factory()->create(['title' => 'Draft post', 'status' => BlogPostStatus::DRAFT()]);


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