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
        $this->assertEquals($newGame->game_state, 'Love All');
    }

    public function testScoreLoveAppearsAsExpected()
    {
        $newGame = gameService()->createNewGame();

        $updatedGame = gameService()->updateGameScore($newGame->id,0,1);
        $this->assertEquals('Love : Fifteen',$updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id,0,2);
        $this->assertEquals('Love : Thirty',$updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id,0,3);
        $this->assertEquals('Love : Forty',$updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id,1,0);
        $this->assertEquals('Fifteen : Love',$updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id,2,0);
        $this->assertEquals('Thirty : Love',$updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id,3,0);
        $this->assertEquals('Forty : Love',$updatedGame->game_state);

    }

    public function testScoreFifteenAppearsAsExpected()
    {
        $newGame = gameService()->createNewGame();

        $updatedGame = gameService()->updateGameScore($newGame->id,2,1);
        $this->assertEquals('Thirty : Fifteen',$updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id,3,1);
        $this->assertEquals('Forty : Fifteen',$updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id,1,2);
        $this->assertEquals('Fifteen : Thirty',$updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id,1,3);
        $this->assertEquals('Fifteen : Forty',$updatedGame->game_state);

    }

    public function testScoreThirtyAndFortyAppearsAsExpected()
    {
        $newGame = gameService()->createNewGame();

        $updatedGame = gameService()->updateGameScore($newGame->id, 3, 2);
        $this->assertEquals('Forty : Thirty', $updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id, 2, 3);
        $this->assertEquals('Thirty : Forty', $updatedGame->game_state);

    }

    public function testTiedScoresBelowThreeHaveAllAppended()
    {
        $newGame = gameService()->createNewGame();

        $updatedGame = gameService()->updateGameScore($newGame->id, 0, 0);
        $this->assertEquals('Love All', $updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id, 1, 1);
        $this->assertEquals('Fifteen All', $updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id, 2, 2);
        $this->assertEquals('Thirty All', $updatedGame->game_state);

    }

    public function testDeuceIsShownOnAllScoresTiedThreeAndBeyond()
    {
        $newGame = gameService()->createNewGame();

        $updatedGame = gameService()->updateGameScore($newGame->id,3,3);
        $this->assertEquals('Deuce',$updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($updatedGame->id,6,6);
        $this->assertEquals('Deuce',$updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($updatedGame->id,50,50);
        $this->assertEquals('Deuce',$updatedGame->game_state);
    }

    public function testAdvantagePlayerShowsAsExpected()
    {
        $newGame = gameService()->createNewGame();

        $updatedGame = gameService()->updateGameScore($newGame->id,3,4);
        $this->assertEquals('Advantage player 2',$updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id,5,4);
        $this->assertEquals('Advantage player 1',$updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id,21,22);
        $this->assertEquals('Advantage player 2',$updatedGame->game_state);

        $updatedGame = gameService()->updateGameScore($newGame->id,32,31);
        $this->assertEquals('Advantage player 1',$updatedGame->game_state);
    }

    public function testScoreUpdatesPersist()
    {
        $newGame = gameService()->createNewGame();

        $updatedGame = gameService()->updateGameScore($newGame->id,3,4);
        $this->assertEquals(3,$updatedGame->player_1_score);
        $this->assertEquals(4,$updatedGame->player_2_score);
    }
}
