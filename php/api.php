
<?php

//array that contains the information needed to calculate the R0 and record the date

$info = array(
    "date" => NULL,
    "casesStart" => NULL,
    "casesEnd" => NULL,
);


//gets a raw csv file and manipulates it to get the wanted information to proceed
//(the specific format of the csv is already excpected)
function csvToData( $cache , &$info) {

    //see how much line there is on the file in order to get, at the same reading, both dates needed
    $count = 0;
    while(!feof($cache)){
        $line = fgets($cache);
        $count++;
    }

    //reading stream goes back to the beggining of the file
    rewind($cache);

    $buf;
    $row_count = 0;
    $field_count = 0;


    /*goes to the final line - 6 and the final line itself,
    stores the date and the cases toll on the vector 'info'*/
    while ($buf = fgets($cache, 65535)) {
        $field_count = 0;
        $row_count++;

        $field = strtok($buf, ",");//divide each line into tokens divided by ",", necessary to handle with .csv
        while ($field) {


            //we count the field to know if we are reading a date or a cases toll
            if ($field_count == 0) {
                // we check if it is a field of the latest day
                if ($row_count == $count){
                    $info["date"] = substr ($field, 5 , 5 ); //just the month and day
                }

            }

            if ($field_count == 1) {
            //this is a cases toll field

                if($row_count == ($count - 6)){//from the previous week
                    $info["casesStart"] = $field;
                } else if ($row_count == $count){//from the latest day
                   $info["casesEnd"] = $field;
                }              
            }


            $field = strtok(",");

            $field_count++;   

        }
    }

}

//calculating r0 based on this brasilian article calculus:
// https://hal.archives-ouvertes.fr/hal-02509142v2/file/epidemie_pt.pdf
function calculateR0($info){
    
    $initial_cases = $info["casesStart"];
    $final_cases = $info["casesEnd"];

    $r0 = $final_cases / $initial_cases;
    $r0 = log($r0);
    $r0 = $r0 / 7;
    $r0 = (1 + $r0/0.25) * ($r0 + 1);

    return $r0;
}


function getR0(){

    //first, open the url provided by the town hall with the wanted .csv file
    //opens also a cache resource in order to rewind the buffer ( resources of external url are not able to do so)
    //copy the url stream to the cache stream
    //then $cache will be at the end of the stream after calling stream_copy_to_stream, so we rewind it 
    $remoteResource = fopen("http://servicos.sorocaba.sp.gov.br/metabase/public/question/c49a0ea6-c617-491c-81d8-3862bcc639f7.csv", "r");
    $cache = fopen('php://temp', 'r+');
    stream_copy_to_stream($remoteResource, $cache);
    rewind($cache);


    if (!$cache) {
        echo "Can't open file";
    }

    csvToData($cache, $info);

    fclose($remoteResource);
    fclose($cache);

    $r0 = calculateR0($info);

    $r0 = sprintf("%.2f", $r0); //formatting the r0

    store_r0($r0, $info);

    return $r0;
}


function store_r0($r0, $info){

    $url = 'r0_values.json'; // path to JSON file
    $data = file_get_contents($url); // put the contents of the file into a variable
    $data = json_decode($data); // decode the JSON feed
 
    $n = $data->n_stored_values; // get the number of previous values calculated in order to add one more at the end of the .json 
    
    if($data->r0[$n]->date == $info['date']){ // just store the newest values if it is a new day

        $data->r0[$n]->date = $info['date']; // goes to the list that contains previous values and add the newest date in the end

        $data->r0[$n]->value = $r0; // does the same but with the r0 number
        $data->n_stored_values += 1; // add one to the counter for the next iteration

        $data = json_encode($data); // encodes the new info to the json format

        file_put_contents($url, $data); // refresh the file
    }

}

?>

