<?php

namespace App\Helpers;

use DB;
use File;

class Helper {
	public static function apiData($url) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          // echo "cURL Error #:" . $err;
        } else {
          // echo $response;
        }
        /*
         *  After receiving api data for faster performance (and if the data is not too large) we can store it in our side
         *	This time as we have a pagination we just keep the data as it is.
         */
        return $response;
	}	
}