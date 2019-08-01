<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;

class MenuTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
 
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_return_view_create()
    {
        $user = factory(User::class)->create();
        $this
        ->actingAs($user)
        ->get(route('menu.index'))
        ->assertStatus(200);
    }

    // public function test_store_menu()
    // {
    //     $data = [
    //         'name' => 'menu creat',
    //         'link' => 'swshwsdfhdf.com',
    //         'type' => '1',
    //         'order' => 4055,
    //     ];

    //     $user = factory(User::class)->create();

    //     $this
    //     ->actingAs($user)
    //     ->post(route('menu.store'), $data)
    //     ->assertStatus(302)
    //     ->assertRedirect(route('menu.index'))
    //     ->assertSessionHas('success', 'Create Menu Successful !');
    // }

    // public function test_create_invalid()
    // {
    //     $data = [
    //         'name' => '',
    //     ];

    //     $user = factory(User::class)->create();
    //     $this
    //     ->actingAs($user)
    //     ->post(route('menu.store'), $data)
    //     ->assertStatus(200);
    // }

}
