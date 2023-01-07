<?php

namespace Tests\Feature;

use App\Models\Card;
use App\Models\Column;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class CardControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_new_card_can_be_created(): void
    {
        $card = Card::factory()->make();

        $response = $this->postJson(route('cards.store'), [
            'title' => $card->title,
            'description' => $card->description,
            'column_id' => Column::factory()->create()->id,
            'position' => 1
        ]);

        $response->assertOk()
            //confirm the records returned
            ->assertJson( fn (AssertableJson $json) =>
            $json->where('success', 1)
                ->has('data', fn ($json) =>
                $json->where('title', $card->title)
                    ->where('description', $card->description)
                    ->where('position', 1)
                    ->has('id')
                    ->etc()
                )
                ->etc()
            );
    }

    public function test_card_can_be_updated(): void
    {
        $card = Card::factory()->create();
        $update = Card::factory()->make();

        $response = $this->putJson(route('cards.update', ['card' => $card]), [
            'title' => $update->title,
            'description' => $update->description,
            'column_id' => $update->column_id,
            'position' => 1
        ]);

        var_dump($response->json());

        $response->assertOk();

        $card = $card->refresh();

        $this->assertEquals($card->title, $update->title);
        $this->assertEquals($card->description, $update->description);
        $this->assertEquals($card->column_id, $update->column_id);
    }

    public function test_app_can_get_card_listing(): void
    {
        $seeds = 5;
        Card::factory($seeds)->create();

        $response = $this->getJson(route('cards.listing'));

        $response->assertOk()
            ->assertJson( fn (AssertableJson $json) =>
            $json->where('success', 1)
                ->has('data', fn ($json) =>
                $json->has('cards', $seeds)
                    ->hasAll(['cards.0.id', 'cards.0.title', 'cards.0.created_at', 'cards.0.description', 'cards.0.deleted_at'])
                )
                ->etc()
            );
    }
}
