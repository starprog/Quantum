<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hero;
use App\Models\BattleScore;

class BattleController extends Controller
{
    protected function compareAttribute(array $a, array $b, string $attr): int
    {
        $va = $a[$attr] ?? 0;
        $vb = $b[$attr] ?? 0;
        return $va <=> $vb;
    }

    public function simulateTopTrumps(Request $req)
    {
        $deckA = $req->input('deckA', []);
        $deckB = $req->input('deckB', []);
        if (empty($deckA) || empty($deckB)) {
            return response()->json(['error' => 'Both decks are required'], 422);
        }

        $load = function(array $deck) {
            return collect($deck)->map(function($slug){
                return \App\Models\Hero::where('slug', $slug)->first()?->toArray();
            })->filter()->values()->toArray();
        };

        $qA = $load($deckA);
        $qB = $load($deckB);

        $attributes = ['strength','powers','durability','endurance'];
        $history = [];
        $rounds = 0;
        $maxRounds = 2000;

        while (!empty($qA) && !empty($qB) && $rounds < $maxRounds) {
            $rounds++;
            $cardA = array_shift($qA);
            $cardB = array_shift($qB);

            $valsA = [$cardA['strength'],$cardA['powers'],$cardA['durability'],$cardA['endurance']];
            $idx = array_search(max($valsA), $valsA, true);
            $attribute = $attributes[$idx] ?? $attributes[array_rand($attributes)];

            $comp = $this->compareAttribute($cardA, $cardB, $attribute);
            if ($comp > 0) {
                array_push($qA, $cardA, $cardB);
                $winner = 'A';
            } elseif ($comp < 0) {
                array_push($qB, $cardB, $cardA);
                $winner = 'B';
            } else {
                array_push($qA, $cardA);
                array_push($qB, $cardB);
                $winner = 'draw';
            }

            $history[] = [
                'round' => $rounds,
                'attribute' => $attribute,
                'a' => ['slug'=>$cardA['slug'],'value'=>$cardA[$attribute]],
                'b' => ['slug'=>$cardB['slug'],'value'=>$cardB[$attribute]],
                'winner' => $winner,
                'sizeA' => count($qA),
                'sizeB' => count($qB),
            ];
        }

        $gameWinner = empty($qB) ? 'A' : (empty($qA) ? 'B' : 'stalemate');

        return response()->json([
            'winner' => $gameWinner,
            'rounds' => $rounds,
            'history' => $history,
            'remaining' => ['A' => count($qA), 'B' => count($qB)],
        ]);
    }

    public function topTrumps(Request $request)
    {
        $request->validate([
            'deckA' => 'required|array|min:1',
            'deckB' => 'required|array|min:1',
        ]);

        // Fetch heroes from database
        $deckA = Hero::whereIn('slug', $request->deckA)->get()->toArray();
        $deckB = Hero::whereIn('slug', $request->deckB)->get()->toArray();

        shuffle($deckA);
        shuffle($deckB);

        $history = [];
        $round = 0;
        $maxRounds = 1000;

        while (count($deckA) > 0 && count($deckB) > 0 && $round < $maxRounds) {
            $round++;
            
            $cardA = array_shift($deckA);
            $cardB = array_shift($deckB);

            $attributes = ['strength', 'powers', 'durability', 'endurance'];
            $attr = $attributes[array_rand($attributes)];

            $valA = $cardA[$attr] ?? 0;
            $valB = $cardB[$attr] ?? 0;

            $winner = null;
            if ($valA > $valB) {
                $winner = 'A';
                $deckA[] = $cardA;
                $deckA[] = $cardB;
            } elseif ($valB > $valA) {
                $winner = 'B';
                $deckB[] = $cardB;
                $deckB[] = $cardA;
            } else {
                $winner = 'draw';
                $deckA[] = $cardA;
                $deckB[] = $cardB;
            }

            $history[] = [
                'round' => $round,
                'attribute' => $attr,
                'a' => ['slug' => $cardA['slug'], 'value' => $valA],
                'b' => ['slug' => $cardB['slug'], 'value' => $valB],
                'winner' => $winner,
                'sizeA' => count($deckA),
                'sizeB' => count($deckB),
            ];
        }

        $finalWinner = null;
        if (count($deckA) > count($deckB)) {
            $finalWinner = 'A';
        } elseif (count($deckB) > count($deckA)) {
            $finalWinner = 'B';
        }

        return response()->json([
            'winner' => $finalWinner,
            'rounds' => $round,
            'remaining' => [
                'A' => count($deckA),
                'B' => count($deckB),
            ],
            'history' => $history,
        ]);
    }

