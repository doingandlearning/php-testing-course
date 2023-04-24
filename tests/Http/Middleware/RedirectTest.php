<?php
use App\Http\Middleware\RedirectMiddleware;
use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\Redirect;

class RedirectTest extends TestCase {
	public function test_middleware_in_isolation() 
	{
		$middleware = app(RedirectMiddleware::class);

		$response = $middleware->handle(
			$this->createRequest('get', '/'),
			fn() => new Response()
		);

		$this->assertTrue($response->isSuccessful());

		Redirect::factory()->create(['from' => '/', 'to' => '/old-home-page']);

		$response = $middleware->handle(
			$this->createRequest('get', '/'),
			fn() => new Response()
		);

		$this->assertTrue($response->isRedirect('http://testing-laravel.test/old-home-page'));
	}

	public function test_middleware_as_integration()
	{
		// ... mocking, repositories, other dependency considerations .... 

		$this->get('/')->assertSuccessful();

		Redirect::factory()->create(['from' => '/', 'to' => '/old-home-page']);

		$this->get('/')->assertRedirect('/old-home-page');
	}
}