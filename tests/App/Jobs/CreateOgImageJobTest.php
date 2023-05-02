<?php

use App\Jobs\CreateOgImageJob;
use App\Models\BlogPost;
use Tests\TestCase;
use Illuminate\Bus\Dispatcher;

class CreateOgImageJobTest extends TestCase 
{
	public function test_job_is_dispatched_correctly() {
		# Create post triggers the job
		Bus::fake();
		$post = BlogPost::factory()->create();
		Bus::assertDispatched(CreateOgImageJob::class);

		# Update title triggers the job
		Bus::fake();
		$post->fresh()->update(['title' => 'New Title']);
		Bus::assertDispatched(CreateOgImageJob::class);
		
		# Update date doesn't trigger the job
		Bus::fake();
		$post->fresh()->update(['date' => '2023-01-01']);
		Bus::assertNotDispatched(CreateOgImageJob::class);
	}

	public function test_file_is_generated_correctly() {
		Bus::swap(app(Dispatcher::class));

		Storage::fake('public');

		$post = BlogPost::factory()->create();

		Storage::disk('public')->assertExists("blog/{$post->slug}.png");
	}
}