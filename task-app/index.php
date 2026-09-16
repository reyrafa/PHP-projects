<?php
$tasks = [
    [
        "title" => "Learn PHP",
        "completed" => true,
    ],
    [
        "title" => "Learn Laravel",
        "completed" => true,
    ],
    [
        "title" => "Build API",
        "completed" => false,
    ],
    [
        "title" => "Learn Docker",
        "completed" => false
    ]
];
foreach ($tasks as $task) {
    echo $task['title'] . " - ";
    if ($task['completed'] === true) {
        echo "Completed";
    } else {
        echo "Pending";
    }
    echo "\n";
}

function countTotalTasks(array $tasks): int
{
    $tasksCount = 0;
    foreach ($tasks as $task) {
        $tasksCount++;
    }
    return $tasksCount;
}
function countCompletedTasks(array $tasks): int
{
    $completed = 0;
    foreach ($tasks as $task) {
        if($task['completed'] === true){
            $completed++;
        }
    }
    return $completed;
}
function countPendingTasks(array $tasks): int
{
    $pending = 0;
    foreach ($tasks as $task) {
       if($task['completed'] !== true){
            $pending++;
        }
    }
    return $pending;
}
echo "\n";

$tasksCount = countTotalTasks($tasks);
$completed = countCompletedTasks($tasks);
$pending = countPendingTasks($tasks);
echo "Total tasks: $tasksCount \n";
echo "Completed: $completed \n";
echo "Pending: $pending \n";

require_once 'Task.php';
$task = new Task("Learn Laravel", false);
echo $task->getStatus();
$task->complete();
echo $task->getStatus();