    public function battleSeries(Request $request)
    {
        $request->validate([
            'deckA' => 'required|array|min:1',
            'deckB' => 'required|array|min:1',
            'seriesType' => 'required|in:3,5',
            'playerName' => 'nullable|string|max:50',
        ]);

        $seriesType = (int) $request->seriesType;
        $winsNeeded = ceil($seriesType / 2);
        
        $marvelWins = 0;
        $dcWins = 0;
        $games = [];
        $gameNumber = 0;

        while ($marvelWins < $winsNeeded && $dcWins < $winsNeeded) {
            $gameNumber++;
            
            $gameRequest = new Request([
                'deckA' => $request->deckA,
                'deckB' => $request->deckB,
            ]);
            
            $gameResult = $this->topTrumps($gameRequest)->getData();
            
            if ($gameResult->winner === 'A') {
                $marvelWins++;
            } elseif ($gameResult->winner === 'B') {
                $dcWins++;
            }
            
            $games[] = [
                'game' => $gameNumber,
                'winner' => $gameResult->winner,
                'rounds' => $gameResult->rounds,
                'marvelWins' => $marvelWins,
                'dcWins' => $dcWins,
            ];
        }

        $seriesWinner = $marvelWins >= $winsNeeded ? 'Marvel' : 'DC';
        
        $this->updateBattleScores($seriesWinner, $games, $request->playerName);

        return response()->json([
            'seriesWinner' => $seriesWinner,
            'seriesType' => $seriesType,
            'marvelWins' => $marvelWins,
            'dcWins' => $dcWins,
            'games' => $games,
        ]);
    }

    protected function updateBattleScores($winner, $games, $playerName = null)
    {
        $userId = auth()->id();
        
        $marvelScore = BattleScore::firstOrCreate(
            [
                'user_id' => $userId,
                'player_name' => $playerName,
                'team' => 'Marvel'
            ],
            [
                'wins' => 0,
                'losses' => 0,
                'draws' => 0,
                'total_rounds' => 0,
                'win_streak' => 0,
                'best_streak' => 0,
            ]
        );

        $dcScore = BattleScore::firstOrCreate(
            [
                'user_id' => $userId,
                'player_name' => $playerName,
                'team' => 'DC'
            ],
            [
                'wins' => 0,
                'losses' => 0,
                'draws' => 0,
                'total_rounds' => 0,
                'win_streak' => 0,
                'best_streak' => 0,
            ]
        );

        $totalRounds = array_sum(array_column($games, 'rounds'));
        
        if ($winner === 'Marvel') {
            $marvelScore->updateScore('win', $totalRounds);
            $dcScore->updateScore('loss', $totalRounds);
        } elseif ($winner === 'DC') {
            $dcScore->updateScore('win', $totalRounds);
            $marvelScore->updateScore('loss', $totalRounds);
        } else {
            $marvelScore->updateScore('draw', $totalRounds);
            $dcScore->updateScore('draw', $totalRounds);
        }
    }

    public function leaderboard()
    {
        $scores = BattleScore::orderBy('wins', 'desc')
            ->orderBy('best_streak', 'desc')
            ->take(20)
            ->get();

        return response()->json($scores);
    }
}