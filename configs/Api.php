<?php

class Api
{

    /**
     * A function that makes a request to the API.
     *
     * @param url The URL of the API endpoint you're trying to access.
     * @param type The type of request you want to make. This can be GET, POST, PUT, PATCH, or DELETE.
     * @param httpheader This is the header of the request. It's an array of strings.
     * @param put The data you want to send to the API.
     *
     * @return The response from the API.
     */
    private function request($url, $type, $httpheader, $put)
    {
        $curl = curl_init();

        $keyCurl = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_HTTPHEADER => $httpheader,
        );

        if ($type == 'PUT' || $type == 'PATCH' || $type == 'POST')
            $keyCurl[CURLOPT_POSTFIELDS] = $put;

        curl_setopt_array($curl, $keyCurl);


        $response = curl_exec($curl);
        echo curl_error($curl);
        // echo $response;
        curl_close($curl);
        $data = json_decode($response, true);

        return $data;
    }

    /**
     * It takes a url, a type (GET, POST, PUT, DELETE), an array of headers, and an array of data. It then returns the
     * response from the API
     *
     * @param url The url of the API you want to call.
     * @param type GET, POST, PUT, DELETE
     * @param data the data you want to send to the API.
     *
     * @return The request is being returned.
     */
    public function requestApi($url, $type , $data)
    {

        $httpheader=array(
            'X-Riot-Token: RGAPI-63e4bbce-c11d-4324-9171-9ed19c0d8e1e',
        );

        return $this->request($url, $type, $httpheader,$data);
    }
    
}
