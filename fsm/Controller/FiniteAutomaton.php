<?php

declare(strict_types=1);

require_once __DIR__ . '/../API/FiniteAutomatonInterface.php';


/**
 * Generic FSM library
 */
class FiniteAutomaton implements FiniteAutomatonInterface
{
    private array $states;        // Q
    private array $alphabet;      // Σ
    private string $initialState; // q0
    private array $finalStates;   // F
    private array $transitions;   // δ
    private string $currentState;

    /**
     * @param array<string> $states
     * @param array<string> $alphabet
     * @param string $initialState
     * @param array<string> $finalStates
     * @param array<array<string,string>> $transitions
     */
    public function __construct(
        array $states,
        array $alphabet,
        string $initialState,
        array $finalStates,
        array $transitions
    ) {
        // Validation
        if (!in_array($initialState, $states, true)) {
            throw new InvalidArgumentException("Initial state must be in the set of states.");
        }
        
        foreach ($finalStates as $f) {
            if (!in_array($f, $states, true)) {
                throw new InvalidArgumentException("Final states must be a subset of states.");
            }
        }

        $this->states = $states;
        $this->alphabet = $alphabet;
        $this->initialState = $initialState;
        $this->finalStates = $finalStates;
        $this->transitions = $transitions;
        $this->currentState = $initialState;
    }

    /** Reset automaton to initial state */
    public function reset(): void
    {
        $this->currentState = $this->initialState;
    }

    /** Process a single symbol σ ∈ Σ */
    public function step(string $symbol): void
    {
        if (!in_array($symbol, $this->alphabet, true)) {
            throw new InvalidArgumentException("Invalid symbol: $symbol");
        }

        $this->currentState = $this->transitions[$this->currentState][$symbol];
    }

    /** Process an entire input string */
    public function run(string $input): string
    {
        $this->reset();

        foreach (str_split($input) as $symbol) {
            $this->step($symbol);
        }

        return $this->currentState;
    }

    /** Check if the current state is accepting */
    public function isAccepting(): bool
    {
        return in_array($this->currentState, $this->finalStates, true);
    }

    /** Get current state */
    public function getCurrentState(): string
    {
        return $this->currentState;
    }
}



