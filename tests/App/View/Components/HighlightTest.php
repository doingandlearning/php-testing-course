<?php

namespace Tests\Support\Markdown;

use League\CommonMark\MarkdownConverter;
use Spatie\Snapshots\MatchesSnapshots;
use Tests\TestCase;

class HighlightCodeBlockRendererTest extends TestCase
{
    use MatchesSnapshots;

    /** @test */
    public function hljs_tags_can_be_parsed()
    {
        $markdown = <<<MD
```php
public function __construct(
    <hljs keyword>public readonly</hljs> <hljs type>string</hljs> <hljs prop>\$title</hljs>,
    <hljs keyword>public readonly</hljs> <hljs type>string</hljs> <hljs prop>\$body</hljs>,
) {}
```
MD;

        $convertor = app(MarkdownConverter::class);

        $html = $convertor->convertToHtml($markdown);

        $this->assertMatchesSnapshot($html);
    }
}
