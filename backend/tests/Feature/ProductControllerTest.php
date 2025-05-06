<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_retrieves_all_products()
    {
        Product::factory(5)->create();

        $response = $this->getJson(route('product.index'));

        $response->assertOk()
            ->assertJsonStructure(['data', 'message'])
            ->assertJsonCount(5, 'data');
    }

    public function test_show_retrieves_single_product()
    {
        $product = Product::factory()->create();

        $response = $this->getJson(route('product.show', $product->id));

        $response->assertOk()
            ->assertJsonStructure(['data', 'message'])
            ->assertJsonPath('data.id', $product->id);
    }

    public function test_store_creates_a_new_product()
    {
        $data = [
            'name' => 'Test Product',
            'price' => 100.50
        ];

        $response = $this->postJson(route('product.store'), $data);

        $response->assertCreated()
            ->assertJsonStructure(['data', 'message']);

        $this->assertDatabaseHas('products', $data);
    }

    public function test_store_returns_error_on_invalid_data()
    {
        $data = [
            'name' => '',
            'price' => -10,
        ];

        $response = $this->postJson(route('product.store'), $data);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonStructure(['errors']);
    }

    public function test_update_modifies_existing_product()
    {
        $product = Product::factory()->create();
        $updatedData = [
            'name' => 'Updated Product Name',
            'price' => 150.75,
        ];

        $response = $this->putJson(route('product.update', $product->id), $updatedData);

        $response->assertOk()
            ->assertJsonStructure(['data', 'message']);

        $this->assertDatabaseHas('products', $updatedData);
    }

    public function test_update_returns_error_on_invalid_data()
    {
        $product = Product::factory()->create();
        $invalidData = [
            'name' => '',
        ];

        $response = $this->putJson(route('product.update', $product->id), $invalidData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonStructure(['errors']);
    }

    public function test_destroy_deletes_product()
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(route('product.destroy', $product->id));

        $response->assertOk()
            ->assertJsonStructure(['data', 'message']);

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_destroy_returns_error_for_nonexistent_product()
    {
        $response = $this->deleteJson(route('product.destroy', 9999));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
