<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ColumnControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->getJson(route('app.index'));

        $response->assertOk()
            ->assertJson( fn (AssertableJson $json) =>
                $json->where('success', 1)
                    ->etc()
            );
    }
}
