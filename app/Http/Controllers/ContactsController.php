<?php

namespace Corp\Http\Controllers;

use Illuminate\Http\Request;
use Corp\Repositories\MenusRepository;
use Corp\Menu;
use Corp\Http\Requests;

class ContactsController extends SiteController
{
  public function __construct() {
    parent::__construct(new MenusRepository(new Menu));
    $this->bar = 'left';
    $this->template = env('THEME').'.contacts';
  }

  public function index() {
    $this->contentRightBar = FALSE;
    $this->title = 'Контакты';
    $content = view(env('THEME').'.contact_content')->render();
    $this->vars = array_add($this->vars, 'content', $content);
    $this->contentLeftBar = view(env('THEME').'.contact_bar')->render();

    return $this->renderOutput();
  }
}
