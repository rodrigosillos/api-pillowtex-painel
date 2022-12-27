<?php

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

function CallAPI($method, $url, $server = 'novo', $data = false)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
    curl_setopt($curl, CURLOPT_USERPWD, "pillowtex.ip.odhserver.com\\Pillowtex:P!Ll0w.021!");

    $serverFix = '';
    if($server == 'novo')
        $serverFix = '!pillow';

    curl_setopt($curl, CURLOPT_URL, 'http://pillowtex.ip.odhserver.com:6017/api/millenium'. $serverFix . '/' . $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
