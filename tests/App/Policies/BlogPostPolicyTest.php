<?php
use App\Http\Controllers\BlogPostAdminController;
use App\Http\Controllers\DeletePostController;
use App\Http\Controllers\UpdatePostSlugController;
use App\Models\BlogPost;
use App\Models\User;
use Tests\TestCase;

class BlogPostPolicyTest extends TestCase
{
	private BlogPost $post;

	public function setUp(): void
	{
		parent::setUp();
		$this->post = BlogPost::factory()->create();
	}

	/**
	 * @test
	 * @dataProvider request
	 */
	public function test_guests_are_not_allowed(Closure $sendRequest)
	{
		$this->login(User::factory()->guest()->create());
		/** @var \Illuminate\Testing\TestResponse $response */
		$response = $sendRequest->call($this, $this->post);
		$response->assertForbidden();
	}

	/**
	 * @dataProvider request
	 */
	public function test_unlogged_in_users_are_redirected_to_login(Closure $sendRequest)
	{
		/** @var \Illuminate\Testing\TestResponse $response */
		$response = $sendRequest->call($this, $this->post);
		$response->assertRedirect('/login');
	}

	/**
	 * @dataProvider request
	 */
	public function test_admin_user_can_access_route(Closure $sendRequest) 
	{
		$this->login(User::factory()->admin()->create());
		
		/** @var \Illuminate\Testing\TestResponse $response */
		$response = $sendRequest->call($this, $this->post);
		$this->assertTrue(in_array($response->status(), [ 200, 302]));
	}

	public function request(): Generator
	{
		yield	[fn(BlogPost $post) => $this->get(action([BlogPostAdminController::class, 'index']))];
		yield	[fn(BlogPost $post) => $this->get(action([BlogPostAdminController::class, 'create']))];
		yield	[fn(BlogPost $post) => $this->post(action([BlogPostAdminController::class, 'store']))];
		yield	[fn(BlogPost $post) => $this->get(action([BlogPostAdminController::class, 'edit'], $post->slug))];
		yield	[fn(BlogPost $post) => $this->post(action([BlogPostAdminController::class, 'update'], $post->slug))];
		yield	[fn(BlogPost $post) => $this->post(action([BlogPostAdminController::class, 'publish'], $post->slug))];
		yield	[fn(BlogPost $post) => $this->post(action([DeletePostController::class], $post->slug))];
		yield	[fn(BlogPost $post) => $this->post(action([UpdatePostSlugController::class], $post->slug))];
	}
}