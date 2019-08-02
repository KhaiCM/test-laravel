<?php

namespace App\Repo;

use App\Models\Menu;

class MenuRepository
{

	public function getList()
	{
		$listMenu = Menu::all();

		return $listMenu;
	}

	public function create($data)
	{
		return Menu::create($data);
	}

	public function getViewEdit($menu)
	{
		return Menu::findOrFail($menu);
	}

	public function updateMenu($request, $id)
	{
		// dd($request);
		$menu = Menu::findOrFail($id);
		$menu->name = $request['name'];
		$menu->link = $request['link'];
		$menu->type = $request['type'];
		if (isset($request->order)) {
			$menu->order = $request['order'];
		}

		$menu->save();

		return $menu;
	}

	public function deleteMenu($id)
	{
		$menu = Menu::findOrFail($id);
		return $result = $menu->delete();

	}
}