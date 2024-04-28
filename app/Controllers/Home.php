<?php

namespace App\Controllers;

use App\Libraries\Recaptha;
use App\Models\UserModel;

class Home extends BaseController
{
	public function index()
	{
		return view('home/index', [
			'page' => 'home'
		]);
	}

	public function login()
	{
		if ($this->session->has('login')) {
			return $this->response->redirect('/user/');
		}
		if ($r = $this->request->getGet('r')) {
			return $this->response->setCookie('r', $r, 0)->redirect('/login/');
		}
		if ($this->request->getMethod() === 'post') {
			$post = $this->request->getPost();
			if (isset($post['email'], $post['password'])) {
				$login = (new UserModel())->atEmail($post['email']);
				if ($login && password_verify(
					$post['password'],
					$login->password
				)) {
					(new UserModel())->login($login);
					if ($r = $this->request->getCookie('r')) {
						$this->response->deleteCookie('r');
					}
					return $this->response->redirect(base_url($r ?: 'user'));
				}
			}
			$m = lang('Interface.wrongLogin');
		}
		return view('home/login', [
			'message' => $m ?? (($_GET['msg'] ?? '') === 'emailsent' ? lang('Interface.emailSent') : null)
		]);
	}

	public function register()
	{
		$recaptha = new Recaptha();
		if ($this->request->getMethod() === 'get') {
			return view('home/register', [
				'errors' => $this->session->errors,
				'recapthaSite' => $recaptha->recapthaSite,
			]);
		} else {
			if ($this->validate([
				'name' => 'required|min_length[3]|max_length[255]',
				'email' => 'required|valid_email|is_unique[user.email]',
				'password' => 'required|min_length[8]',
				'g-recaptcha-response' => ENVIRONMENT === 'production' && $recaptha->recapthaSecret ? 'required' : 'permit_empty',
			])) {
				if (ENVIRONMENT !== 'production' || !$recaptha->recapthaSecret || (new Recaptha())->verify($_POST['g-recaptcha-response'])) {
					$id = (new UserModel())->register($this->request->getPost());
					(new UserModel())->find($id)->sendVerifyEmail();
					if ($r = $this->request->getCookie('r')) {
						$this->response->deleteCookie('r');
					}
					return $this->response->redirect(base_url($r ?: 'user'));
				}
			}
			return redirect()->back()->withInput()->with('errors', $this->validator->listErrors());
		}
	}

}
