<?php

require_once __DIR__ . '/../fsm/Controller/FiniteAutomaton.php';

// Define Mod-Three FSM
$states       = ["S0", "S1", "S2"];
$alphabet     = ["0", "1"];
$initialState = "S0";
$finalStates  = ["S0", "S1", "S2"]; // all states are accepting
$transitions  = [
    "S0" => ["0" => "S0", "1" => "S1"],
    "S1" => ["0" => "S2", "1" => "S0"],
    "S2" => ["0" => "S1", "1" => "S2"],
];

// Build FA
$modThreeFA = new FiniteAutomaton(
    $states,
    $alphabet,
    $initialState,
    $finalStates,
    $transitions
);

// Test 6->0, 10->1, 9->0, 3->0, 0->0, 11->2
$tests = ["110", "1010", "1001", "11", "0", "1011"]; 

foreach ($tests as $input) {
    $finalState = $modThreeFA->run($input);

    echo "Input: $input → Final State: $finalState → Remainder: "
        . substr($finalState, 1) // extract number from S0/S1/S2
        . "<br>";
}
