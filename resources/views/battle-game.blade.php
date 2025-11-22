<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marvel vs DC - Top Trumps Battle</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            color: white;
            font-size: 3em;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        .team-title {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .marvel { color: #ed1d24; }
        .dc { color: #0476f2; }
        .deck-selection {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        .deck {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .hero-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 15px;
        }
        .hero-card {
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            background: #f8f9fa;
        }
        .hero-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .hero-card.selected {
            border-color: #28a745;
            background: #d4edda;
        }
        .hero-card h3 {
            font-size: 1em;
            margin-bottom: 5px;
        }
        .hero-card .stats {
            font-size: 0.8em;
            color: #666;
        }
        .battle-button {
            display: block;
            width: 300px;
            margin: 0 auto 30px;
            padding: 15px;
            font-size: 1.5em;
            font-weight: bold;
            color: white;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none;
            border-radius: 10px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            transition: transform 0.2s;
        }
        .battle-button:hover {
            transform: scale(1.05);
        }
        .battle-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .battle-log {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-height: 500px;
            overflow-y: auto;
        }
        .round {
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            animation: fadeIn 0.5s;
        }
        .round.winner-A {
            background: #ffebee;
            border-left: 4px solid #ed1d24;
        }
        .round.winner-B {
            background: #e3f2fd;
            border-left: 4px solid #0476f2;
        }
        .round.winner-draw {
            background: #f5f5f5;
            border-left: 4px solid #999;
        }
        .result {
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            padding: 30px;
            margin: 20px 0;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .result.marvel-wins { color: #ed1d24; }
        .result.dc-wins { color: #0476f2; }
        .result.stalemate { color: #666; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .loading {
            text-align: center;
            font-size: 1.5em;
            color: white;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚡ MARVEL vs DC ⚡<br>Top Trumps Battle</h1>
        
        <div class="deck-selection">
            <div class="deck">
                <div class="team-title marvel">🦸 MARVEL HEROES</div>
                <div class="hero-grid" id="marvelGrid"></div>
            </div>
            <div class="deck">
                <div class="team-title dc">🦹 DC HEROES</div>
                <div class="hero-grid" id="dcGrid"></div>
            </div>
        </div>

        <button class="battle-button" id="battleBtn" onclick="startBattle()">
            ⚔️ START BATTLE ⚔️
        </button>

        <div id="result"></div>
        <div class="battle-log" id="battleLog"></div>
    </div>

    <script>
        const heroes = {
            marvel: [
                {slug: 'thor', name: 'Thor', strength: 9, powers: 8, durability: 9, endurance: 8},
                {slug: 'hulk', name: 'Hulk', strength: 10, powers: 6, durability: 10, endurance: 9},
                {slug: 'iron-man', name: 'Iron Man', strength: 6, powers: 9, durability: 7, endurance: 6},
                {slug: 'spider-man', name: 'Spider-Man', strength: 7, powers: 7, durability: 6, endurance: 7},
                {slug: 'dr-strange', name: 'Doctor Strange', strength: 5, powers: 10, durability: 6, endurance: 6},
                {slug: 'black-widow', name: 'Black Widow', strength: 5, powers: 5, durability: 5, endurance: 7},
                {slug: 'storm', name: 'Storm', strength: 5, powers: 8, durability: 5, endurance: 6},
                {slug: 'namor', name: 'Namor', strength: 8, powers: 6, durability: 7, endurance: 7},
                {slug: 'luke-cage', name: 'Luke Cage', strength: 7, powers: 4, durability: 8, endurance: 7},
                {slug: 'captain-america', name: 'Captain America', strength: 7, powers: 5, durability: 7, endurance: 8}
            ],
            dc: [
                {slug: 'superman', name: 'Superman', strength: 10, powers: 9, durability: 10, endurance: 10},
                {slug: 'batman', name: 'Batman', strength: 5, powers: 3, durability: 5, endurance: 6},
                {slug: 'wonder-woman', name: 'Wonder Woman', strength: 9, powers: 7, durability: 9, endurance: 9},
                {slug: 'flash', name: 'The Flash', strength: 5, powers: 8, durability: 5, endurance: 9},
                {slug: 'aquaman', name: 'Aquaman', strength: 8, powers: 6, durability: 8, endurance: 7},
                {slug: 'green-lantern', name: 'Green Lantern', strength: 7, powers: 9, durability: 7, endurance: 8},
                {slug: 'cyborg', name: 'Cyborg', strength: 7, powers: 7, durability: 8, endurance: 7},
                {slug: 'martian-manhunter', name: 'Martian Manhunter', strength: 9, powers: 9, durability: 8, endurance: 8},
                {slug: 'shazam', name: 'Shazam', strength: 9, powers: 8, durability: 8, endurance: 8},
                {slug: 'vixen', name: 'Vixen', strength: 6, powers: 7, durability: 6, endurance: 6}
            ]
        };

        let selectedMarvel = [];
        let selectedDC = [];

        function renderHeroes() {
            const marvelGrid = document.getElementById('marvelGrid');
            const dcGrid = document.getElementById('dcGrid');

            heroes.marvel.forEach(hero => {
                const card = createHeroCard(hero, 'marvel');
                marvelGrid.appendChild(card);
            });

            heroes.dc.forEach(hero => {
                const card = createHeroCard(hero, 'dc');
                dcGrid.appendChild(card);
            });
        }

        function createHeroCard(hero, team) {
            const card = document.createElement('div');
            card.className = 'hero-card';
            card.innerHTML = `
                <h3>${hero.name}</h3>
                <div class="stats">
                    STR: ${hero.strength} | PWR: ${hero.powers}<br>
                    DUR: ${hero.durability} | END: ${hero.endurance}
                </div>
            `;
            card.onclick = () => toggleHero(hero, team, card);
            return card;
        }

        function toggleHero(hero, team, card) {
            const selected = team === 'marvel' ? selectedMarvel : selectedDC;
            const index = selected.indexOf(hero.slug);
            
            if (index > -1) {
                selected.splice(index, 1);
                card.classList.remove('selected');
            } else {
                if (selected.length < 5) {
                    selected.push(hero.slug);
                    card.classList.add('selected');
                }
            }

            if (team === 'marvel') selectedMarvel = selected;
            else selectedDC = selected;
        }

        async function startBattle() {
            if (selectedMarvel.length === 0 || selectedDC.length === 0) {
                alert('Please select heroes for both teams!');
                return;
            }

            const btn = document.getElementById('battleBtn');
            const log = document.getElementById('battleLog');
            const result = document.getElementById('result');
            
            btn.disabled = true;
            log.innerHTML = '<div class="loading">⚔️ Battle in progress...</div>';
            result.innerHTML = '';

            try {
                const response = await fetch('/api/battles/toptrumps', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        deckA: selectedMarvel,
                        deckB: selectedDC
                    })
                });

                const data = await response.json();
                displayBattle(data);
            } catch (error) {
                log.innerHTML = `<div style="color: red; text-align: center;">Error: ${error.message}</div>`;
            }

            btn.disabled = false;
        }

        function displayBattle(data) {
            const log = document.getElementById('battleLog');
            const result = document.getElementById('result');
            
            // Display winner
            let winnerClass = 'stalemate';
            let winnerText = '⚔️ STALEMATE ⚔️';
            
            if (data.winner === 'A') {
                winnerClass = 'marvel-wins';
                winnerText = '🦸 MARVEL WINS! 🦸';
            } else if (data.winner === 'B') {
                winnerClass = 'dc-wins';
                winnerText = '🦹 DC WINS! 🦹';
            }
            
            result.innerHTML = `
                <div class="result ${winnerClass}">
                    ${winnerText}<br>
                    <div style="font-size: 0.6em; margin-top: 10px;">
                        Rounds: ${data.rounds} | Marvel: ${data.remaining.A} cards | DC: ${data.remaining.B} cards
                    </div>
                </div>
            `;

            // Display rounds (show last 50 rounds to avoid too much)
            const rounds = data.history.slice(-50);
            log.innerHTML = '<h2 style="margin-bottom: 15px;">Battle Log (Last 50 Rounds)</h2>';
            
            rounds.forEach(round => {
                const roundDiv = document.createElement('div');
                roundDiv.className = `round winner-${round.winner}`;
                roundDiv.innerHTML = `
                    <strong>Round ${round.round}</strong> - ${round.attribute.toUpperCase()}<br>
                    <span class="marvel">Marvel: ${round.a.slug} (${round.a.value})</span> vs 
                    <span class="dc">DC: ${round.b.slug} (${round.b.value})</span><br>
                    Winner: ${round.winner === 'A' ? '🦸 Marvel' : round.winner === 'B' ? '🦹 DC' : '🤝 Draw'}
                    | Cards: Marvel ${round.sizeA} - DC ${round.sizeB}
                `;
                log.appendChild(roundDiv);
            });

            log.scrollTop = 0;
        }

        // Initialize on load
        renderHeroes();
    </script>
</body>
</html>