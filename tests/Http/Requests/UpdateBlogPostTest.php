<?php

namespace Tests\Http\Controllers;

use App\Http\Controllers\BlogPostAdminController;
use App\Http\Controllers\UpdatePostSlugController;
use App\Models\BlogPost;
use App\Models\Redirect;
use Tests\Factories\BlogPostRequestDataFactory;
use Tests\TestCase;

class UpdateBlogPostTest extends TestCase
{
    private BlogPost $blogPost;

    private BlogPostRequestDataFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->blogPost = BlogPost::factory()->create();
        $this->factory = BlogPostRequestDataFactory::new()->withPost($this->blogPost);
    }

    /** @test */
    public function required_fields_are_validated()
    {
        $this->login();

        $this
            ->post(action([BlogPostAdminController::class, 'update'], $this->blogPost->slug), [])
            ->assertSessionHasErrors(['title', 'author', 'body', 'date'])
						;

        $this
            ->post(
                action([BlogPostAdminController::class, 'update'], $this->blogPost->slug),
                $this->factory->create()
            )
            ->assertSessionHasNoErrors();
    }

    /** @test */
    public function date_format_is_validated()
    {
        $this->login();

        $this
            ->post(
                action([BlogPostAdminController::class, 'update'], $this->blogPost->slug),
                $this->factory
                    ->withDate('01/01/2021')
                    ->create()
            )
            ->assertSessionHasErrors([
                'date' => 'The date does not match the format Y-m-d.'
            ])
        ;
    }

    /** @test */
    public function slug_update_creates_redirect()
    {
        $this->login();

        $post = BlogPost::factory()->create([
            'slug' => 'slug-a',
        ]);

        $this->withoutExceptionHandling();

        $this
            ->post(action(UpdatePostSlugController::class, [$post->slug]), [
                'slug' => 'slug-b',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas(Redirect::class, [
            'from' => '/blog/slug-a',
            'to' => '/blog/slug-b',
        ]);

        $this->assertEquals('slug-b', $post->refresh()->slug);
    }
}
