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
$tasksCount = 0;
$completed = 0;
$pending = 0;
foreach ($tasks as $task) {
    echo $task['title'] . " - ";
    $tasksCount++;
    if ($task['completed'] === true) {
        $completed++;
        echo "Completed";
    } else {
        $pending++;
        echo "Pending";
    }
    echo "\n";
}
echo "\n";
echo "Total tasks: $tasksCount \n";
echo "Completed: $completed \n";
echo "Pending: $pending \n";