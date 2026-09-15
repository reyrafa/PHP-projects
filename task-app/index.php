<?php
$tasks = [
    [
        "title" => "Learn PHP",
        "completed" => true,
    ],
    [
        "title" => "Learn Laravel",
        "completed" => false,
    ],
    [
        "title" => "Build API",
        "completed" => false,
    ],
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