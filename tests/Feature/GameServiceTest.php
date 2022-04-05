<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GameServiceTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateNewGameHasExpectedStartingState()
    {
        $newGame = gameService()->createNewGame();
        $this->assertEquals($newGame->player_1_score, 0);
        $this->assertEquals($newGame->player_2_score, 0);
        $this->assertEquals($newGame->game_state, 'started');
    }
}
