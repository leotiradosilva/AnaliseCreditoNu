<?php

use Phpml\Classification\MLPClassifier;
use Phpml\Regression\LeastSquares;


class AnaliseCreditoNubankModel extends CI_Model{

    public function index(){
        echo "teste";
    }
    
    public function estimativaLimite(){
        $samples = [[73676, 1996], [77006, 1998], [10565, 2000], [146088, 1995], [15000, 2001], [65940, 2000], [9300, 2000], [93739, 1996], [153260, 1994], [17764, 2002], [57000, 1998], [15000, 2000]];
        $targets = [2000, 2750, 15500, 960, 4400, 8800, 7100, 2550, 1025, 5900, 4600, 4400];

        $regression = new LeastSquares();
        $regression->train($samples, $targets);
        return $regression->predict([random_int(5000,99999), random_int(1990,2010)]);

        
    }

    public function redeNeuralArtificial(){

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

            $targets = ['a','a','a','a','a','a','a','a','a','a','b','b','b','b','b','b','b','b','b','b','b','b']
        );

        $var1 = random_int(0,1);
        $var2 = random_int(0,1);
        $var3 = random_int(0,1);
        $var4 = random_int(0,1);
        $var5 = random_int(0,1);
        $var6 = random_int(0,1);

        return ($mlp->predict([[
            $var1,
            $var2,
            $var3,
            $var4,
            $var5,
            $var6,
        ]]))[0];


	}





}
