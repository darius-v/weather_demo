<?php

namespace App\Service;

class CurlWrapper
{
    public function get(string $url): string
    {
        $session = curl_init($url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        return curl_exec($session);
    }
}
