<?php

namespace Tests\Browser;

use Faker\Factory;
use App\Models\User;
use App\Models\Brand;
use Tests\DuskTestCase;
use App\Models\Category;
use Laravel\Dusk\Browser;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddProductTest extends DuskTestCase
{
    // use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }


    public function testGoToAddProductPage()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $browser->loginAs($user)->visitRoute('products.create')
                ->assertSee('ADD PRODUCT')
                ->assertPresent('input[name="name"]')
                ->assertPresent('input[name="quantity"]')
                ->assertPresent('input[name="price"]')
                ->assertPresent('textarea[name="description"]')
                ->assertPresent('select[name="brand_id"]')
                ->assertPresent('select[name="categories[]"]')
                ->assertPresent('input[name="image_thumbnail"]')
                ->assertPresent('input[name="images[]"]');
        });
    }

    public function testAddProductNameFalse()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $faker = Factory::create();
            $idCategoryies = Category::whereHas('parentCategory.parentCategory')->first()->id;
            $browser->loginAs($user)->visitRoute('products.create')
                ->assertSee('ADD PRODUCT')
                ->type('name', 'ab')
                ->type('quantity', $faker->numerify('###'))
                ->type('price', $faker->numerify('#######'))
                ->type('description', $faker->sentences)
                ->select('brand_id', Brand::all()->random()->id)
                ->select('categories[]', $idCategoryies)
                ->attach('image_thumbnail', public_path('images/g7.jpg'))
                ->attach('images[]', public_path('images/g7.jpg'))
                ->attach('images[]', public_path('images/g7.jpg'))
                ->click('#createProduct');

            $browser->assertSee('The name must be at least')
                ->assertPathIs('/admin/products/create');
        });
    }

    public function testAddProductQuantityFalse()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $faker = Factory::create();
            $idCategoryies = Category::whereHas('parentCategory.parentCategory')->first()->id;
            $browser->loginAs($user)->visitRoute('products.create')
                ->assertSee('ADD PRODUCT')
                ->type('name', $faker->name)
                ->type('quantity', $faker->name)
                ->type('price', $faker->numerify('#######'))
                ->type('description', $faker->sentences)
                ->select('brand_id', Brand::all()->random()->id)
                ->select('categories[]', $idCategoryies)
                ->attach('image_thumbnail', public_path('images/g7.jpg'))
                ->attach('images[]', public_path('images/g7.jpg'))
                ->attach('images[]', public_path('images/g7.jpg'))
                ->click('#createProduct');

            $browser->assertSee('The quantity must be an integer')
                ->assertSee('Please check the data again .')
                ->assertPathIs('/admin/products/create');
        });
    }

    public function testAddProductPriceFalse()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $faker = Factory::create();
            $idCategoryies = Category::whereHas('parentCategory.parentCategory')->first()->id;
            $browser->loginAs($user)->visitRoute('products.create')
                ->assertSee('ADD PRODUCT')
                ->type('name', $faker->name)
                ->type('quantity', $faker->numerify('###'))
                ->type('price', $faker->numerify('##'))
                ->type('description', $faker->sentences)
                ->select('brand_id', Brand::all()->random()->id)
                ->select('categories[]', $idCategoryies)
                ->attach('image_thumbnail', public_path('images/g7.jpg'))
                ->attach('images[]', public_path('images/g7.jpg'))
                ->attach('images[]', public_path('images/g7.jpg'))
                ->click('#createProduct');

            $browser->assertSee('The price must be between 4 and 9 digits.')
                ->assertSee('Please check the data again .')
                ->assertPathIs('/admin/products/create');
        });
    }

    public function testAddProductImageThumbnailFalse()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $faker = Factory::create();
            $idCategoryies = Category::whereHas('parentCategory.parentCategory')->first()->id;
            $browser->loginAs($user)->visitRoute('products.create')
                ->assertSee('ADD PRODUCT')
                ->type('name', $faker->name)
                ->type('quantity', $faker->numerify('###'))
                ->type('price', $faker->numerify('#######'))
                ->type('description', $faker->sentences)
                ->select('brand_id', Brand::all()->random()->id)
                ->select('categories[]', $idCategoryies)
                ->attach('images[]', public_path('images/g7.jpg'))
                ->attach('images[]', public_path('images/g7.jpg'))
                ->click('#createProduct');

            $browser->assertSee('The image thumbnail field is required.')
                ->assertSee('Please check the data again .')
                ->assertPathIs('/admin/products/create');
        });
    }

    public function testAddProductImagesFalse()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $faker = Factory::create();
            $idCategoryies = Category::whereHas('parentCategory.parentCategory')->first()->id;
            $browser->loginAs($user)->visitRoute('products.create')
                ->assertSee('ADD PRODUCT')
                ->type('name', $faker->name)
                ->type('quantity', $faker->numerify('###'))
                ->type('price', $faker->numerify('#######'))
                ->type('description', $faker->sentences)
                ->select('brand_id', Brand::all()->random()->id)
                ->select('categories[]', $idCategoryies)
                ->attach('image_thumbnail', public_path('images/g7.jpg'))
                ->attach('images[]', public_path('images/g7.jpg'))
                ->click('#createProduct');

            $browser->assertSee('The images must be at least 2 characters.')
                ->assertSee('Please check the data again .')
                ->assertPathIs('/admin/products/create');
        });
    }

    public function testAddProductSuccess()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $faker = Factory::create();
            $idCategoryies = Category::whereHas('parentCategory.parentCategory')->first()->id;
            $browser->loginAs($user)->visitRoute('products.create')
                ->assertSee('ADD PRODUCT')
                ->type('name', $faker->name)
                ->type('quantity', $faker->numerify('###'))
                ->type('price', $faker->numerify('#######'))
                ->type('description', $faker->sentences)
                ->select('brand_id', Brand::all()->random()->id)
                ->select('categories[]', $idCategoryies)
                ->attach('image_thumbnail', public_path('images/g7.jpg'))
                ->attach('images[]', public_path('images/g7.jpg'))
                ->pause(1000)
                ->attach('images[]', public_path('images/g7.jpg'))
                ->click('#createProduct');

            $browser->assertSee('Add Category successful')
                ->assertPathIs('/admin/products/create');
        });
    }
}
