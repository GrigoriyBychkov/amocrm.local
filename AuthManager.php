<?php

class AuthManager
{
    static function logIn()
    {
        $link = 'https://' . Config::$subdomain . '.amocrm.ru/private/api/auth.php?type=json';
        $curl = CurlManager::getDefaultCurl();
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(Config::$user));
        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
        curl_close($curl); #Завершаем сеанс cURL

        CurlManager::getErrorByCode($code); #Проверка кода ответа сервера

        $Response = json_decode($out, true);

        return isset($Response['response']['auth']);
    }
}