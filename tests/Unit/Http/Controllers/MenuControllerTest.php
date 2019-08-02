<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Database\Connection;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Menu\CreateMenuRequest;
use App\Http\Requests\Menu\UpdateMenuRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\MenuController;
use App\Models\Menu;
use Mockery as m;
use App\Repo\MenuRepository;
use Illuminate\Support\Facades\Validator;
use Gate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MenuControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $menuRepoMock;

    protected $user;

    protected function setUp(): void
    {
    	$this->afterApplicationCreated(function () {
            $this->menuRepoMock = m::mock(MenuRepository::class);
            // $this->menuPolicyMock = m::mock(MenuPolicy::class);
    	});

    	parent::setUp();
    }

    public function test_index_return_view_success()
    {
    	$controller = new MenuController($this->menuRepoMock);

    	$this->menuRepoMock->shouldReceive('getList')->once()->andReturn(true);
    	$view = $controller->index();

    	$this->assertEquals('menu.index', $view->getName());
    	$this->assertArraySubset(['listMenu' => true], $view->getData());
    }

    public function test_create_return_view()
    {
        $controller = new MenuController($this->menuRepoMock);
        $view = $controller->create();
        // Auth::setUser($user = m::mock(User::class));
        // $user->shouldReceive('create')->endReturn(true);
        // $authMock = m::mock('Illuminate\Auth\Manager');
        // $authMock->shouldReceive('check')->once()->andReturn(true);
        // $menuPolicy = m::mock(MenuPolicy::class);
        // $menuPolicy->shouldReceive('create')->once()->andReturn(true);
        // $menuPolicy->shouldReceive('create')->once()->andReturn(true);
        $this->assertEquals('menu.create', $view->getName());
    }

    public function test_create_menu_success()
    {
    	$request = new CreateMenuRequest();
    	$data = [
    		'name' => 'name menu',
    		'link' => 'testurl.com',
    		'type' => 1,
    		'order' => null,
    	];
    	$request->headers->set('Content-Type', 'application/json');
    	$request->setJson(new ParameterBag($data));

    	$this->menuRepoMock->shouldReceive('create')->once()->andReturn(true);

    	$MenuController = new MenuController($this->menuRepoMock);
    	$redirectResponse = $MenuController->store($request);

    	$this->assertEquals(route('menu.index'), $redirectResponse->headers->get('location'));
    }

    public function test_edit_return_view()
    {
    	$editMenu = factory(Menu::class)->make([
            'id' => 1,
        ]);
    	$this->menuRepoMock->shouldReceive('getViewEdit')->once()->andReturn(true);
    	$menuController = new MenuController($this->menuRepoMock);
    	$view = $menuController->edit($editMenu->id);
    	$this->assertEquals('menu.edit', $view->getName());

    }
    /**
     * @test

     */
    public function update_menu_success()
    {
    	$request = new UpdateMenuRequest();
    	$data = [
    		'link' => 'updatemenu.com',
    		'type' => 0,
    		'order' => null,
    	];
    	$id = '1';
    	$request->headers->set('content-Type', 'application/json');
    	$request->setJson(new ParameterBag($data));
    	$this->menuRepoMock->shouldReceive('updateMenu')->once()->andReturn(true);
    	$menuController = new menuController($this->menuRepoMock);
    	$response = $menuController->update($request, $id);
    	$this->assertInstanceOf(RedirectResponse::class, $response);
    	$this->assertEquals($response->getSession()->get('success'), __('messages.success_update_menu'));
    }

    public function test_destroy_menu_sucess()
    {
        $destroy = factory(Menu::class)->make([
            'id' => 1,
        ]);
        $this->menuRepoMock->shouldReceive('deleteMenu')->once()->andReturn(true);
        $menuController = new MenuController($this->menuRepoMock);
        $response = $menuController->destroy($destroy->id);
        $this->assertEquals(route('menu.index'), $response->headers->get('Location'));
    }
}
