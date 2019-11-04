<?php

namespace Corp\Repositories;

use Corp\Menu;

class MenusRepository extends Repository {

    public function __construct(Menu $menu) {
      $this->model = $menu;
    }

    public function deleteMenu($menu)
    {
      if($menu->delete()) {
        return ['status' => 'Ссылка удалена'];
      }
    }
   /* public function addMenus($request)
    {
      if(Gate::denies('save', $this->model)) {
        abort(403);
      }

      $data = $request->except('_token');
      if(empty($data)) {
        return array('error' => 'Нет данных');
      }

      if(empty($data['alias'])) {
        $data['alias'] = $this->transliterate($data['title']);
      }

      if($this->one($data['alias'], FALSE)) {
        $request->merge(array('alias'=>$data['alias']));
        $request->flash();

        return ['error' => 'Данный псевдоним уже используеться'];
      }

      if($request->hasFile('img')) {
        $image = $request->file('img');
       $img = Image::make('$img')->getRealPath();
       $img->fit(600, 400);
     }

      $this->model->fill($data);

      if($request->user()->articles()->save($this->model)) {
        return ['status' => 'Материал добавлен'];
      }
    }*/
}
 ?>
