<?php

namespace App\Controllers;

use App\Entities\Article;
use App\Entities\User as EntitiesUser;
use App\Models\ArticleModel;
use App\Models\UserModel;
use App\Entities\FinancialPerformance;
use App\Models\FinancialPerformanceModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;
use CodeIgniter\CLI\CLI;

class User extends BaseController
{

	/** @var EntitiesUser  */
	public $login;

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);

		if (!($this->login = Services::login())) {
			$this->logout();
			$this->response->redirect('/login/')->send();
			exit;
		}
	}

	public function index()
	{
		return view('user/dashboard', [
			'page' => 'dashboard'
		]);
	}

	public function logout()
	{
		$this->session->destroy();
		return $this->response->redirect('/');
	}


	public function article($page = 'list', $id = null)
	{
		$model = new ArticleModel();
		if ($this->login->role !== 'admin') {
			$model->withUser($this->login->id);
		}
		if ($this->request->getMethod() === 'post') {
			if ($page === 'delete' && $model->delete($id)) {
				return $this->response->redirect('/user/article/');
			} else if ($id = $model->processWeb($id)) {
				return $this->response->redirect('/user/article/');
			}
		}
		switch ($page) {
			case 'list':
				return view('user/article/list', [
					'data' => find_with_filter(empty($_GET['category']) ? $model : $model->withCategory($_GET['category'])),
					'page' => 'article',
				]);
			case 'add':
				return view('user/article/edit', [
					'item' => new Article()
				]);
			case 'edit':
				if (!($item = $model->find($id))) {
					throw new PageNotFoundException();
				}
				return view('user/article/edit', [
					'item' => $item
				]);
		}
		throw new PageNotFoundException();
	}

	public function manage($page = 'list', $id = null)
	{
		if ($this->login->role !== 'admin') {
			throw new PageNotFoundException();
		}
		$model = new UserModel();
		if ($this->request->getMethod() === 'post') {
			if ($page === 'delete' && $model->delete($id)) {
				return $this->response->redirect('/user/manage/');
			} else if ($id = $model->processWeb($id)) {
				return $this->response->redirect('/user/manage/');
			}
		}
		switch ($page) {
			case 'list':
				return view('user/users/list', [
					'data' => find_with_filter($model),
					'page' => 'users',
				]);
			case 'add':
				return view('user/users/edit', [
					'item' => new EntitiesUser()
				]);
			case 'edit':
				if (!($item = $model->find($id))) {
					throw new PageNotFoundException();
				}
				return view('user/users/edit', [
					'item' => $item
				]);
		}
		throw new PageNotFoundException();
	}

	public function uploads($directory)
	{
		// to upload general files (summernote)
		$path = WRITEPATH . implode(DIRECTORY_SEPARATOR, ['uploads', $directory, '']);
		$r = $this->request;
		if (!is_dir($path))
			mkdir($path, 0775, true);
		if ($r->getMethod() === 'post') {
			if (($f = $r->getFile('file')) && $f->isValid()) {
				if ($f->move($path)) {
					return $f->getName();
				}
			}
		}
		return null;
	}

	public function profile()
	{
		if ($this->request->getMethod() === 'post') {
			if ((new UserModel())->processWeb($this->login->id)) {
				return $this->response->redirect('/user/profile/');
			}
		}
		return view('user/profile', [
			'item' => $this->login,
			'page' => 'profile',
		]);
	}
	
	public function finance($page = 'list', $id = null)
	{
    // CLI::write('See this text immediatelyyyyy');
    // $text = 'See this text immediately';
    // var_dump($text);
    $method = $this->request->getMethod();
		$model = new FinancialPerformanceModel();
		$test = $model->where('tahun', '2005')->countAllResults();
		var_dump($test);
		var_dump($method);
		$hallo = "hallo";
		var_dump($hallo);
		if ($this->login->role !== 'admin') {
			$model->withUser($this->login->id);
		}
		if ($this->request->getMethod() === 'post') {
		  $masuk_post = "masuk post";
			  var_dump($masuk_post);
			if ($page === 'delete' && $model->delete($id)) {
			  $masuk_delete = "masuk delete";
			  var_dump($masuk_delete);
				return $this->response->redirect('/user/finance/');
			} else {
			  $masuk_gak = "masuk gak";
			  var_dump($masuk_gak);
			  if ($model->checkDuplicateYear($id, $this->request->getPost('tahun'))) {
			  echo '
        <script>
            alert("Duplicate years exist");
            window.location="'.base_url('/user/finance/').'";
        </script>';
			  } else {
			    $model->processWeb($id);
			    return $this->response->redirect('/user/finance/');
			  }
			}
		}
		switch ($page) {
			case 'list':
				return view('user/finance/list', [
					'data' => get_financial_performance($model), // oke grep all data
					// 'data' => $model->findAll(), // oke grep all data 
					'page' => 'finance',
				]);
			case 'add':
				return view('user/finance/edit', [
					'item' => new FinancialPerformance()
				]);
			case 'edit':
				if (!($item = $model->find($id))) {
					throw new PageNotFoundException();
				}
				return view('user/finance/edit', [
					'item' => $item
				]);
		}
		throw new PageNotFoundException();
	}
}
