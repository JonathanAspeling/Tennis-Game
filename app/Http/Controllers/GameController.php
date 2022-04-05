<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use App\Services\GameService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $currentGame = gameService()->createNewGame();
        Session::put('gameID',$currentGame->id);

        return Inertia::render('Dashboard', ['activeGame'=>$currentGame]);
    }

    public function submitLatestScore()
    {

        $gameID = Session::get('gameID');
        $player_1_score = request('player_1_score');
        $player_2_score = request('player_2_score');
        $currentGame = gameService()->updateGameScore($gameID, $player_1_score, $player_2_score);
        return Inertia::render('Dashboard',['activeGame'=>$currentGame]);
    }
}
