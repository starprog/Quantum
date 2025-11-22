<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hero;

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
}
