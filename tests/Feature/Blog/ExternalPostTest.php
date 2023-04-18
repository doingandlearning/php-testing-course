<?php
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\ExternalPostSuggestionController;
use App\Mail\ExternalPostSuggestedMail;
use App\Models\User;
use Tests\TestCase;
use App\Models\ExternalPost;

class ExternalPostTest extends TestCase
{

	public function test_external_post_can_be_submitted()
	{
		Mail::fake();

		$user = User::factory()->create();

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

		
		// $this->assertTrue($passenger->refresh()->has('voucher'));

		Mail::assertSent(function (ExternalPostSuggestedMail $mail) use ($user) {
			return $mail->to[0]['address'] === $user->email;
		});

		

		// Bus::fake(['']);
		// Event::fake();
		// Http::fake();
		// Notification::fake();
		// Queue::fake();
		// Storage::fake();
	}
}