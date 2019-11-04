<?php

namespace Corp\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Corp\Http\Requests;
use Corp\Http\Requests\UserRequest;
use Corp\Http\Controllers\Controller;
use Corp\Repositories\UsersRepository;
use Corp\Repositories\RolesRepository;

use Gate;
use Corp\User;
use Corp\Role;

class UsersController extends AdminController
{

    protected $us_rep;
    protected $rol_rep;

    public function __construct(RolesRepository $rol_rep, UsersRepository $us_rep) {
      parent:: __construct();

      if(\Gate::denies('edit_users')) {
        abort(403);
      }
      $this->rol_rep = $rol_rep;
      $this->us_rep = $us_rep;

      $this->template = env('THEME').'.admin.users';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $this->title = 'Список пользователей';
      $users = $this->us_rep->get();
      $this->content = view(env('THEME').'.admin.users_content')->with('users', $users)->render();

      return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $this->title = 'Новый пользователь';
      $roles = $this->getRoles()->reduce(function($returnRoles, $role) {
        $returnRoles[$role->id] = $role->name;
        return $returnRoles;
      }, []);

      $this->content = view(env('THEME').'.admin.users_create_content')->with('role', $roles)->render();

      return $this->renderOutput();
    }

    public function getRoles() {
      return  \Corp\Role::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $result = $this->us_rep->addUser($request);
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
    public function edit(User $user)
    {
      $this->title = 'Редактирования пользователя - '. $user->name;
      $roles = $this->getRoles()->reduce(function($returnRoles, $role) {
        $returnRoles[$role->id] = $role->name;
        return $returnRoles;
      }, []);

      $this->content = view(env('THEME').'.admin.users_create_content')->with('role', $roles)->render();

      return $this->renderOutput();
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
      $result = $this->us_rep->updateUser($request, $user);
      if(is_array($result) && !empty($result['error'])) {
        return back()->with($result);
      }
        return redirect('/admin')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $result = $this->us_rep->deleteUser($user);
      if(is_array($result) && !empty($result['error'])) {
        return back()->with($result);
      }
        return redirect('/admin')->with($result);
    }
    }
}
