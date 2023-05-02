<?php
use Tests\TestCase;
use Spatie\Snapshots\MatchesSnapshots;
class RowTest extends TestCase
{
	use MatchesSnapshots;

	public function test_header_row_is_rendered()
	{
		$this->assertMatchesSnapshot((string) $this->blade('<x-row header>This should be rendered in the middle</x-row>'));

		$this->assertMatchesSnapshot((string) $this->blade('<x-row />'));
	}
}