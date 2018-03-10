<?php

class TasksModel
{
    static function createTasksForLeadsWithNoTasks($leadsIds)
    {
        $tasks['request']['tasks']['add'] = array();
        foreach ($leadsIds as $id) {
            array_push($tasks['request']['tasks']['add'], array(
                    'element_id' => $id, #ID сделки
                    'element_type' => 2, #Показываем, что это - сделка, а не контакт
                    'task_type' => 1, #Тип задачи - звонок
                    'text' => 'Сделка без задачи',
                    'complete_till' => strtotime('31-12-2018') #Дата до которой необходимо завершить задачу.
                )
            );
        }

        return $tasks;
    }

    static function addTasks($newTasksRequest)
    {
        #Формируем ссылку для запроса
        $link = 'https://' . Config::$subdomain . '.amocrm.ru/private/api/v2/json/tasks/set';
        $curl = CurlManager::getDefaultCurl();

        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($newTasksRequest));

        $out = curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        CurlManager::getErrorByCode($code); #Проверка кода ответа сервера

        $Response = json_decode($out, true);
        $Response = $Response['response']['tasks']['add'];

        return $Response;
    }
}