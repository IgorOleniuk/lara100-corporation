<?php

namespace Corp\Repositories;

use Corp\Article;
use Corp\Comment;
use Gate;
use Image;
class ArticlesRepository extends Repository {

    public function __construct(Article $articles) {
      $this->model = $articles;
    }

    public function one($alias, $attr = array()) {
      $article = parent::one($alias, $attr);

      if($article && !empty($attr)) {
        $article->load('comments');
        $article->comments->load('user');
      }
      return $article;
    }

    public function addArticle($request)
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

    /*  if($request->hasFile('img')) {
        $image = $request->file('img');
       $img = Image::make('$img')->getRealPath();
       $img->fit(600, 400);
     }*/

      $this->model->fill($data);

      if($request->user()->articles()->save($this->model)) {
        return ['status' => 'Материал добавлен'];
      }
    }

    public function updateArticle($request, $article)
    {
      if(Gate::denies('edit', $this->model)) {
        abort(403);
      }

      $data = $request->except('_token', '_method');
      if(empty($data)) {
        return array('error' => 'Нет данных');
      }

      if(empty($data['alias'])) {
        $data['alias'] = $this->transliterate($data['title']);
      }

      $result = $this->one($data['alias'], FALSE);

      if(isset($result->id) && ($result->id !== $article->id)) {
        $request->merge(array('alias'=>$data['alias']));
        $request->flash();

        return ['error' => 'Данный псевдоним уже используеться'];
      }

    /*  if($request->hasFile('img')) {
        $image = $request->file('img');
       $img = Image::make('$img')->getRealPath();
       $img->fit(600, 400);
     }*/

      $article->fill($data);

      if($article->update()) {
        return ['status' => 'Материал обновлен'];
      }
    }

    public function deleteArticle($article) {
      

      $article->comments()->delete();

      if($article->delete()) {
        return ['status' => 'Материал удален'];
      }
    }
}
 ?>
