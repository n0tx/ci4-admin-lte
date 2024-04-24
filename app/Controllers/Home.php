<?php

namespace App\Controllers;

use App\Libraries\Recaptha;
use App\Models\ArticleModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\FinancialPerformanceModel;
use CodeIgniter\Files\Exceptions\FileNotFoundException;

class Home extends BaseController
{
	public function index()
	{
		return view('home/index', [
			'news' => find_with_filter((new ArticleModel())->withCategory('news'), 2),
			'info' => find_with_filter((new ArticleModel())->withCategory('info'), 2),
			'page' => 'home',
			'image_url' => $this->getImageUrlTest()
		]);
	}

	public function getImageUrlTest() {
		
		/*
		// ok ini jalan, set static contoh dari chartjs website
		$chart = '{
			"type": "bar",
			"data": {
			  "labels": [ "January", "February", "March", "April", "May", "June", "July"
			  ],
			  "datasets": [
				{
				  "label": "My data",
				  "fillColor": "rgba(220,220,220,0.5)",
				  "strokeColor": "rgba(220,220,220,1)",
				  "pointColor": "rgba(220,220,220,1)",
				  "pointStrokeColor": "#fff",
				  "data": [ 65, 59, 90, 81, 56, 55, 40 ],
				  "bezierCurve": false
				}
			  ]
			}
		}';
		$encoded = urlencode($chart);
		$image_url = "https://quickchart.io/chart?c=" . $encoded;
		return $image_url;
		*/

		$model = new FinancialPerformanceModel();
		$financial_performance = get_financial_performance($model);

		$tahun = array();
		$penjualan_neto = array();


		for ($i = 0; $i < count($financial_performance); $i++) {
			array_push($tahun, $financial_performance[$i]->tahun);
			array_push($penjualan_neto, $financial_performance[$i]->penjualan_neto);
		}

		$chart = '{
			"type": "bar",
			"data": {

				"labels": '. json_encode($tahun) .',
			  "datasets": [
				{
				  "label": "# Penjualan Neto",
				  "fillColor": "rgba(220,220,220,0.5)",
				  "strokeColor": "rgba(220,220,220,1)",
				  "pointColor": "rgba(220,220,220,1)",
				  "pointStrokeColor": "#fff",
				  "data": '. json_encode($penjualan_neto) .',
				  "bezierCurve": false
				}
			  ]
			}
		}';
		$encoded = urlencode($chart);
		$image_url = "https://quickchart.io/chart?c=" . $encoded;
		return $image_url;
	}

	public function getImageUrl() {
		$kinerja_keuangan = json_encode(get_financial_performance());
		// php get tahun
		// php get penjualan_neto
		// baru taro di $penjualanNeto

		$tahun = "";
		$penjualan_neto = "";
		$penjualan_neto_chart = "";
		$encoded = urlencode($penjualan_neto_chart);
    	$image_url = "https://quickchart.io/chart?c=" . $encoded;
		return $image_url;

		echo "
		<script type=\"text/javascript\">
			let kinerja_keuangan = <?= $kinerja_keuangan ?>

			let tahun = collect(kinerja_keuangan).map(function(item) {
				return item.tahun
			}).all()

			let penjualan_neto = collect(kinerja_keuangan).map(function(item) {
				return item.penjualan_neto
			}).all()
		});
		</script>
		";
		$penjualanNeto = "{
			type: 'bar',
			data: {
				labels: tahun,
				datasets: [{
					label: '# Penjualan Neto',
					data: penjualan_neto,
					backgroundColor: [
					  'rgba(255, 99, 132, 0.2)',
								'rgba(54, 162, 235, 0.2)',
								'rgba(255, 206, 86, 0.2)',
								'rgba(75, 192, 192, 0.2)',
								'rgba(153, 102, 255, 0.2)'
					],
					borderColor: [
								'rgba(255,99,132,1)',
								'rgba(54, 162, 235, 1)',
								'rgba(255, 206, 86, 1)',
								'rgba(75, 192, 192, 1)',
								'rgba(153, 102, 255, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				}
			}
		}";
		$encoded = urlencode($penjualanNeto);
    	$imageUrl = "https://quickchart.io/chart?c=" . $encoded;
		return $imageUrl;
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

	public function article($id = null)
	{
		if ($id === 'about') $id = 1;
		else if ($id === 'faq') $id = 2;
		else if ($id === 'contact') $id = 3;

		$model = new ArticleModel();
		if ($id === null) {
			return view('home/article/list', [
				'data' => $model->findAll(),
			]);
		} else if ($item = $model->find($id)) {
			return view('home/article/view', [
				'item' => $item,
				'page' => $item->category,
			]);
		} else {
			throw new PageNotFoundException();
		}
	}

	public function category($name = null)
	{
		$model = new ArticleModel();
		return view('home/article/list', [
			'data' => $model->withCategory($name)->findAll(),
			'page' => $name,
		]);
	}

	public function search()
	{
		$model = new ArticleModel();
		if ($q = $this->request->getGet('q')) {
			$model->withSearch($q);
		}
		return view('home/article/list', [
			'data' => find_with_filter($model),
			'page' => '',
			'search' => $q,
		]);
	}

	public function uploads($directory, $file)
	{
		$path = WRITEPATH . implode(DIRECTORY_SEPARATOR, ['uploads', $directory, $file]);
		if ($file && is_file($path)) {
			check_etag($path);
			header('Content-Type: ' . mime_content_type($path));
			header('Content-Length: ' . filesize($path));
			readfile($path);
			exit;
		}
		throw new FileNotFoundException();
	}
}
