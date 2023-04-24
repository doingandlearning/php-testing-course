# Laravel and Testing: Student Notes
- PHPUnit vs Pest

# Testing Philosophy
- Test-Driven Development (TDD)
- Unit testing
- Testing Pyramid vs Testing Trophy

## The Three As
- Arrange, Act, Assert
- Consider these when writing tests, sometimes they might be condensed

# Feature Test: Our First Test
- High-level testing
- Captures and automates what you might do manually
- Extends from Laravel's TestCase, adding helpful functionality
- Two ways to declare a test: annotation or test name
- Laravel offers functionality to simplify testing
- Example of a basic feature test: BlogIndexTest

# Using a Database
- Tests should run in a controlled environment
- Use SQLite and in-memory store for testing
- Add ->assertSuccessful() to check for successful responses
- Use RefreshDatabase trait to run migrations before tests
- Create and manipulate data within tests for more control

# Using Factories
- Useful for generating data more efficiently and consistently
-= Create model factories for easy data creation
- Use factory methods to customize data generation
- Factories can manage relationships and execute callbacks
- Use factories throughout the course to streamline testing

# Final Example Test: BlogIndexTest
```php
<?php

namespace Tests\Feature\Blog;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogIndexTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function index_shows_a_list_of_blog_posts()
    {
        $this->withoutExceptionHandling();

        BlogPost::factory()
            ->count(3)
            ->published()
            ->sequence(
                ['title' => 'Parallel php', 'date' => '2021-01-01'],
                ['title' => 'Fibers', 'date' => '2021-01-01'],
                ['title' => 'Thoughts on event sourcing', 'date' => '2021-02-01']
            )
            ->create();

        BlogPost::factory()
            ->draft()
            ->create(['title' => 'Draft post', 'date' => '2021-01-01']);

        $this
            ->get('/')
            ->assertSuccessful()
            ->assertSee('Parallel php')
            ->assertSeeInOrder([
                'Thoughts on event sourcing',
                'Fibers',
            ])
            ->assertDontSee('Draft post');
    }
}
```
This test checks that the blog post index page displays the correct published posts in order and excludes draft posts.

# Setting Up Mailhog and Updating Form Configuration
- Install and run Mailhog for email testing
- Add the "from" address and update the host configuration

# Creating the Test File
- Analyze the ExternalPostSuggestionController
- Creates an external post
- Sends an email to the admin user
- Displays a flash message
- Redirects the user

# Writing the Test
Test if the external post is created in the database
```php
<?php

namespace Tests\Feature\Blog;

use App\Http\Controllers\ExternalPostSuggestionController;
use Tests\TestCase;
use App\Models\User;

class ExternalPostSuggestionTest extends TestCase
{
	/* @test */
	public function test_external_post_can_be_submitted()
	{
		User::factory()->create();
		$this->withoutExceptionHandling();
		$this->post(action(ExternalPostSuggestionController::class, ['title' => "Awesome Title", "url" => 'https://google.com']))->assertSuccessful()->assertRedirect();
	}
}
```
Update the test to check for the correct redirect status and remove any unnecessary response code assertions

- Check if the external post is added to the database
```php
$this->assertDatabaseHas(ExternalPost::class, ['title' => "Awesome Title", "url" => 'https://google.com']);
```
- Check the flash message by asserting that the session has the laravel_flash_message key

# Testing JSON Endpoints
- Test the JSONPostController methods
- Use JSON helper methods, such as assertJSONCount, to test the response
- Use AssertableJson to create more detailed assertions about the JSON structure

# Authenticated Testing
- Test actions that require authentication, such as editing a post
- Create a test that checks if a user can perform the action when they are not authenticated
- Authenticate a user using actingAs() and perform the action again
- Check the results and compare them to the expected outcome