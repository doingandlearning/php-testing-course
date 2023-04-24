<?php
use Tests\TestCase;
use Tests\Fakes\RssRepositoryFake;
class SyncExternalsTest extends TestCase 
{

	public function test_external_feeds_are_synced()
	{
		# Arrange (set the config variables, mock the RssRespository)
		RssRepositoryFake::setUp();
		config()->set('services.external_feeds', ['https://a.test/rss', 'https://b.test/rss']);
		# Act - invoke the command
		# Asserting - output is right, exit code of 0, database has the right entries
		$this->artisan('sync:externals')
		  ->expectsOutput('Fetching 2 feeds')
			// ->expectsOutput('\t- https://a.test/rss')
			// ->expectsOutput('\t- https://b.test/rss')
			->expectsOutput('Done')
			->assertExitCode(0);

	}
}