<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Mockery;
use App\Http\Requests\Social\SocialCreateRequest;
use App\Http\Requests\Social\SocialUpdateRequest;
use Symfony\Component\HttpFoundation\ParameterBag;
use App\Http\Controllers\SocialController;
use App\Models\Social;
use Illuminate\Http\Request;
use App\Repo\SocialRepository;

class SocialControllerTest extends TestCase
{
    /**
     * @var \Mockery\Mock|Repo\StreetRepositoryInterface
     */
    protected $socialRepository;

    protected function setUp(): void
    {
        $this->afterApplicationCreated(function () {
            $this->socialRepository = Mockery::mock(SocialRepository::class);
        });

        parent::setUp();
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testListSocial()
    {
        $request = new Request();
    
        $listSocial = factory(Social::class, 3)->create();

        $this->socialRepository->shouldReceive('getListSocial')
        ->once()
        ->andReturn($listSocial);

        $socialController = new SocialController($this->socialRepository);

        $view = $socialController->index($request);
        $this->assertEquals('socials.index', $view->getName());
        $this->assertArraySubset([
            'listSocial' => $listSocial,
        ], $view->getData());

    }

    public function testCreateSocial()
    {
        $request = new SocialCreateRequest();
        $data = [
            'url' => 'cfgbfghfghh',
            'icon' => 'dhfhfg',
        ];

        $request->headers->set('content-type', 'application/json');
        $request->setJson(new ParameterBag($data));

        $this->socialRepository->shouldReceive('createNewSocial')
        ->once()
        ->andReturn(true);

        $socialController = new SocialController($this->socialRepository);
        $redirectResponse = $socialController->store($request);

        $this->assertEquals(route('social.index'), $redirectResponse->headers->get('location'));
        $this->assertEquals($redirectResponse->getSession()->get('success'), __('messages.success_create_social'));
    }

    // public function testCreateReturnView()
    // {
    //     $request = new Request();
    //     $socialController = new SocialController($this->socialRepository);

    //     $view = $socialController->create();

    //     $this->assertEquals('socials.create', $view->getName());
    // }

    public function testEditReturnView()
    {
        $request = new Request();
        $socialWantEdit = factory(Social::class)->make();
        $id = '1';
        
        $this->socialRepository->shouldReceive('showFormEditSocial')
        ->once()
        ->andReturn($socialWantEdit);

        $socialController = new SocialController($this->socialRepository);
        $view = $socialController->edit($id, $request);

        $this->assertEquals('socials.edit', $view->getName());
        $this->assertEquals($view->getData()['social'], $socialWantEdit);
    }

    // public function testUpdateSocial()
    // {
    //     $request = new SocialUpdateRequest();

    //     $data = [
    //         'id' => '1',
    //         'url' => 'cfgbfghfghh',
    //         'icon' => 'dhfhfg',
    //     ];

    //     $id = '1';

    //     $request->headers->set('content-type', 'application/json');
    //     $request->setJson(new ParameterBag($data));
        
    //     $this->socialRepository->shouldReceive('updateSocial')
    //     ->once()
    //     ->andReturn(true);

    //     $socialController = new SocialController($this->socialRepository);
    //     $redirectResponse = $socialController->update($request, $id);

    //     $this->assertEquals(env('APP_URL'), $redirectResponse->headers->get('location'));
    //     $this->assertEquals($redirectResponse->getSession()->get('success'), __('messages.success_update_social'));
    // }

    // public function testDeleteSocial()
    // {
    //     $request = new Request();

    //     $id = '1';

    //     $this->socialRepository->shouldReceive('deleteSocial')
    //     ->once()
    //     ->andReturn(true);

    //     $socialController = new SocialController($this->socialRepository);
    //     $redirectResponse = $socialController->destroy($request, $id);

    //     $this->assertEquals(env('APP_URL'), $redirectResponse->headers->get('location'));
    //     $this->assertEquals($redirectResponse->getSession()->get('success'), __('messages.success_delete_social'));
    // }
}
