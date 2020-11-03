<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    const ENDPOINT_URL = "/api/categories";
    protected function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(User::factory()->create());
    }

    public function test_index()
    {
        Category::factory()->count(7)->create();
        $response = $this->getJson(self::ENDPOINT_URL);
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $response->assertJsonCount(7, 'data');
    }

    public function test_create_new_category()
    {
        $data = [
            'name' => 'Super new category',
        ];
        $response = $this->postJson(self::ENDPOINT_URL, $data);
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDatabaseHas('categories', $data);
    }

    public function test_update_category()
    {
        /** @var Category $category */
        $category= Category::factory()->create();

        $data = [
            'name' => 'Update Category',
        ];

        $response = $this->putJson(self::ENDPOINT_URL."/{$category->getKey()}", $data);
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_show_category()
    {
        /** @var Category $category */
        $category = Category::factory()->create();
        $response = $this->getJson(self::ENDPOINT_URL."/{$category->getKey()}");
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
    }

    public function test_delete_category()
    {
        /** @var Category $category */
        $product = Category::factory()->create();

        $response = $this->deleteJson(self::ENDPOINT_URL."/{$product->getKey()}");
        $response->assertSuccessful();
        $response->assertHeader('content-type', 'application/json');
        $this->assertDeleted($product);
    }

    public function test_user_not_auth()
    {
    }
}
