<?php

namespace Tests\Factories;

use App\Models\BlogPost;
use Carbon\Carbon;

class BlogPostRequestDataFactory
{
    private string $title = 'Title';
    private string $author = 'Author';
    private string $body = 'Body';
    private string $date = '2021-01-01';

    public static function new(): self
    {
        return new self();
    }

    public function create(array $extra = []): array
    {
        return $extra + [
            'title' => $this->title,
            'author' => $this->author,
            'body' => $this->body,
            'date' => $this->date,
        ];
    }

    public function withTitle(string $title): self
    {
        $clone = clone $this;

        $clone->title = $title;

        return $clone;
    }

    public function withDate(string|Carbon $date): self
    {
        $clone = clone $this;

        $clone->date = $date instanceof Carbon
            ? $date->format('Y-m-d')
            : $date;

        return $clone;
    }

    public function withPost(BlogPost $post): self
    {
        $clone = clone $this;

        $this->title = $post->title;
        $this->author = $post->author;
        $this->body = $post->body;
        $this->date = $post->date->format('Y-m-d');

        return $clone;
    }
}
