<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameService
{

    public function createNewGame(): Game
    {
        return Game::create([
            'player_1_score' => 0,
            'player_2_score' => 0,
            'game_state' => 'Love All'
        ]);
    }

    public function updateGameScore(int $gameID, int $player_1_score, int $player_2_score): Game
    {
        $activeGame = Game::find($gameID);
        $activeGame->player_1_score = $player_1_score;
        $activeGame->player_2_score = $player_2_score;
        $activeGame->save();
        return $activeGame;
    }


}