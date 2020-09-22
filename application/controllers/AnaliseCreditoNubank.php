<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Phpml\Classification\SVC;
use Phpml\SupportVectorMachine\Kernel;
use Phpml\Classification\MLPClassifier;

class AnaliseCreditoNubank extends CI_Controller {

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
		// $this->load->view('welcome_message');

		$samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
		$labels = ['a', 'a', 'a', 'b', 'b', 'b'];

		$classifier = new SVC(Kernel::LINEAR, $cost = 1000);
		$classifier->train($samples, $labels);

		var_dump($classifier->predict([3, 2]));

		var_dump($classifier->predict([[3, 2], [1, 5]]));

	}

	public function estimativaProbabilidade(){
		
		$samples = [[1, 3], [1, 4], [2, 4], [3, 1], [4, 1], [4, 2]];
		$labels = ['a', 'a', 'a', 'b', 'b', 'b'];

		$classifier = new SVC(
			Kernel::LINEAR, // $kernel
			1.0,            // $cost
			3,              // $degree
			null,           // $gamma
			0.0,            // $coef0
			0.001,          // $tolerance
			100,            // $cacheSize
			true,           // $shrinking
			true            // $probabilityEstimates, set to true
		);

		$classifier->train($samples, $labels);

		var_dump($classifier->predictProbability([3, 2]));
		var_dump($classifier->predictProbability([[3, 2], [1, 5]]));

	}

	public function redeNeuralArtificial(){

		for($i = 0; $i < 10 ; $i ++){

			$mlp = new MLPClassifier(6, [5], ['a', 'b', 'c']);

			$mlp->train(
				$samples = [
					[1,1,1,1,1,1],
					[1,1,0,1,0,1],
					[1,1,0,1,0,0],
					[1,1,0,0,1,0],
					[1,0,1,1,1,1],
					[1,0,1,1,0,1],
					[1,0,1,1,0,0],
					[1,0,1,0,1,0],
					[1,0,1,0,0,0],
					[1,0,0,1,0,0],
					[1,0,0,0,1,1],
					[1,0,0,0,0,1],
					[0,1,1,1,0,1],
					[0,1,1,1,0,0],
					[0,1,1,0,0,0],
					[0,1,0,1,1,1],
					[0,1,0,0,1,0],
					[0,1,0,0,0,1],
					[0,0,1,1,0,0],
					[0,0,1,0,0,0],
					[0,0,0,0,0,0],
					[0,0,1,0,1,0]],

				$targets = ['a','a','a','a','a','a','b','b','b','b','b','b','b','b','b','c','c','c','c','c','c','c']
			);

			$var1 = random_int(0,1);
			$var2 = random_int(0,1);
			$var3 = random_int(0,1);
			$var4 = random_int(0,1);
			$var5 = random_int(0,1);
			$var6 = random_int(0,1);

			echo "-------------------------<br/>";
			echo "Dados recebidos do cliente:";
			echo $var1;
			echo $var2;
			echo $var3;
			echo $var4;
			echo $var5;
			echo $var6;

			echo "<br/>";

			echo "Classificação do cliente:" . ($mlp->predict([[
				$var1,
				$var2,
				$var3,
				$var4,
				$var5,
				$var6,
			]]))[0];

			echo "<br/>-------------------------<br/>";
		}

	}
}





