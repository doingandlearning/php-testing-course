<?php

namespace Tests\Browser;

use App\Http\Controllers\BlogPostController;
use App\Models\BlogPost;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class VoteButtonTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @group dusk
     * @return void
     */
    public function test_vote_button_increments_counter()
    {
       # These tests run slowly (and not all when run directly with PHPUnit),
       # so you can update your test command to php artisan test --exclude-group=dusk
       # and add the group annotation to each dusk test.

        $post = BlogPost::factory()->create(['likes' => 10]);
        $this->browse(function (Browser $browser) use ($post) {
            # Navigate to the post
            $browser
            ->visit(action([BlogPostController::class, 'show'], $post->slug))
            ->with('@vote-button', function (Browser $button) {
                $button->assertSee('10');
            })
            ->click('@vote-button')
            ->pause(100)
            ->with('@vote-button', function (Browser $button) {
                $button->assertSee('11');
            })
            ->screenshot('afterclick')
            ->click('@vote-button')
            ->pause(100)
            ->with('@vote-button', function (Browser $button) {
                $button->assertSee('10');
            });

        });
    }
}
