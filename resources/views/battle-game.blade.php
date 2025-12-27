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
        
        .hero-card:hover .hero-bio {
            opacity: 1;
            visibility: visible;
        }
        
        .hero-card.selected {
            border-color: #28a745;
            background: rgba(40, 167, 69, 0.2);
            box-shadow: 0 0 20px rgba(40, 167, 69, 0.6);
        }
        
        .rarity-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.7em;
            font-weight: bold;
            text-transform: uppercase;
            z-index: 2;
            text-shadow: 0 1px 2px rgba(0,0,0,0.8);
        }
        
        .rarity-legendary {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            color: #000;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.8);
        }
        
        .rarity-rare {
            background: linear-gradient(135deg, #9B59B6, #8E44AD);
            color: white;
            box-shadow: 0 0 10px rgba(155, 89, 182, 0.6);
        }
        
        .rarity-common {
            background: linear-gradient(135deg, #95A5A6, #7F8C8D);
            color: white;
            box-shadow: 0 0 10px rgba(149, 165, 166, 0.4);
        }
        
        .hero-bio {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.95);
            padding: 15px;
            border-radius: 0 0 12px 12px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 3;
            font-size: 0.85em;
            line-height: 1.4;
            max-height: 200px;
            overflow-y: auto;
        }
        
        .special-ability {
            margin-top: 8px;
            padding: 6px;
            background: rgba(138, 43, 226, 0.3);
            border-radius: 6px;
            border-left: 3px solid #8a2be2;
        }
        
        .special-ability-name {
            font-weight: bold;
            color: #FFD700;
            font-size: 0.9em;
        }
        
        .special-ability-desc {
            font-size: 0.8em;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 3px;
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
        
        .battle-options {
            background: rgba(20, 20, 40, 0.85);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 30px;
            text-align: center;
        }
        
        .battle-options h2 {
            color: white;
            margin-bottom: 20px;
            font-size: 1.8em;
        }
        
        .battle-type-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .battle-type-btn {
            padding: 15px 30px;
            font-size: 1.2em;
            font-weight: bold;
            color: white;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .battle-type-btn:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.2);
        }
        
        .battle-type-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.4);
        }
        
        .player-name-input {
            margin-bottom: 20px;
        }
        
        .player-name-input input {
            padding: 12px 20px;
            font-size: 1.1em;
            border-radius: 8px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.1);
            color: white;
            width: 300px;
            text-align: center;
        }
        
        .player-name-input input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .battle-button {
            padding: 18px 40px;
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
        
        .leaderboard {
            background: rgba(20, 20, 40, 0.85);
            backdrop-filter: blur(10px);
            padding: 25px;
            border-radius: 15px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 30px;
        }
        
        .leaderboard h2 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.8em;
        }
        
        .leaderboard-table {
            width: 100%;
            color: white;
            border-collapse: collapse;
        }
        
        .leaderboard-table th {
            background: rgba(255, 255, 255, 0.1);
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .leaderboard-table td {
            padding: 10px 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .leaderboard-table tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .rank-1 { color: #FFD700; font-weight: bold; }
        .rank-2 { color: #C0C0C0; font-weight: bold; }
        .rank-3 { color: #CD7F32; font-weight: bold; }
        
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
        
        .series-result {
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
        
        .series-result.marvel-wins { 
            color: #ed1d24 !important;
            text-shadow: 0 0 40px #ed1d24, 0 3px 10px rgba(0,0,0,1);
        }
        
        .series-result.dc-wins { 
            color: #0476f2 !important;
            text-shadow: 0 0 40px #0476f2, 0 3px 10px rgba(0,0,0,1);
        }
        
        .game-summary {
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            background: rgba(0, 0, 0, 0.6);
            border-left: 5px solid;
            animation: fadeIn 0.5s;
        }
        
        .game-summary.winner-A { border-color: #ed1d24; }
        .game-summary.winner-B { border-color: #0476f2; }
        
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
        
        .loading {
            text-align: center;
            font-size: 1.5em;
            color: white !important;
            padding: 20px;
            text-shadow: 0 2px 8px rgba(0,0,0,1);
        }
        
        .hero-count {
            text-align: center;
            font-size: 0.9em;
            color: rgba(255, 255, 255, 0.7);
            margin-top: 5px;
        }
        
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
        
        <!-- Leaderboard -->
        <div class="leaderboard">
            <h2>🏆 LEADERBOARD 🏆</h2>
            <table class="leaderboard-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Player</th>
                        <th>Team</th>
                        <th>Wins</th>
                        <th>Losses</th>
                        <th>Win Rate</th>
                        <th>Best Streak</th>
                    </tr>
                </thead>
                <tbody id="leaderboardBody">
                    <tr><td colspan="7" style="text-align: center;">Loading...</td></tr>
                </tbody>
            </table>
        </div>
        
        <div class="deck-selection">
            <div class="deck">
                <div class="team-title marvel">🦸 MARVEL HEROES</div>
                <div class="hero-count" id="marvelCount">0 heroes selected</div>
                <div class="hero-grid" id="marvelGrid"></div>
            </div>
            <div class="deck">
                <div class="team-title dc">🦹 DC HEROES</div>
                <div class="hero-count" id="dcCount">0 heroes selected</div>
                <div class="hero-grid" id="dcGrid"></div>
            </div>
        </div>

        <!-- Battle Options -->
        <div class="battle-options">
            <h2>⚔️ BATTLE MODE ⚔️</h2>
            <div class="battle-type-buttons">
                <button class="battle-type-btn active" onclick="selectBattleType('single')">
                    Single Battle
                </button>
                <button class="battle-type-btn" onclick="selectBattleType('3')">
                    Best of 3
                </button>
                <button class="battle-type-btn" onclick="selectBattleType('5')">
                    Best of 5
                </button>
            </div>
            <div class="player-name-input">
                <input type="text" id="playerName" placeholder="Enter your name (optional)" maxlength="50">
            </div>
            <button class="battle-button" id="battleBtn" onclick="startBattle()">
                ⚔️ START BATTLE ⚔️
            </button>
        </div>

        <div id="result"></div>
        <div class="battle-log" id="battleLog"></div>
    </div>

    <script>
        let allHeroes = [];
        let selectedMarvel = [];
        let selectedDC = [];
        let battleType = 'single';

        async function loadHeroes() {
            try {
                const response = await fetch('/api/heroes');
                allHeroes = await response.json();
                renderHeroes();
            } catch (error) {
                console.error('Error loading heroes:', error);
                document.getElementById('marvelGrid').innerHTML = '<p>Error loading heroes</p>';
            }
        }

        async function loadLeaderboard() {
            try {
                const response = await fetch('/api/battles/leaderboard');
                const scores = await response.json();
                renderLeaderboard(scores);
            } catch (error) {
                console.error('Error loading leaderboard:', error);
            }
        }

        function renderLeaderboard(scores) {
            const tbody = document.getElementById('leaderboardBody');
            if (scores.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">No battles yet. Be the first!</td></tr>';
                return;
            }

            tbody.innerHTML = scores.map((score, index) => {
                const rank = index + 1;
                const rankClass = rank <= 3 ? `rank-${rank}` : '';
                const playerName = score.player_name || 'Anonymous';
                const winRate = score.wins + score.losses + score.draws > 0 
                    ? ((score.wins / (score.wins + score.losses + score.draws)) * 100).toFixed(1) 
                    : 0;
                
                return `
                    <tr>
                        <td class="${rankClass}">#${rank}</td>
                        <td>${playerName}</td>
                        <td class="${score.team.toLowerCase()}">${score.team}</td>
                        <td>${score.wins}</td>
                        <td>${score.losses}</td>
                        <td>${winRate}%</td>
                        <td>🔥 ${score.best_streak}</td>
                    </tr>
                `;
            }).join('');
        }

        function renderHeroes() {
            const marvelGrid = document.getElementById('marvelGrid');
            const dcGrid = document.getElementById('dcGrid');
            
            const marvelHeroes = allHeroes.filter(h => h.universe === 'Marvel');
            const dcHeroes = allHeroes.filter(h => h.universe === 'DC');

            marvelHeroes.forEach(hero => {
                const card = createHeroCard(hero, 'marvel');
                marvelGrid.appendChild(card);
            });

            dcHeroes.forEach(hero => {
                const card = createHeroCard(hero, 'dc');
                dcGrid.appendChild(card);
            });
        }

        function createHeroCard(hero, team) {
            const card = document.createElement('div');
            card.className = 'hero-card';
            
            const rarityClass = `rarity-${hero.rarity || 'common'}`;
            const rarityLabel = (hero.rarity || 'common').toUpperCase();
            
            card.innerHTML = `
                <div class="rarity-badge ${rarityClass}">${rarityLabel}</div>
                <img src="${hero.image || '/images/heroes/' + hero.slug + '.jpg'}" 
                     alt="${hero.name}" 
                     class="hero-image"
                     onerror="this.style.display='none';">
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
                <div class="hero-bio">
                    <div>${hero.bio || 'No biography available.'}</div>
                    ${hero.special_ability ? `
                        <div class="special-ability">
                            <div class="special-ability-name">⚡ ${hero.special_ability}</div>
                            <div class="special-ability-desc">${hero.special_description || ''}</div>
                        </div>
                    ` : ''}
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

            if (team === 'marvel') {
                selectedMarvel = selected;
                document.getElementById('marvelCount').textContent = `${selected.length} heroes selected`;
            } else {
                selectedDC = selected;
                document.getElementById('dcCount').textContent = `${selected.length} heroes selected`;
            }
        }

        function selectBattleType(type) {
            battleType = type;
            document.querySelectorAll('.battle-type-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        async function startBattle() {
            if (selectedMarvel.length === 0 || selectedDC.length === 0) {
                alert('Please select heroes for both teams!');
                return;
            }

            const btn = document.getElementById('battleBtn');
            const log = document.getElementById('battleLog');
            const result = document.getElementById('result');
            const playerName = document.getElementById('playerName').value.trim();
            
            btn.disabled = true;
            log.innerHTML = '<div class="loading">⚔️ Battle in progress...</div>';
            result.innerHTML = '';

            try {
                if (battleType === 'single') {
                    const response = await fetch('/api/battles/toptrumps', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            deckA: selectedMarvel,
                            deckB: selectedDC
                        })
                    });
                    const data = await response.json();
                    displaySingleBattle(data);
                } else {
                    const response = await fetch('/api/battles/series', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            deckA: selectedMarvel,
                            deckB: selectedDC,
                            seriesType: battleType,
                            playerName: playerName
                        })
                    });
                    const data = await response.json();
                    displaySeriesBattle(data);
                }
                
                // Reload leaderboard after battle
                loadLeaderboard();
            } catch (error) {
                log.innerHTML = `<div class="loading">Error: ${error.message}</div>`;
            }

            btn.disabled = false;
        }

        function displaySingleBattle(data) {
            const log = document.getElementById('battleLog');
            const result = document.getElementById('result');
            
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
                <div class="series-result ${winnerClass}">
                    ${winnerText}<br>
                    <div style="font-size: 0.4em; margin-top: 15px; color: white;">
                        Rounds: ${data.rounds} | Marvel: ${data.remaining.A} cards | DC: ${data.remaining.B} cards
                    </div>
                </div>
            `;

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

        function displaySeriesBattle(data) {
            const log = document.getElementById('battleLog');
            const result = document.getElementById('result');
            
            const winnerClass = data.seriesWinner === 'Marvel' ? 'marvel-wins' : 'dc-wins';
            const icon = data.seriesWinner === 'Marvel' ? '🦸' : '🦹';
            
            result.innerHTML = `
                <div class="series-result ${winnerClass}">
                    ${icon} ${data.seriesWinner.toUpperCase()} WINS THE SERIES! ${icon}<br>
                    <div style="font-size: 0.4em; margin-top: 15px; color: white;">
                        Best of ${data.seriesType} | Score: Marvel ${data.marvelWins} - DC ${data.dcWins}
                    </div>
                </div>
            `;

            log.innerHTML = '<h2 style="margin-bottom: 15px;">Series Summary</h2>';
            
            data.games.forEach(game => {
                const gameDiv = document.createElement('div');
                const winnerClass = game.winner === 'A' ? 'winner-A' : 'winner-B';
                const winnerText = game.winner === 'A' ? '🦸 Marvel' : '🦹 DC';
                
                gameDiv.className = `game-summary ${winnerClass}`;
                gameDiv.innerHTML = `
                    <strong>Game ${game.game}</strong><br>
                    Winner: ${winnerText} in ${game.rounds} rounds<br>
                    Score: Marvel ${game.marvelWins} - DC ${game.dcWins}
                `;
                log.appendChild(gameDiv);
            });

            log.scrollTop = 0;
        }

        // Initialize
        loadHeroes();
        loadLeaderboard();
    </script>
</body>
</html>