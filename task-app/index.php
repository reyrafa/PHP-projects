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

function countTasks(array $tasks): int
{
    $tasksCount = 0;
    foreach ($tasks as $task) {
        $tasksCount++;
    }
    return $tasksCount;
}
function countCompleted(array $tasks): int
{
    $completed = 0;
    foreach ($tasks as $task) {
        if($task['completed'] === true){
            $completed++;
        }
    }
    return $completed;
}
function countPending(array $tasks): int
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

$tasksCount = countTasks($tasks);
$completed = countCompleted($tasks);
$pending = countPending($tasks);
echo "Total tasks: $tasksCount \n";
echo "Completed: $completed \n";
echo "Pending: $pending \n";