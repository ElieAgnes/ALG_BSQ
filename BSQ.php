<?php

function game($array){
    $y = 0;
    $x = 0;

    $countArrayX = [];
    $countArrayY = [];
    while(isset($array[$y][0])){
    $count = 0;
    $countScan = [];
        while(isset($array[$y][$x])){
            if($array[$y][$x] == '.'){
                $count++;
            }
            elseif ($array[$y][$x] == 'o' && $x == 0) {
                
            } else {

                if (isset($countArrayX[$count])){
                    array_push($countArrayX[$count], [($x - $count) , $y]);
                } else {
                    $countArrayX[$count] = [[($x - $count),$y]];
                }

                $count = 0;
            }
            $x++;
        }

        if (isset($countArrayX[$count])){
            array_push($countArrayX[$count], [($x - $count),$y]);
        } else {
            $countArrayX[$count] = [[($x - $count),$y]];
        }
        
        $x = 0;
        $y++;
    }


    krsort($countArrayX);    
    $y = 0;

    // Cherche la plus grande valeur de '.' sur Y
    while(isset($array[0][$x])){
        $count = 0;
        while(isset($array[$y][$x])){
            if($array[$y][$x] == '.'){
                $count++;
            }
            elseif ($array[$y][$x] == 'o' && $y == 0) {
                
            } else {
                

                if (isset($countArrayY[$count])){
                    array_push($countArrayY[$count], [$y - $count, ($x)]);
                } else {
                    $countArrayY[$count] = [[$y - $count, ($x)]];
                }
                $count = 0;
            }
            $y++;
        }

        if (isset($countArrayY[$count])){
            array_push($countArrayY[$count], [$y - $count, ($x)]);
        } else {
            $countArrayY[$count] = [[$y - $count, ($x)]];
        }
        $y = 0;
        $x++;
}
    krsort($countArrayY);

    $maxX = array_key_first ($countArrayX);
    $maxY = array_key_first ($countArrayY);

    if ($maxX >= $maxY){
        $count = $maxY;
    } else {
        $count = $maxX;
    } 
    $x = 0;
    $y = 0;
    $notFound = true;
    $trueValue = [];

    while ($count > 1 && $notFound){
        $testMax = ($count * $count);

        while(isset($array[$y][$x]) && $notFound){
            while(isset($array[$y][$x]) && $notFound){
                if($array[$y][$x] == '.'){
                    $trueValue = [];
                    array_push($trueValue , ['x' => $x, 'y' => $y]);
                    $test = 1;
                    $testX = $x + 1;
                    $testY = $y;
                    $testLigne = 1;

                    while(isset($array[$testY][$testX]) && $test <= $testMax){
                        $test++;

                        if ($array[$testY][$testX] == '.' && $test === $testMax){
                            array_push($trueValue , ['x' => $testX, 'y' => $testY]);
                            $notFound = false;
                            break;
                        }
                        if ($array[$testY][$testX] == 'o' or $test === $testMax){
                            break;
                        }
                        if ($array[$testY][$testX] == '.'){
                            array_push($trueValue , ['x' => $testX, 'y' => $testY]);
                            $testX++;
                            $testLigne++;
                            if ($testLigne == $count) {
                                $testX = $x;
                                $testY++;
                                $testLigne = 0;
                            } 
                        }
                    }
                }
                $x++;
            }
            $x = 0;
            $y++;
        }
        $y = 0;
        $count--;
    }

    if ($count == 1 && $notFound){ //Si pas de carré trouvé
        $trueValue = [];
        $y = 0;
        $x = 0;
        while(isset($array[$y][$x]) && $notFound){
            while(isset($array[$y][$x]) && $notFound){
                if($array[$y][$x] == '.'){
                    $notFound = false;
                    array_push($trueValue , ['x' => $x, 'y' => $y]);
                    break;
                }
                $x++;
            }
            $y++;
        }
    }
    
    foreach ($trueValue as $value){
       $array[$value['y']][$value['x']] = "x" ;
    }

    $y = 0;
    $x = 0;
    while(isset($array[$y][$x])){
        while(isset($array[$y][$x])){
             echo $array[$y][$x];
            $x++;
        }
         echo "\n";
        $x = 0;
        $y++;
    }
}

for ($y = 1; $y < count($argv) ; $y++){ 
    if (is_file($argv[$y])){
        $file = file_get_contents( $argv[$y]);
        $content = explode("\n", $file);
        unset($content[0]);

        $plateau = [];

        for ($i=1; $i <= count($content) ; $i++){
            $content[$i] = str_replace("", "\n", $content[$i]);
            $content[$i] = str_split($content[$i]);
            if(array_key_last($content) !== $i){
                unset($content[$i][count($content[$i]) -1]);
            }

            array_push($plateau,$content[$i]);
        }     
        game($plateau);
        echo "\n";
    }
}