<?php
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\ExternalPostSuggestionController;
use Tests\TestCase;
use App\Models\ExternalPost;

class ExternalPostTest extends TestCase
{

	public function test_external_post_can_be_submitted()
	{
		$this->post(
			action(
				ExternalPostSuggestionController::class,
				['title' => 'My Awesome Title', 'url' => 'https://google.com']
			)
		)
			->assertRedirect(action([BlogPostController::class, 'index']))
			->assertSessionHas('laravel_flash_message', [
				'message' => 'Thanks for your suggestion.',
				'class' => 'bg-ink text-white',
				'level' => null
			]);

		$this->assertDatabaseHas(
			ExternalPost::class,
			['title' => 'My Awesome Title', 'url' => 'https://google.com']
		);
	}
}