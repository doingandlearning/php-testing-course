<?php
use App\Http\Controllers\BlogPostAdminController;
use App\Models\BlogPost;
use App\Models\User;
use Tests\TestCase;

class BlogAdminControllerTest extends TestCase
{
	public function test_only_a_logged_in_user_can_make_changes_to_a_post()
	{
		$blogPost = BlogPost::factory()->create();

		$sendRequest = fn() => $this->post(
			action([BlogPostAdminController::class, 'update'], $blogPost->slug),
			[
				'title' => 'My new title',
				'author' => $blogPost->author,
				'body' => $blogPost->body,
				'date' => $blogPost->date->format('Y-m-d')
			]
			);

		$sendRequest()->assertRedirect(route('login'));

		$this->assertNotEquals($blogPost->refresh()->title, 'My new title');

		$this->login();
		// $this->actingAs(User::factory()->create());

		$sendRequest()->assertRedirect(action([BlogPostAdminController::class, 'edit'], $blogPost->slug));

		$this->assertEquals($blogPost->refresh()->title, 'My new title');
	}
}