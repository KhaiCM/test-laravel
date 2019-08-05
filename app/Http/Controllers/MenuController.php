<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Http\Requests\Menu\CreateMenuRequest;
use App\Http\Requests\Menu\UpdateMenuRequest;
use App\Repo\MenuRepository;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function index()
    {
        $listMenu = $this->menuRepository->getList();

        $compact = [
            'listMenu' => $listMenu,
        ];

        return view('menu.index', $compact);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd(1111);
        // $this->authorize('create-menu');
        return view('menu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMenuRequest $request)
    {
        $this->authorize('create-menu');
        // if (!\Auth::user()->can('create', \App\Models\Menu::class))
        //     abort(403);
        $this->menuRepository->create($request->all());

        return redirect()->route('menu.index')->with('success', __('messages.success_create_menu'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        $this->authorize('show', $menu);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        //  $this->authorize('update', $menu);
        $menu = $this->menuRepository->getViewEdit($menu);

        return view('menu.edit', ['menu' => $menu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMenuRequest $request, $id)
    {
        $this->menuRepository->updateMenu($request->all(), $id);

        return redirect()->back()->with('success', __('messages.success_update_menu'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = $this->menuRepository->deleteMenu($id);

        return redirect()->route('menu.index')->with('success', __('messages.success_delete_menu'));
    }
}
