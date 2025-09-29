<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../Controller/FiniteAutomaton.php'; 

final class FiniteAutomatonTest extends TestCase
{
    private FiniteAutomaton $fsm;

    protected function setUp(): void
    {
        // Example: Mod-Three FSM
        $states = ['S0', 'S1', 'S2'];
        $alphabet = ['0', '1'];
        $initialState = 'S0';
        $finalStates = ['S0', 'S1', 'S2']; // all states accepting
        $transitions = [
            'S0' => ['0' => 'S0', '1' => 'S1'],
            'S1' => ['0' => 'S2', '1' => 'S0'],
            'S2' => ['0' => 'S1', '1' => 'S2'],
        ];

        $this->fsm = new FiniteAutomaton($states, $alphabet, $initialState, $finalStates, $transitions);
    }

    public function testInitialStateIsCorrect(): void
    {
        $this->assertSame('S0', $this->fsm->getCurrentState());
    }

    public function testStepValidTransition(): void
    {
        $this->fsm->step('1'); // from S0 → S1
        $this->assertSame('S1', $this->fsm->getCurrentState());
    }

    public function testStepInvalidSymbolThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->fsm->step('2'); // invalid symbol
    }

    public function testRunTransitionsCorrectly(): void
    {
        $final = $this->fsm->run('1010'); // Example 2 from the description
        $this->assertSame('S1', $final);
    }

    public function testResetBringsBackToInitial(): void
    {
        $this->fsm->step('1'); // S0 → S1
        $this->fsm->reset();
        $this->assertSame('S0', $this->fsm->getCurrentState());
    }

    public function testIsAcceptingReturnsTrueForAllStates(): void
    {
        $this->assertTrue($this->fsm->isAccepting()); // S0 is accepting
        $this->fsm->step('1'); // move to S1
        $this->assertTrue($this->fsm->isAccepting());
    }

    public function testConstructorRejectsInvalidInitialState(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FiniteAutomaton(
            ['A', 'B'],
            ['0'],
            'X',   // invalid initial state
            ['A'],
            ['A' => ['0' => 'B'], 'B' => ['0' => 'A']]
        );
    }

    public function testConstructorRejectsInvalidFinalState(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new FiniteAutomaton(
            ['A', 'B'],
            ['0'],
            'A',
            ['C'], // invalid final state
            ['A' => ['0' => 'B'], 'B' => ['0' => 'A']]
        );
    }
}
