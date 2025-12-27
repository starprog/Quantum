<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BattleScore extends Model
{
    protected $fillable = [
        'user_id',
        'player_name',
        'team',
        'wins',
        'losses',
        'draws',
        'total_rounds',
        'win_streak',
        'best_streak',
    ];

    protected $casts = [
        'wins' => 'integer',
        'losses' => 'integer',
        'draws' => 'integer',
        'total_rounds' => 'integer',
        'win_streak' => 'integer',
        'best_streak' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updateScore($result, $rounds)
    {
        $this->total_rounds += $rounds;

        if ($result === 'win') {
            $this->wins++;
            $this->win_streak++;
            if ($this->win_streak > $this->best_streak) {
                $this->best_streak = $this->win_streak;
            }
        } elseif ($result === 'loss') {
            $this->losses++;
            $this->win_streak = 0;
        } else {
            $this->draws++;
            $this->win_streak = 0;
        }

        $this->save();
    }

    public function getWinRateAttribute()
    {
        $total = $this->wins + $this->losses + $this->draws;
        return $total > 0 ? round(($this->wins / $total) * 100, 1) : 0;
    }
}