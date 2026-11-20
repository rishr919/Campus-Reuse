<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CampusReuseTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_student_can_register_and_is_logged_in(): void
    {
        $response = $this->post('/register', [
            'name' => 'Ayu Mahasiswa',
            'email' => 'ayu@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('products.index'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'ayu@example.test']);
    }

    public function test_a_student_can_log_in_and_log_out(): void
    {
        $user = User::factory()->create(['password' => 'password123']);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ])->assertRedirect(route('products.index'));

        $this->assertAuthenticatedAs($user);

        $this->post('/logout')->assertRedirect(route('products.index'));
        $this->assertGuest();
    }

    public function test_catalog_displays_product_details_and_can_filter_by_category(): void
    {
        $owner = User::factory()->create(['name' => 'Budi Mahasiswa']);
        Product::create([
            'user_id' => $owner->id,
            'name' => 'Kalkulator ilmiah',
            'description' => 'Masih berfungsi dengan baik.',
            'price' => null,
            'condition' => 'Bekas - baik',
            'category' => 'Alat tulis',
            'campus_location' => 'Kampus Utama',
            'status' => 'tersedia',
        ]);
        Product::create([
            'user_id' => $owner->id,
            'name' => 'Buku novel',
            'description' => 'Buku bacaan.',
            'price' => 15000,
            'condition' => 'Bekas - baik',
            'category' => 'Buku',
            'campus_location' => 'Kampus Utama',
            'status' => 'tersedia',
        ]);

        $this->get('/barang?category=Alat%20tulis')
            ->assertOk()
            ->assertSee('Kalkulator ilmiah')
            ->assertSee('Gratis')
            ->assertSee('Bekas - baik')
            ->assertSee('Budi Mahasiswa')
            ->assertSee('Kampus Utama')
            ->assertDontSee('Buku novel');
    }

    public function test_search_suggests_items_and_filters_catalog_results(): void
    {
        $owner = User::factory()->create();
        Product::create([
            'user_id' => $owner->id,
            'name' => 'Kalkulator ilmiah',
            'description' => 'Kondisi baik.',
            'price' => 25000,
            'condition' => 'Baik',
            'category' => 'Elektronik',
        ]);
        Product::create([
            'user_id' => $owner->id,
            'name' => 'Buku sejarah',
            'description' => 'Bacaan kuliah.',
            'price' => 10000,
            'condition' => 'Baik',
            'category' => 'Buku',
        ]);

        $this->get(route('products.search', ['q' => 'Kalk']))
            ->assertOk()
            ->assertSee('Kalkulator ilmiah')
            ->assertSee('Lihat semua hasil');

        $this->get(route('products.index', ['q' => 'Kalkulator']))
            ->assertOk()
            ->assertSee('Kalkulator ilmiah')
            ->assertDontSee('Buku sejarah');
    }

    public function test_authenticated_student_can_create_an_offer_with_multiple_photos(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Buku kimia',
            'description' => 'Edisi terbaru, masih bagus.',
            'offer_type' => 'dijual',
            'price' => 25000,
            'condition' => 'Baik',
            'category' => 'Buku kuliah',
            'campus_location' => 'Kampus Utama',
            'images' => [
                UploadedFile::fake()->create('buku-depan.jpg', 10, 'image/jpeg'),
                UploadedFile::fake()->create('buku-belakang.jpg', 10, 'image/jpeg'),
            ],
        ])->assertRedirect(route('products.mine'));

        $product = Product::firstOrFail();
        $this->assertSame($user->id, $product->user_id);
        $this->assertSame('dijual', $product->offer_type);
        $this->assertCount(2, $product->photos);
        foreach ($product->photos as $photo) {
            Storage::disk('public')->assertExists($photo);
        }
    }

    public function test_owner_can_edit_offer_and_remove_and_add_photos(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $oldPhoto = 'products/'.$user->id.'/old.jpg';
        Storage::disk('public')->put($oldPhoto, 'existing photo');
        $product = Product::create([
            'user_id' => $user->id,
            'name' => 'Kalkulator',
            'description' => 'Kondisi baik',
            'price' => 50000,
            'offer_type' => 'dijual',
            'condition' => 'Baik',
            'category' => 'Elektronik',
            'image_path' => $oldPhoto,
            'images' => [$oldPhoto],
            'status' => 'tersedia',
        ]);

        $this->actingAs($user)->put(route('products.update', $product), [
            'name' => 'Kalkulator ilmiah',
            'description' => 'Masih berfungsi normal.',
            'offer_type' => 'donasi',
            'condition' => 'Sangat baik',
            'category' => 'Elektronik',
            'remove_images' => [$oldPhoto],
            'images' => [UploadedFile::fake()->create('kalkulator.png', 10, 'image/png')],
        ])->assertRedirect(route('products.mine'));

        $product->refresh();
        $this->assertSame('Kalkulator ilmiah', $product->name);
        $this->assertSame('donasi', $product->offer_type);
        $this->assertNull($product->price);
        $this->assertCount(1, $product->photos);
        Storage::disk('public')->assertMissing($oldPhoto);
        Storage::disk('public')->assertExists($product->photos[0]);
    }

    public function test_owner_can_change_status_and_delete_offer(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $photo = 'products/'.$user->id.'/item.jpg';
        Storage::disk('public')->put($photo, 'photo');
        $product = Product::create([
            'user_id' => $user->id,
            'name' => 'Meja belajar',
            'description' => 'Kokoh.',
            'offer_type' => 'dijual',
            'price' => 100000,
            'condition' => 'Baik',
            'category' => 'Perabot',
            'image_path' => $photo,
            'images' => [$photo],
        ]);

        $this->actingAs($user)
            ->patch(route('products.status', $product), ['status' => 'dipesan'])
            ->assertRedirect();
        $this->assertDatabaseHas('products', ['id' => $product->id, 'status' => 'dipesan']);

        $this->delete(route('products.destroy', $product))
            ->assertRedirect(route('products.mine'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        Storage::disk('public')->assertMissing($photo);
    }

    public function test_student_cannot_manage_another_students_offer(): void
    {
        $owner = User::factory()->create();
        $otherStudent = User::factory()->create();
        $product = Product::create([
            'user_id' => $owner->id,
            'name' => 'Buku',
            'description' => 'Buku kuliah.',
            'offer_type' => 'donasi',
            'condition' => 'Layak pakai',
            'category' => 'Buku',
        ]);

        $this->actingAs($otherStudent)
            ->get(route('products.edit', $product))
            ->assertForbidden();
        $this->put(route('products.update', $product), [])->assertForbidden();
        $this->patch(route('products.status', $product), ['status' => 'selesai'])->assertForbidden();
        $this->delete(route('products.destroy', $product))->assertForbidden();

        $this->assertDatabaseHas('products', ['id' => $product->id, 'user_id' => $owner->id]);
    }

    public function test_offer_management_requires_authentication(): void
    {
        $this->get(route('products.mine'))->assertRedirect(route('login'));
        $this->get(route('products.create'))->assertRedirect(route('login'));
    }

    public function test_owner_can_view_offer_form_and_own_list(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('products.create'))
            ->assertOk()
            ->assertSee('Tawarkan barang')
            ->assertSee('Dijual')
            ->assertSee('Donasi')
            ->assertDontSee('Ditukar');

        $this->get(route('products.mine'))
            ->assertOk()
            ->assertSee('Barang Saya');
    }

    public function test_edit_cannot_add_more_than_five_photos_in_total(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $photos = [];
        for ($index = 1; $index <= 5; $index++) {
            $photos[] = 'products/'.$user->id.'/photo-'.$index.'.jpg';
        }
        $product = Product::create([
            'user_id' => $user->id,
            'name' => 'Buku',
            'description' => 'Kondisi baik',
            'offer_type' => 'dijual',
            'price' => 10000,
            'condition' => 'Baik',
            'category' => 'Buku',
            'images' => $photos,
            'image_path' => $photos[0],
        ]);

        $this->actingAs($user)
            ->put(route('products.update', $product), [
                'name' => $product->name,
                'description' => $product->description,
                'offer_type' => 'dijual',
                'price' => 10000,
                'condition' => 'Baik',
                'category' => 'Buku',
                'images' => [UploadedFile::fake()->create('extra.jpg', 10, 'image/jpeg')],
            ])
            ->assertSessionHasErrors('images');

        $this->assertSame($photos, $product->fresh()->photos);
    }

    public function test_exchange_offer_type_is_not_accepted(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('products.store'), [
                'name' => 'Buku',
                'description' => 'Buku kondisi baik.',
                'offer_type' => 'ditukar',
                'condition' => 'Baik',
                'category' => 'Buku',
            ])
            ->assertSessionHasErrors('offer_type');

        $this->assertDatabaseCount('products', 0);
    }
}
