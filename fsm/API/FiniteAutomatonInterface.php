<?php

declare(strict_types=1);

/**
 * Interface for a generic Finite State Machine (FSM).
 *
 * Models the 5-tuple (Q, Σ, q0, F, δ).
 */
interface FiniteAutomatonInterface
{
    /** Reset the automaton back to its initial state. */
    public function reset(): void;

    /**
     * Process a single input symbol.
     *
     * @param string $symbol A symbol from the input alphabet Σ
     * @throws InvalidArgumentException if symbol not in Σ
     */
    public function step(string $symbol): void;

    /**
     * Run the automaton over a full input string.
     *
     * @param string $input Sequence of symbols from Σ
     * @return string Final state after processing input
     */
    public function run(string $input): string;

    /**
     * Check whether the automaton is currently in an accepting state.
     *
     * @return bool True if current state ∈ F
     */
    public function isAccepting(): bool;

    /**
     * Get the current state.
     *
     * @return string The state label
     */
    public function getCurrentState(): string;
}
