<?php
use App\Models\User;
use Tests\TestCase;


class PostPublishedTest extends TestCase {
	public function test_it_sends_an_email_to_owner_when_published() 
	{
		Mail::fake();
		$user = User::factory()->create();

		$this->markTestIncomplete();
	}
}