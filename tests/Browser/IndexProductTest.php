<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Product;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class IndexProductTest extends DuskTestCase
{
    public function testViewIndexProduct()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))->visitRoute('products.index')
                ->assertSee(trans('titles.name-var', ['name' => __('titles.product')]))
                ->assertSee(trans('titles.slug'))
                ->assertSee(trans('titles.quantity'))
                ->assertSee(trans('titles.price'))
                ->assertSee(trans('titles.image-thumbnail'))
                ->assertSee(trans('titles.brand'))
                ->assertSee(trans('titles.category'));
        });
    }

    public function testActionEdit()
    {
        $this->browse(function (Browser $browser) {
            $product = Product::all()->last();
            $browser->loginAs(User::find(1))->visitRoute('products.index')
                ->click('.fa-edit')
                ->assertPathIs('/admin/products/' . $product->id . '/edit');
        });
    }

    public function testActionDeleteCancel()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))->visitRoute('products.index')
                ->click('.fa-times');
            $browser->assertDialogOpened(trans('messages.confirmDelete', ['name' => __('titles.product')]));
            $browser->dismissDialog();
        });
    }

    public function testActionConfirmDelete()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))->visitRoute('products.index')
                ->click('.fa-times');
            $browser->assertDialogOpened(trans('messages.confirmDelete', ['name' => __('titles.product')]));
            $browser->acceptDialog();
        });
    }

    public function testLogout()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))->visitRoute('products.index')
                ->click('.dropdown-toggle')
                ->click('@logout')
                ->assertPathIs('/home');
        });
    }
}
