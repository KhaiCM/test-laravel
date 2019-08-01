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
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    	});

    	parent::setUp();
    }

    public function test_index_return_view_success()
    {
    	$controller = new MenuController($this->menuRepoMock);

    	$this->menuRepoMock->shouldReceive('getList')
    	->once()
    	->andReturn(true);
    	$view = $controller->index();

    	$this->assertEquals('menu.index', $view->getName());
    	$this->assertArraySubset(['listMenu' => true], $view->getData());
    }

    public function test_create_return_view()
    {
    	$controller = app()->make(MenuController::class, [
            $this->menuRepoMock,
        ]);

    	$view = $controller->create();
    	$this->assertEquals('menu.create', $view->getName());
    }

    // public function test_create_menu_success()
    // {
    // 	$request = new CreateMenuRequest();
    // 	$data = [
    // 		'name' => 'name menu',
    // 		'link' => 'testurl.com',
    // 		'type' => 1,
    // 		'order' => null,
    // 	];
    // 	$request->headers->set('Content-Type', 'application/json');
    // 	$request->setJson(new ParameterBag($data));

    // 	$this->menuRepoMock->shouldReceive('create')->once()->andReturn(true);

    // 	$MenuController = new MenuController($this->menuRepoMock);
    // 	$redirectResponse = $MenuController->store($request);

    // 	$this->assertEquals(route('menu.index'), $redirectResponse->headers->get('location'));
    // }

    // public function test_edit_return_view()
    // {
    // 	$editSetting = factory(Menu::class)->make();
    // 	$id = '1';  
    // 	$this->menuRepoMock->shouldReceive('getViewEdit')->once()->andReturn(true);
    // 	$menuController = new MenuController($this->menuRepoMock);
    // 	$view = $menuController->edit($id);
    // 	$this->assertEquals('menu.edit', $view->getName());

    // }

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
    	$request->headers->set('content-type', 'aff');
    	$request->setJson(new ParameterBag($data));
        // $this->expectException(ValidationException::class);
        // $this->assertSessionHasErrors();

    	// $rules = $request->rules();
    	// $messages = $request->messages();
    	// $attributes = $request->attributes();
    	// $validator = Validator::make($data, $rules, $messages, $attributes);
        // dd($validator->errors());
    	// $fails = $validator->fails();
    	// $this->assertEquals(true, $fails);

    	$this->menuRepoMock->shouldReceive('updateMenu')->once()->andReturn(true);

    	$menuController = new menuController($this->menuRepoMock);
        // dd($request);
    	$response = $menuController->update($request, $id);
        // dd($response);

    	$this->assertInstanceOf(RedirectResponse::class, $response);
    	$this->assertEquals($response->getSession()->get('success'), __('messages.success_update_menu'));
    }

}
