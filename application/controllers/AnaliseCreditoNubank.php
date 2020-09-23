<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AnaliseCreditoNubank extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model("AnaliseCreditoNubankModel");
    }

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index(){

		$samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
		$labels = ['a', 'a', 'a', 'b', 'b', 'b'];

		$classifier = new SVC(Kernel::LINEAR, $cost = 1000);
		$classifier->train($samples, $labels);

		var_dump($classifier->predict([3, 2]));

		var_dump($classifier->predict([[3, 2], [1, 5]]));

	}

	
	public function redeNeuralArtificial(){

		if($this->AnaliseCreditoNubankModel->redeNeuralArtificial() === "a"){
			print_r( array("Aprovado" => true, "LimiteDisponível" => $this->estimativaLimite() ));
		} else {
			print_r( array("Aprovado" => false, "LimiteDisponível" => 0));
		}


	}

	private function estimativaLimite(){
		return $this->AnaliseCreditoNubankModel->estimativaLimite();

	}

}





