<?php

class LeadsModel
{
    static function getIdsOfLeadsWithNoTasks()
    {
        $leadsList = self::getAllLeads();
        if (count($leadsList) == 0) {
            return [];
        }

        $leadsId = array();

        if (isset($leadsList['leads'])) {
            foreach ($leadsList['leads'] as $leads) {
                if (is_array($leads) && isset($leads['id'])) {
                    if ($leads['closest_task'] == 0) {
                        $leadsId[] = $leads['id'];
                    }
                } else {
                    die('Can not get transaction ID');
                }
            }
        } else {
            die('can not get deals list');
        }

        return $leadsId;
    }

    static function getAllLeads()
    {
        $link = 'https://' . Config::$subdomain . '.amocrm.ru/private/api/v2/json/leads/list';
        $curl = CurlManager::getDefaultCurl();
        curl_setopt($curl, CURLOPT_URL, $link);
        $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
        curl_close($curl); #Завершаем сеанс cURL
        CurlManager::getErrorByCode($code); #Проверка кода ответа сервера

        $Response = json_decode($out, true);

        return $Response['response'];
    }
}