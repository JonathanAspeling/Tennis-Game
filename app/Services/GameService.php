<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameService
{

    private int $player_1_score;
    private int $player_2_score;

    /**
     * @return Game
     */
    public function createNewGame(): Game
    {
        return Game::create([
            'player_1_score' => 0,
            'player_2_score' => 0,
            'game_state' => 'Love All'
        ]);
    }


    /**
     * @param int $gameID
     * @param int $player_1_score
     * @param int $player_2_score
     * @return Game
     */
    public function updateGameScore(int $gameID, int $player_1_score, int $player_2_score): Game
    {
        $activeGame = Game::find($gameID);
        $activeGame->player_1_score = $this->player_1_score = $player_1_score;
        $activeGame->player_2_score = $this->player_2_score = $player_2_score;
        $activeGame->game_state = $this->decideState($player_1_score, $player_2_score);
        $activeGame->save();
        return $activeGame;
    }

    public function decideState(int $player_1_score, int $player_2_score) :string
    {
        $stateName = '';
        if ($this->gameTiedBelowThreePoints()) {
            $stateName .= $this->getPlayerScoreTennisName($player_1_score) . ' All';
        }

        if ($this->gameNotTiedBelowThreePoints()) {
            $stateName .=
                $this->getPlayerScoreTennisName($player_1_score) .
                ' : ' .
                $this->getPlayerScoreTennisName($player_2_score);
        }

        if ($this->gameStateShouldBeDeuce()) {
            $stateName .= 'Deuce';
        }

        if ($this->gameIsInAdvantageState()) {
            $stateName .= $this->getAdvantagePlayerString();
        }

        if ($this->gameIsComplete()) {
            $stateName .= $this->getWinningPlayerString();
        }

        return $stateName;
    }

    private function getPlayerScoreTennisName(int $player_score)
    {
        switch ($player_score) {
            case 0:
                return 'Love';
            case 1:
                return 'Fifteen';
            case 2:
                return 'Thirty';
            case 3:
                return 'Forty';
            default:
                return '{error}';
        }
    }

    private function gameTiedBelowThreePoints(): bool
    {
        return $this->player_1_score == $this->player_2_score && (!$this->gameInTieBreakMode());
    }

    private function gameStateShouldBeDeuce(): bool
    {
        return $this->player_1_score == $this->player_2_score
            && ($this->gameInTieBreakMode());
    }

    private function gameNotTiedBelowThreePoints(): bool
    {
        return $this->player_1_score != $this->player_2_score
            && (!$this->gameInTieBreakMode())
            && $this->player_1_score < 4
            && $this->player_2_score < 4;
    }

    private function gameIsInAdvantageState(): bool
    {
        return (abs($this->player_1_score - $this->player_2_score) == 1)
            && ($this->player_1_score >3 || $this->player_2_score >3);
    }

    private function getAdvantagePlayerString(): string
    {
        return $this->player_1_score - $this->player_2_score > 0
        ? 'Advantage player 1'
        : 'Advantage player 2';

    }

    private function gameIsComplete(): bool
    {
        return ((abs($this->player_1_score - $this->player_2_score) >= 2)
            && ($this->gameInTieBreakMode()))
            || ((abs($this->player_1_score - $this->player_2_score) >= 2)
                && ($this->player_1_score >= 4 || $this->player_2_score >= 4));
    }

    private function getWinningPlayerString(): string
    {
        return $this->player_1_score - $this->player_2_score > 0
            ? 'Player 1 wins'
            : 'Player 2 wins';
    }

    private function gameInTieBreakMode(): bool
    {
        return $this->player_1_score >=3 && $this->player_2_score >=3 && $this->player_1_score == $this->player_2_score;
    }


}