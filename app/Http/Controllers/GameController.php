<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Services\GameService;
use Illuminate\Support\Facades\App;
use App\Http\Requests\StoreGameRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\UpdateGameRequest;
use Illuminate\Support\Facades\Redirect;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $currentGame = $request->input('game_id') ? Game::first() :  gameService()->createNewGame();

        return Inertia::render('Dashboard', ['game'=>$currentGame]);
    }

    public function submitLatestScore(Request $request)
    {
        $gameID = $request->input('game_id');
        $player_1_score = $request->input('player_1_score');
        $player_2_score = $request->input('player_2_score');
        $currentGame = gameService()->updateGameScore($gameID, $player_1_score, $player_2_score);

        return Redirect::route('dashboard',[
            'game_id' => $currentGame->id
        ]);;

    }
}
