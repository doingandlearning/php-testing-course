<?php
use App\Actions\SyncExternalPost;
use App\Support\Rss\RssEntry;
use App\Support\Rss\RssRepository;
use Carbon\CarbonImmutable;
use Mockery\MockInterface;
use Tests\TestCase;
use App\Models\ExternalPost;

class SyncExternalPostTest extends TestCase 
{
	public function test_synced_posts_are_stored_in_the_database()
	{
		# Arrange
		/** @var RssRepository $rss */
		$rss = $this->mock(RssRepository::class, function (MockInterface $mock){
			$mock->shouldReceive('fetch')->andReturn(
				collect([new RssEntry(
					url: 'https://test.com',
					title: 'test',
					date: CarbonImmutable::make('2023-04-24'),
				)])
			);
		} );

		$sync = new SyncExternalPost($rss);

		# Act
		$sync('https://test.com/feed');

		# Assert
		$this->assertDatabaseHas(ExternalPost::class,[
			'url' => 'https://test.com',
			'title' => 'test'
		]);
	}
}