<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'player_1_score',
        'player_2_score',
        'game_state'
    ];

    public static function boot()
    {
        parent::boot();

        self::updating(function (Game $game) {
            $game->decideState($game);
        });
    }

    public function decideState(Game $game)
    {
        $stateName = '';
        if ($this->gameTiedBelowThreePoints()) {
            $stateName .= $this->getPlayerScoreTennisName($game->player_1_score) . ' All';
        }

        if ($this->gameNotTiedBelowThreePoints()) {
            $stateName .=
                $this->getPlayerScoreTennisName($game->player_1_score) .
                ' : ' .
                $this->getPlayerScoreTennisName($game->player_2_score);
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

        $game->game_state = $stateName;
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
        return $this->player_1_score != $this->player_2_score && (!$this->gameInTieBreakMode());
    }

    private function gameIsInAdvantageState(): bool
    {
        return (abs($this->player_1_score - $this->player_2_score) == 1)
            && ($this->gameInTieBreakMode());
    }

    private function getAdvantagePlayerString(): string
    {
        return $this->player_1_score - $this->player_2_score > 0
        ? 'Advantage player 1'
        : 'Advantage player 2';

    }

    private function gameIsComplete(): bool
    {
        return (abs($this->player_1_score - $this->player_2_score) >= 2)
            && ($this->gameInTieBreakMode());
    }

    private function getWinningPlayerString(): string
    {
        return $this->player_1_score - $this->player_2_score > 0
            ? 'Player 1 wins'
            : 'Player 2 wins';
    }

    private function gameInTieBreakMode(): bool
    {
        return (int)bcdiv((string)($this->player_1_score + $this->player_2_score), '2') >= 3;
    }

}
