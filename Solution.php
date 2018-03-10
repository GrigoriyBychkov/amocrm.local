<?php
require 'config.php';
require 'CurlManager.php';
require 'AuthManager.php';
require 'LeadsModel.php';
require 'TasksModel.php';

class Solution
{
    static function createTasksForLeadsWithoutTasks()
    {
        $result['result'] = false;
        $result['message'] = '';

        if (AuthManager::logIn()) {
            $leadsIds = LeadsModel::getIdsOfLeadsWithNoTasks();
            if (count($leadsIds) == 0) {
                $result['message'] = 'No leads without tasks';
                return $result;
            }

            $newTasksRequest = TasksModel::createTasksForLeadsWithNoTasks($leadsIds);
            $addTasksResult = TasksModel::addTasks($newTasksRequest);

            $result['result'] = true;
            $result['message'] = $addTasksResult;

            return $result;
        } else {
            $result['result'] = false;
            $result['message'] = 'Unauthorized';

            return $result;
        }
    }
}

$res = Solution::createTasksForLeadsWithoutTasks();


print_r($res);
