<?php
use App\Models\BlogPost;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LastSeenTest extends TestCase 
{

	public function test_last_seen()
	{
		$post = BlogPost::factory()->create();

		$this->travelTo(Carbon::make("2023-01-01"));

		$this->blade('<x-last-seen :post="$post" />', ['post' => $post])
		  ->assertDontSee("Last seen on")
			->assertDontSee("2023-01-01");

		app(Request::class)->cookies->set("last_seen_{$post->slug}", now()->toDateTimeString());

		$this->blade('<x-last-seen :post="$post" />', ['post' => $post])
		  ->assertSee("Last seen on")
			->assertSee("2023-01-01");

	}
}