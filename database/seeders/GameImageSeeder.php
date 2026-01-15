<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;

class GameImageSeeder extends Seeder
{
 
    public function run(): void
    {
        $gameImages = [
            'The Witcher 3: Wild Hunt' => 'games/witcher3.jpg',
            'Cyberpunk 2077' => 'games/cyberpunk2077.jpg',
            'Elden Ring' => 'games/eldenring.jpg',
            'Baldur\'s Gate 3' => 'games/baldursgate3.jpg',
            'Grand Theft Auto V' => 'games/gtav.jpg',
            'Call of Duty: Modern Warfare II' => 'games/codmw2.jpg',
            'DOOM Eternal' => 'games/doometernal.jpg',
            'Halo Infinite' => 'games/haloinfinite.jpg',
            'Red Dead Redemption 2' => 'games/rdr2.jpg',
            'The Legend of Zelda: Breath of the Wild' => 'games/zeldabotw.jpg',
            'Assassin\'s Creed Valhalla' => 'games/acvalhalla.jpg',
            'God of War' => 'games/godofwar.jpg',
            'Forza Horizon 5' => 'games/forzahorizon5.jpg',
            'Need for Speed Heat' => 'games/nfsheat.jpg',
            'F1 23' => 'games/f123.jpg',
            'Gran Turismo 7' => 'games/granturismo7.jpg',
            'Civilization VI' => 'games/civ6.jpg',
            'Age of Empires IV' => 'games/aoe4.jpg',
            'Total War: Warhammer III' => 'games/totalwarwh3.jpg',
            'StarCraft II' => 'games/starcraft2.jpg',
            'Super Mario Odyssey' => 'games/marioodyssey.jpg',
            'Hollow Knight' => 'games/hollowknight.jpg',
            'Celeste' => 'games/celeste.jpg',
            'A Hat in Time' => 'games/ahatintime.jpg',
            'Metal Gear Solid V' => 'games/mgsv.jpg',
            'Hitman 3' => 'games/hitman3.jpg',
            'Dishonored 2' => 'games/dishonored2.jpg',
            'Thief' => 'games/thief.jpg',
            'Microsoft Flight Simulator' => 'games/msflightsim.jpg',
            'Cities: Skylines' => 'games/citiesskylines.jpg',
            'The Sims 4' => 'games/sims4.jpg',
            'Planet Coaster' => 'games/planetcoaster.jpg',
        ];

        foreach ($gameImages as $title => $imagePath) {
            $game = Game::where('title', $title)->first();
            if ($game) {
                $game->update(['image' => $imagePath]);
                $this->command->info("Updated image for: {$title}");
            }
        }
    }
}
