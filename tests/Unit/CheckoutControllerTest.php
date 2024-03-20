<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    use DatabaseMigrations;
    public function testAddToCart()
    {
        // Kullanıcıyı oluştur
        $user = User::factory()->create();

        //Üründe kullanabilmek için kategori oluştur
        Category::factory()->create();

        // Ürünü oluştur
        $product = Product::factory()->create();

        // Sepete ürün ekleyerek API çağrısını yap
        $response = $this->actingAs($user)
            ->postJson('/api/v2/checkout/add-to-cart', [
                'product_id' => $product->id,
                'piece' => 2, // İsteğe bağlı olarak, sepete kaç adet eklemek istediğinizi belirleyebilirsiniz.
            ]);

        // API çağrısının başarılı olup olmadığını kontrol et
        $response->assertStatus(200);

        // Sipariş oluşturarak API çağrısını yap
        $createOrderResponse = $this->actingAs($user)
            ->postJson('/api/v2/order/create');

        // Siparişin doğru şekilde oluşturulduğunu kontrol et
        $createOrderResponse->assertStatus(200);
    }
}
