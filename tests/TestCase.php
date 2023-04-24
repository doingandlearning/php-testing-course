<?php

namespace Tests;

use App\Jobs\CreateOgImageJob;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Bus;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Bus::fake([CreateOgImageJob::class]);
        
    }

    public function login(User $user = null): User
    {
        $user ??= User::factory()->create();
        $this->actingAs($user);
        return $user;
    }
}
