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
        $user = factory(User::class)->make();
        $this
        ->actingAs($user)
        ->get(route('menu.index'))
        ->assertStatus(200);
    }

    public function test_store_menu_success()
    {
        $data = [
            'name' => 'menu create 1',
            'link' => 'swshwsddddfhdf.com',
            'type' => '1',
            'order' => 4005,
        ];

        $user = factory(User::class)->make();
        $this
        ->actingAs($user)
        ->post(route('menu.store'), $data)
        ->assertStatus(302)
        ->assertRedirect('/');
    }

    public function test_create_invalid()
    {
        $data = [
            'name' => '',
        ];

        $user = factory(User::class)->create();
        $this
        ->actingAs($user);
        $response = $this->post(route('menu.store'), $data)
        ->assertStatus(302);
        $sessionErrors = session()->get('errors');
        $this
        ->assertEquals('The name field is required.', $sessionErrors->first());
    }

}
