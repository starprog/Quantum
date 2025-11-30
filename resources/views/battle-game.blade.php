<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marvel vs DC - Top Trumps Battle</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        @keyframes space {
            0% { transform: translateY(0); }
            100% { transform: translateY(-2000px); }
        }
        
        @keyframes glow {
            0%, 100% { text-shadow: 0 0 20px rgba(255,255,255,0.8), 0 0 30px rgba(138,43,226,0.6); }
            50% { text-shadow: 0 0 30px rgba(255,255,255,1), 0 0 40px rgba(138,43,226,0.8); }
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom, #000000 0%, #0a0a2e 50%, #16213e 100%);
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
            color: white;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 200%;
            background-image: 
                radial-gradient(2px 2px at 20% 30%, white, transparent),
                radial-gradient(2px 2px at 60% 70%, white, transparent),
                radial-gradient(1px 1px at 50% 50%, white, transparent),
                radial-gradient(1px 1px at 80% 10%, white, transparent),
                radial-gradient(2px 2px at 90% 60%, white, transparent),
                radial-gradient(1px 1px at 33% 80%, white, transparent),
                radial-gradient(1px 1px at 15% 90%, white, transparent);
            background-size: 200% 200%;
            animation: space 200s linear infinite;
            opacity: 0.8;
            z-index: 0;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        
        h1 {
            text-align: center;
            color: white;
            font-size: 3em;
            margin-bottom: 30px;
            text-shadow: 0 0 20px rgba(255,255,255,0.8);
            animation: glow 2s ease-in-out infinite;
        }
        
        .team-title {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 15px;
            text-shadow: 0 0 10px currentColor;
            color: inherit;
        }
        
        .marvel { color: #ed1d24 !important; }
        .dc { color: #0476f2 !important; }
        
        .deck-selection {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }
        
        .deck {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }
        
        .hero-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 15px;
        }
        
        .hero-card {
            padding: 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            position: relative;
            overflow: hidden;
        }
        
        .hero-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(138, 43, 226, 0.5);
            border-color: rgba(255, 255, 255, 0.6);
        }
        
        .hero-card.selected {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.2);
            box-shadow: 0 0 20px rgba(40, 167, 69, 0.6);
        }
        
        .hero-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: block;
        }
        
        .hero-card h3 {
            font-size: 1.1em;
            margin-bottom: 8px;
            color: white !important;
            text-shadow: 0 2px 4px rgba(0,0,0,0.8);
        }
        
        .hero-card .stats {
            font-size: 0.85em;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        
        .stat-bar {
            display: flex;
            align-items: center;
            margin: 4px 0;
        }
        
        .stat-label {
            width: 50px;
            font-weight: bold;
            font-size: 0.8em;
            color: white !important;
            text-shadow: 0 1px 3px rgba(0,0,0,0.8);
        }
        
        .stat-value {
            flex: 1;
            height: 8px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            overflow: hidden;
            margin-left: 8px;
        }
        
        .stat-fill {
            height: 100%;
            background: linear-gradient(90deg, #4CAF50, #8BC34A);
            border-radius: 4px;
            transition: width 0.3s;
        }
        
        .battle-button {
            display: block;
            width: 300px;
            margin: 0 auto 30px;
            padding: 18px;
            font-size: 1.5em;
            font-weight: bold;
            color: white;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            cursor: pointer;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.4);
            transition: all 0.3s;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .battle-button:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.6);
        }
        
        .battle-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: scale(1);
        }
        
        .battle-log {
            background: rgba(20, 20, 40, 0.85);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
            max-height: 500px;
            overflow-y: auto;
        }
        
        .battle-log h2 {
            color: white !important;
            text-shadow: 0 3px 10px rgba(0,0,0,1);
            font-size: 1.8em;
            margin-bottom: 20px;
        }
        
        .round {
            padding: 18px;
            margin-bottom: 12px;
            border-radius: 10px;
            animation: fadeIn 0.5s;
            background: rgba(0, 0, 0, 0.6);
            border-left: 5px solid;
            line-height: 1.8;
            color: white !important;
        }
        
        .round.winner-A {
            border-color: #ed1d24;
            background: rgba(237, 29, 36, 0.25);
        }
        
        .round.winner-B {
            border-color: #0476f2;
            background: rgba(4, 118, 242, 0.25);
        }
        
        .round.winner-draw {
            border-color: #999;
            background: rgba(153, 153, 153, 0.25);
        }
        
        .round strong {
            color: #FFD700 !important;
            font-size: 1.15em;
            text-shadow: 0 2px 8px rgba(0,0,0,1);
        }
        
        .round span {
            color: white !important;
            font-weight: 600;
            text-shadow: 0 2px 8px rgba(0,0,0,1);
            font-size: 1.05em;
        }
        
        .result {
            text-align: center;
            font-size: 2.5em;
            font-weight: bold;
            padding: 40px;
            margin: 20px 0;
            background: rgba(20, 20, 40, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
            animation: fadeIn 0.5s;
        }
        
        .result.marvel-wins { 
            color: #ed1d24 !important;
            text-shadow: 0 0 40px #ed1d24, 0 3px 10px rgba(0,0,0,1);
        }
        
        .result.dc-wins { 
            color: #0476f2 !important;
            text-shadow: 0 0 40px #0476f2, 0 3px 10px rgba(0,0,0,1);
        }
        
        .result.stalemate { 
            color: #FFD700 !important;
            text-shadow: 0 0 40px rgba(255,215,0,0.8), 0 3px 10px rgba(0,0,0,1);
        }
        
        .loading {
            text-align: center;
            font-size: 1.5em;
            color: white !important;
            padding: 20px;
            text-shadow: 0 2px 8px rgba(0,0,0,1);
        }
        
        /* Scrollbar styling */
        .battle-log::-webkit-scrollbar {
            width: 12px;
        }
        
        .battle-log::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 10px;
        }
        
        .battle-log::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.4);
            border-radius: 10px;
        }
        
        .battle-log::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.6);
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
                // Local images stored in public/images/heroes/
        const heroImages = {
            'thor': '/images/heroes/thor.jpg',
            'hulk': '/images/heroes/hulk.jpg',
            'iron-man': '/images/heroes/iron-man.jpg',
            'spider-man': '/images/heroes/spider-man.jpg',
            'dr-strange': '/images/heroes/dr-strange.jpg',
            'black-widow': '/images/heroes/black-widow.jpg',
            'storm': '/images/heroes/storm.jpg',
            'namor': '/images/heroes/namor.jpg',
            'luke-cage': '/images/heroes/luke-cage.jpg',
            'captain-america': '/images/heroes/captain-america.jpg',
            'superman': '/images/heroes/superman.jpg',
            'batman': '/images/heroes/batman.jpg',
            'wonder-woman': '/images/heroes/wonder-woman.jpg',
            'flash': '/images/heroes/flash.jpg',
            'aquaman': '/images/heroes/aquaman.jpg',
            'green-lantern': '/images/heroes/green-lantern.jpg',
            'cyborg': '/images/heroes/cyborg.jpg',
            'martian-manhunter': '/images/heroes/martian-manhunter.jpg',
            'shazam': '/images/heroes/shazam.jpg',
            'vixen': '/images/heroes/vixen.jpg'
        };

        function createHeroCard(hero, team) {
            const card = document.createElement('div');
            card.className = 'hero-card';
            card.innerHTML = `
                <img src="${heroImages[hero.slug]}" 
                     alt="${hero.name}" 
                     class="hero-image"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div style="display:none; width:100%; height:120px; background:linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius:8px; margin-bottom:10px; align-items:center; justify-content:center; font-size:1.2em; font-weight:bold; color:white;">${hero.name}</div>
                <h3>${hero.name}</h3>
                <div class="stats">
                    <div class="stat-bar">
                        <span class="stat-label">STR:</span>
                        <div class="stat-value"><div class="stat-fill" style="width: ${hero.strength * 10}%"></div></div>
                    </div>
                    <div class="stat-bar">
                        <span class="stat-label">PWR:</span>
                        <div class="stat-value"><div class="stat-fill" style="width: ${hero.powers * 10}%"></div></div>
                    </div>
                    <div class="stat-bar">
                        <span class="stat-label">DUR:</span>
                        <div class="stat-value"><div class="stat-fill" style="width: ${hero.durability * 10}%"></div></div>
                    </div>
                    <div class="stat-bar">
                        <span class="stat-label">END:</span>
                        <div class="stat-value"><div class="stat-fill" style="width: ${hero.endurance * 10}%"></div></div>
                    </div>
                </div>
            `;
            card.onclick = () => toggleHero(hero, team, card);
            return card;
        }

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
                <img src="${heroImages[hero.slug]}" alt="${hero.name}" class="hero-image">
                <h3>${hero.name}</h3>
                <div class="stats">
                    <div class="stat-bar">
                        <span class="stat-label">STR:</span>
                        <div class="stat-value"><div class="stat-fill" style="width: ${hero.strength * 10}%"></div></div>
                    </div>
                    <div class="stat-bar">
                        <span class="stat-label">PWR:</span>
                        <div class="stat-value"><div class="stat-fill" style="width: ${hero.powers * 10}%"></div></div>
                    </div>
                    <div class="stat-bar">
                        <span class="stat-label">DUR:</span>
                        <div class="stat-value"><div class="stat-fill" style="width: ${hero.durability * 10}%"></div></div>
                    </div>
                    <div class="stat-bar">
                        <span class="stat-label">END:</span>
                        <div class="stat-value"><div class="stat-fill" style="width: ${hero.endurance * 10}%"></div></div>
                    </div>
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
                log.innerHTML = `<div class="loading">Error: ${error.message}</div>`;
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
                    <div style="font-size: 0.4em; margin-top: 15px; color: white;">
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