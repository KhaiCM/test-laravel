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
use App\Http\Requests\SettingRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\SettingController;
use App\Models\Setting;
use Mockery as m;
use App\Repo\SettingRepository;
use Illuminate\Support\Facades\Validator;

class SettingControllerTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $db;

    protected $SettingRepoMock;

    protected function setUp(): void
    {
        $this->afterApplicationCreated(function () {
            $this->SettingRepoMock = m::mock(SettingRepository::class);
        });

        parent::setUp();
    }

    public function test_index_return_view()
    {
     $controller = new SettingController($this->SettingRepoMock);

     $this->SettingRepoMock->shouldReceive('getList')
     ->once()
     ->andReturn(true);
     $view = $controller->index();

     $this->assertEquals('setting.index', $view->getName());
     $this->assertArraySubset(['listSetting' => true], $view->getData());
 }

 public function test_create_return_view()
 {
     $controller = new SettingController($this->SettingRepoMock);
     $view = $controller->create();
     $this->assertEquals('setting.update_or_create', $view->getName());
 }

 public function test_create_setting_success()
 {
    $request = new SettingRequest();
    $data = [
        'site_name' => 'new site name ',
        'email' => 'test@gmail.com',
        'phone' => '93278349234',
        'address' => 'dia chi'
    ];
    $request->headers->set('Content-Type', 'application/json');
    $request->setJson(new ParameterBag($data));
    $rules = $request->rules();
    $messages = $request->messages();
    $attributes = $request->attributes();
    $validator = Validator::make($data, $rules, $messages, $attributes);

    $this->SettingRepoMock->shouldReceive('create')->once()->andReturn(true);

    $SettingController = new SettingController($this->SettingRepoMock);
    $redirectResponse = $SettingController->store($request);

    $this->assertEquals(route('setting.index'), $redirectResponse->headers->get('location'));
}

public function test_edit_return_view()
{
    $request = new SettingRequest();
    $editSetting = factory(Setting::class)->make();
    $id = '1';  
    $this->SettingRepoMock->shouldReceive('edit')->once()->andReturn(true);
    $settingController = new SettingController($this->SettingRepoMock);
    $view = $settingController->edit($id);
    $this->assertEquals('setting.update_or_create', $view->getName());

}

public function test_update_setting_success()
{
    $request = new SettingRequest();
    $data = [
        'site_name' => 'update site name',
        'email' => 'update@gmail.com',
        'phone' => 'dsudfsdfhsjdsjsd',
        'address' => 'update dia chi',
    ];
    $id = '1';
    $request->headers->set('content-type', 'application/json');
    $request->setJson(new ParameterBag($data));
    $request->rules();

    $this->SettingRepoMock->shouldReceive('update')->once()->andReturn(true);

    $settingController = new settingController($this->SettingRepoMock);
    $redirectResponse = $settingController->update($request, $id);
}

    // public function test_delete_setting_success()
    // {
    //     $request = new SettingRequest();

    //     $id = '1';

    //     $this->SettingRepoMock->shouldReceive('delete')
    //     ->once()
    //     ->andReturn(true);

    //     $settingController = new settingController($this->SettingRepoMock);
    //     $redirectResponse = $settingController->destroy($request, $id);

    //     $this->assertEquals(env('APP_URL'), $redirectResponse->headers->get('location'));
    //     // dd($redirectResponse);
    //     $this->assertEquals($redirectResponse->getSession()->get('success'), __('messages.success_delete_setting'));
    // }

}
