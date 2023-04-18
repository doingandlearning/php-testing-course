<?php
use App\Http\Controllers\JsonPostController;
use App\Models\BlogPost;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;


class JsonControllerTest extends TestCase
{

	public function test_index_shows_all_the_blog_posts()
	{

		[$postA, $postB] = BlogPost::factory()->count(2)->published()->create();

		$this->get(action([JsonPostController::class, 'index']))
			->assertSuccessful()
			->assertJson(function (AssertableJson $json) use ($postA) {
				$json->has('data', 2)
					->has('data.0', function (AssertableJson $json) use ($postA) {
							$json
								->has('id')
								->has('date')
								->has('slug')
								->whereType('date', 'string')
								->whereType('id', 'integer')
								->where('id', $postA->id)
								->etc();
						});
			});
	}

	public function test_detail_shows_one_blog_post()
	{
		[, , $post] = BlogPost::factory()->count(3)->create();

		$this->get(action([JsonPostController::class, 'show'], $post->slug))
			->assertSuccessful()
			->assertJson(fn(AssertableJson $json) =>
				$json->has('id')
					->has('date')
					->has('slug')
					->whereType('date', 'string')
					->whereType('id', 'integer')
					->where('id', $post->id)
					->etc());
	}
}