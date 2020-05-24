<html>
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>

        <?php

        
            //array that contains the information needed to calculate the R0 and record the date

            $info = array(
                "date" => NULL,
                "cases0" => NULL,
                "cases1" => NULL,
            );


            
            //gets a raw csv file and manipulates it to get the wanted information to proceed
            //(the specific format of the csv is already excpected)
            function csvToData( $handle , &$info) {

                //see how much line there is on the file in order to get, at the same reading, both dates needed
                $count = 0;
                while(!feof($handle)){
                    $line = fgets($handle);
                    $count++;
                }

                //reading stream goes back to the beggining of the file
                rewind($handle);

                $buf;
                $row_count = 0;
                $field_count = 0;


                /*goes to the final line - 6 and the final line itself,
                stores the date and the cases toll on the vector 'info'*/
                while ($buf = fgets($handle, 65535)) {
                    $field_count = 0;
                    $row_count++;

                    $field = strtok($buf, ",");//divide each line into tokens divided by ",", necessary to handle with .csv
                    while ($field) {


                        //we count the field to know if we are reading a date or a cases toll
                        if ($field_count == 0) {
                            // we check if it is a field of the latest day
                            if ($row_count == $count - 1){ //unexpected error if using count without subtracting 1
                                $info["date"] = substr ($field, 5 , 5 ); //just the month and day
                            }

                        }

                        if ($field_count == 1) {
                        //this is a cases toll field

                            if($row_count == ($count - 7)){//from the previous week
                                $info["cases0"] = $field;
                            } else if ($row_count == $count - 1){//from the latest day
                               $info["cases1"] = $field;
                            }              
                        }


                        $field = strtok(",");

                        $field_count++;   

                    }
                }


                fclose($handle);

            }

            //calculating r0 based on this brasilian article calculus:
            // https://hal.archives-ouvertes.fr/hal-02509142v2/file/epidemie_pt.pdf
            function rCalculus($info){
                
                $initial_cases = $info["cases0"];
                $final_cases = $info["cases1"];

                $r0 = $final_cases / $initial_cases;
                $r0 = log($r0);
                $r0 = $r0 / 7;
                $r0 = (1 + $r0/0.25) * ($r0 + 1);

                return $r0;
            }




            $handle = fopen("input.csv", "r");

            if (!$handle) {
                echo "Can't open file";
            }

            csvToData($handle, $info);

            $r0 = rCalculus($info);

            $r0 = sprintf("%.2f", $r0);

            echo "R0 em Sorocaba no dia ", $info["date"], " é: ", $r0;
        


        ?>

    </body>

</html>
