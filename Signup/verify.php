<?php include('db_conn.php');
    $query = "SELECT indosno, dob FROM Sign_up_entry WHERE verified IS NULL";
    $results = mysqli_query($db, $query);
    $sysdate = gmdate("d/m/Y");
    $sysdate = urlencode($sysdate);
    if (mysqli_num_rows($results) > 0) {
        while($row = mysqli_fetch_assoc($results)) {
            $indosno = $row["indosno"];
            $dob = $row["dob"];
            $dob = str_replace('-"', '/', $dob);  
            $dob = date("d/m/Y", strtotime($dob)); 
            $dob = urlencode($dob);
            $url = "http://220.156.189.33/esamudraUI/jsp/examination/checker/COCSearchDetails.jsp?hidSystemDate=$sysdate&txtNo=$indosno&txtDob=$dob";
            $client = file_get_contents($url);
            $pos = strpos($client, 'Seafarer Details', 0);
            if ($pos) {
                $query2 = "UPDATE Sign_up_entry SET verified=1 WHERE indosno='$indosno'"; 
                mysqli_query($db, $query2)or die(mysqli_error($db));
                echo "one ".$indosno;
            }
            else {
                $query2 = "UPDATE Sign_up_entry SET verified=0 WHERE indosno='$indosno'"; 
                mysqli_query($db, $query2)or die(mysqli_error($db));
                echo "Zero ".$indosno;
            }
        }
    }  
    
?>