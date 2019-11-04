<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Corp\Http\Requests;
use Corp\Http\Controllers\Controller;
use Corp\Repositories\ArticlesRepository;
use Corp\Repositories\MenusRepository;
use Corp\Repositories\PortfoliosRepository;
use Corp\Category;
use Corp\Article;
use Gate;
use Menu;

class MenusController extends AdminController
{
    protected $m_rep;

    public function __construct(MenusRepository $m_rep, ArticlesRepository $a_rep, PortfoliosRepository $p_rep)
    {
      parent::__construct();

      $this->m_rep = $m_rep;
      $this->a_rep = $a_rep;
      $this->p_rep = $p_rep;

      $this->template= env('THEME').'.admin.menus';

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->title = 'Менеджер пунктов меню';
        $menu = $this->getMenus();

        $this->content = view(env('THEME').'.admin.menus_content')->with('menus', $menu)->render();

        return $this->renderOutput();
    }

    public function getMenus()
    {
        $menu = $this->m_rep->get();
        if($menu->isEmpty()) {
          return FALSE;
        }

        return Menu::make('forMenuPart', function($m) use ($menu) {
          foreach($menu as $item) {
            if($item->parent == 0) {
              $m->add($item->title, $item->path)->id($item->id);
            } else {
              if($m->find($item->parent)) {
                $m->find($item->parent)->add($item->title, $item->path)->id($item->id);
              }
            }
          }
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $result = $this->m_rep->addMenu($request);
      if(is_array($result) && !empty($result['error'])) {
        return back()->with($result);
      }
        return redirect('/admin')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\Corp\Menu $menu)
    {
      $result = $this->m_rep->deleteMenu($menu);
      if(is_array($result) && !empty($result['error'])) {
        return back()->with($result);
      }
        return redirect('/admin')->with($result);
    }
}
