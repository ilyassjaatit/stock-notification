<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(User::factory()->create());
    }

    public function test_index()
    {
        Product::factory()->count(7)->create();
        $response = $this->getJson('/api/products');
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $response->assertJsonCount(7, 'data');
    }

    public function test_create_new_product()
    {
        $data = [
            'name' => 'Super new product',
            'price' => 236,
        ];
        $response = $this->postJson('/api/products', $data);
        $response->assertSuccessful();
        #$response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('products', $data);
    }

    public function _update_product()
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $data = [
            'name' => 'Update Product',
            'price' => 200,
        ];

        $response = $this->patchJson("/api/products/{$product->getKey()}", $data);
        dd($response);
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_show_product()
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $response = $this->getJson("/api/products/{$product->getKey()}");
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_delete_product()
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $response = $this->deleteJson("/api/products/{$product->getKey()}");
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDeleted($product);
    }
}
