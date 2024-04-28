<?php

namespace App\Controllers;

use App\Entities\User as EntitiesUser;
use App\Models\UserModel;
use App\Entities\FinancialPerformance;
use App\Models\FinancialPerformanceModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;
use Dompdf\Dompdf;
use Dompdf\Options;

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
		$model = new FinancialPerformanceModel();
		// $test = $model->where('tahun', 2020)->countAllResults();
		if ($model->where('tahun', '2005')->countAllResults() > 0) {
		  echo '
        <script>
            alert("Duplicate years exist");
            window.location="'.base_url('/user/finance/').'";
        </script>';
		}
		// var_dump($test);
		// var_dump($method);

		if ($this->login->role !== 'admin') {
			$model->withUser($this->login->id);
		}
		if ($this->request->getMethod() === 'post') {
			if ($page === 'delete' && $model->delete($id)) {
				return $this->response->redirect('/user/finance/');
			} else {
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
					'data' => get_financial_performance($model),
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
			case 'generate_pdf':
				return $this->generateFinanceDatasToPdf();
		}
		throw new PageNotFoundException();
	}
	public function getChartUrlEncoded($financial_performance) {
		
		$chart_datas = array();
		$tahun = array();
		$penjualan_neto = array();
		$laba_tahun_berjalan = array();
		$total_aset = array();
		$hasil_dividen = array();
		
		for ($i = 0; $i < count($financial_performance); $i++) {
			array_push($tahun,  $financial_performance[$i]->tahun);
			array_push($penjualan_neto,  $financial_performance[$i]->penjualan_neto);
			array_push($laba_tahun_berjalan,  $financial_performance[$i]->laba_tahun_berjalan);
			array_push($total_aset,  $financial_performance[$i]->total_aset);
			array_push($hasil_dividen,  $financial_performance[$i]->hasil_dividen);
		}

		$chart_datas['tahun'] = $tahun;
		$chart_datas['penjualan_neto'] = $penjualan_neto;
		$chart_datas['laba_tahun_berjalan'] = $laba_tahun_berjalan;
		$chart_datas['total_aset'] = $total_aset;
		$chart_datas['hasil_dividen'] = $hasil_dividen;

		return $this->getImageUrls($chart_datas);
	}

	public function saveChartImage($chart_url_encodes) {
		
		$image_urls = array();
		$client = \Config\Services::curlrequest([
			'baseURI' => 'https://quickchart.io/',
		]);

		// get all url path saved local image file
		for ($i=0; $i < count($chart_url_encodes); $i++) {

			$relative_path = 'public/uploads/charts/';
			$image_name = 'chart-' . date('YmdHis') . '.png';
			$full_path = ROOTPATH . $relative_path . $image_name;

			$response = $client->get($chart_url_encodes[$i]);
			$file = $response->getBody();
			
			if (file_put_contents($full_path, $file)) {
				chmod($full_path, 0777);
				array_push($image_urls, str_replace("public/", "", $relative_path) . $image_name);
			}
		}
		return $image_urls;
	}

	public function generateFinanceDatasToPdf() {
		$model = new FinancialPerformanceModel();
		$financial_performance = get_financial_performance($model);
		
		$chart_url_encodes = $this->getChartUrlEncoded($financial_performance);
		$image_urls = $this->saveChartImage($chart_url_encodes);
		
		$options = new Options();
		$paper = 'A4';
		$orientation = "landscape";
		$options->set('isRemoteEnabled', true);
		
		$dompdf = new Dompdf($options);
		$dompdf->setPaper($paper, $orientation);
		
		$html = view('user/finance/financial_performance', [
			'financial_performance' => $financial_performance,
			'image_urls' => $image_urls
		]);

		$dompdf->loadHtml($html);
	  	$dompdf->render();
	  
		$filename = "financial_performance_".date('YmdHis').".pdf";
		ob_end_clean();
		$dompdf->stream($filename, array('Attachment' => FALSE));
	}

	public function getImageUrls($chart_datas) {
		$image_urls = array();
		
		$tahun = $chart_datas['tahun'];
		$penjualan_neto = $chart_datas['penjualan_neto'];
		$laba_tahun_berjalan = $chart_datas['laba_tahun_berjalan'];
		$total_aset = $chart_datas['total_aset'];
		$hasil_dividen = $chart_datas['hasil_dividen'];


		$background_color = [
			"rgba(255, 99, 132, 0.2)",
			"rgba(54, 162, 235, 0.2)",
			"rgba(255, 206, 86, 0.2)",
			"rgba(75, 192, 192, 0.2)",
			"rgba(153, 102, 255, 0.2)"
		];

		$border_color = [
			"rgba(255,99,132,1)",
			"rgba(54, 162, 235, 1)",
			"rgba(255, 206, 86, 1)",
			"rgba(75, 192, 192, 1)",
			"rgba(153, 102, 255, 1)"
		];

		$border_width = 1;
		$begin_at_zero = true;

		// Penjualan Neto
		$penjualan_neto_chart = '{
			"type": "bar",
			"data": {
				"labels": ' . json_encode($tahun) . ',
				"datasets": [{
					"label": "# Penjualan Neto",
					"data": ' . json_encode($penjualan_neto) . ',
					"backgroundColor": ' . json_encode($background_color) . ',
					"borderColor": ' . json_encode($border_color) . ',
					"borderWidth": ' . $border_width . ',
				}]
			},
			"options": {
				"scales": {
					"y": {
						"beginAtZero": ' . $begin_at_zero . '
					}
				}
			}
		}';
		$encoded = urlencode($penjualan_neto_chart);
		$penjualan_neto_image_url = "chart?c=" . $encoded;
		array_push($image_urls, $penjualan_neto_image_url);
		
		// Laba Tahun Berjalan
		$laba_tahun_berjalan_chart = '
		{
			"type": "bar",
			"data": {
				"labels": ' . json_encode($tahun) . ',
				"datasets": [{
					"label": "# Laba Tahun Berjalan",
					"data": ' . json_encode($laba_tahun_berjalan) . ',
					"backgroundColor": ' . json_encode($background_color) . ',
					"borderColor": ' . json_encode($border_color) . ',
					"borderWidth": ' . $border_width . ',
				}]
			},
			"options": {
				"scales": {
					"y": {
						"beginAtZero": ' . $begin_at_zero . '
					}
				}
			}
		}';
		$encoded = urlencode($laba_tahun_berjalan_chart);
		$laba_tahun_berjalan_image_url = "chart?c=" . $encoded;
		array_push($image_urls, $laba_tahun_berjalan_image_url);
		
		// Total Aset
		$total_aset_chart = '
		{
			"type": "bar",
			"data": {
				"labels": ' . json_encode($tahun) . ',
				"datasets": [{
					"label": "# Total Aset",
					"data": ' . json_encode($total_aset) . ',
					"backgroundColor": ' . json_encode($background_color) . ',
					"borderColor": ' . json_encode($border_color) . ',
					"borderWidth": ' . $border_width . ',
				}]
			},
			"options": {
				"scales": {
					"y": {
						"beginAtZero": ' . $begin_at_zero . '
					}
				}
			}
		}';
		$encoded = urlencode($total_aset_chart);
		$total_aset_image_url = "chart?c=" . $encoded;
		array_push($image_urls, $total_aset_image_url);
		
		// Hasil Dividen
		$hasil_dividen_chart = '
		{
			"type": "bar",
			"data": {
				"labels": ' . json_encode($tahun) . ',
				"datasets": [{
					"label": "# Hasil Dividen",
					"data": ' . json_encode($hasil_dividen) . ',
					"backgroundColor": ' . json_encode($background_color) . ',
					"borderColor": ' . json_encode($border_color) . ',
					"borderWidth": ' . $border_width . ',
				}]
			},
			"options": {
				"scales": {
					"y": {
						"beginAtZero": ' . $begin_at_zero . '
					}
				}
			}
		}';
		$encoded = urlencode($hasil_dividen_chart);
		$hasil_dividen_image_url = "chart?c=" . $encoded;
		array_push($image_urls, $hasil_dividen_image_url);
		
		return $image_urls;
	}

}
