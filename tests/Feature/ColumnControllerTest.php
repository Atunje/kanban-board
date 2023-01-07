<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Column;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ColumnControllerTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_new_column_can_be_created(): void
    {
        $column = Column::factory()->make();

        $response = $this->postJson(route('columns.store'), [
            'title' => $column->title
        ]);

        $response->assertOk()
            //confirm the records returned
            ->assertJson( fn (AssertableJson $json) =>
            $json->where('success', 1)
                ->has('data', fn ($json) =>
                $json->where('title', $column->title)
                    ->has('id')
                    ->etc()
                )
                ->etc()
            );
    }

    public function test_app_disallows_empty_column_title_at_creation(): void
    {
        $response = $this->postJson(route('columns.store'), [
            'title' => ''
        ]);

        $response->assertUnprocessable();
    }

    public function test_app_can_return_available_columns(): void
    {
        $seeds = 5;
        Column::factory($seeds)->create();

        $response = $this->getJson(route('columns.index'));

        $response->assertOk()
            ->assertJson( fn (AssertableJson $json) =>
            $json->where('success', 1)
                ->has('data', fn ($json) =>
                $json->has('columns', $seeds)
                    ->hasAll(['columns.0.id', 'columns.0.title', 'columns.0.cards'])
                )
                ->etc()
            );
    }

    public function test_column_can_be_deleted(): void
    {
        $column = Column::factory()->create();

        $response = $this->deleteJson(route('columns.destroy', ['column' => $column]));

        $response->assertOk();

        $column = Column::find($column->id);
        $this->assertNull($column);
    }

    public function test_column_can_be_updated(): void
    {
        $column = Column::factory()->create();
        $new_title = fake()->word;

        $response = $this->putJson(route('columns.update', ['column' => $column]), [
            'title' => $new_title
        ]);

        $response->assertOk();

        $this->assertEquals($column->refresh()->title, $new_title);
    }
}
