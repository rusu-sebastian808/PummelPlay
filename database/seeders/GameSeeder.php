<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Game;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            // RPG Games
            [
                'title' => 'The Witcher 3: Wild Hunt',
                'description' => 'A story-driven, next-generation open world role-playing game set in a visually stunning fantasy universe full of meaningful choices and impactful consequences.',
                'price' => 39.99,
                'genre' => 'RPG',
                'image' => null
            ],
            [
                'title' => 'Cyberpunk 2077',
                'description' => 'An open-world, action-adventure story set in Night City, a megalopolis obsessed with power, glamour and body modification.',
                'price' => 59.99,
                'genre' => 'RPG',
                'image' => null
            ],
            [
                'title' => 'Elden Ring',
                'description' => 'A fantasy action-RPG adventure set within a world created by Hidetaka Miyazaki and George R.R. Martin.',
                'price' => 59.99,
                'genre' => 'RPG',
                'image' => null
            ],
            [
                'title' => 'Baldur\'s Gate 3',
                'description' => 'Gather your party and return to the Forgotten Realms in a tale of fellowship and betrayal, sacrifice and survival.',
                'price' => 59.99,
                'genre' => 'RPG',
                'image' => null
            ],

            // Action Games
            [
                'title' => 'Grand Theft Auto V',
                'description' => 'Experience Rockstar Games\' largest open world yet in this crime epic that intertwines three unique criminal storylines.',
                'price' => 29.99,
                'genre' => 'Action',
                'image' => null
            ],
            [
                'title' => 'Call of Duty: Modern Warfare II',
                'description' => 'Experience the ultimate online playground with classic multiplayer or squad-up and play cooperatively.',
                'price' => 69.99,
                'genre' => 'Action',
                'image' => null
            ],
            [
                'title' => 'DOOM Eternal',
                'description' => 'Experience the ultimate combination of speed and power in DOOM Eternal - the next leap in push-forward, combat.',
                'price' => 39.99,
                'genre' => 'Action',
                'image' => null
            ],
            [
                'title' => 'Halo Infinite',
                'description' => 'When all hope is lost and humanity\'s fate hangs in the balance, Master Chief is ready to confront the most ruthless foe he\'s ever faced.',
                'price' => 59.99,
                'genre' => 'Action',
                'image' => null
            ],

            // Adventure Games
            [
                'title' => 'Red Dead Redemption 2',
                'description' => 'Winner of over 175 Game of the Year Awards, experience the epic tale of outlaw Arthur Morgan and the Van der Linde gang.',
                'price' => 59.99,
                'genre' => 'Adventure',
                'image' => null
            ],
            [
                'title' => 'The Legend of Zelda: Breath of the Wild',
                'description' => 'Step into a world of discovery, exploration, and adventure in The Legend of Zelda: Breath of the Wild.',
                'price' => 59.99,
                'genre' => 'Adventure',
                'image' => null
            ],
            [
                'title' => 'Assassin\'s Creed Valhalla',
                'description' => 'Become Eivor, a legendary Viking raider, and lead your clan from the harsh shores of Norway to a new home.',
                'price' => 59.99,
                'genre' => 'Adventure',
                'image' => null
            ],
            [
                'title' => 'God of War',
                'description' => 'Living as a man outside the shadow of the gods, Kratos must adapt to unfamiliar lands, unexpected threats, and a second chance at being a father.',
                'price' => 49.99,
                'genre' => 'Adventure',
                'image' => null
            ],

            // Racing Games
            [
                'title' => 'Forza Horizon 5',
                'description' => 'Your Ultimate Horizon Adventure awaits! Explore the vibrant and ever-evolving open world landscapes of Mexico.',
                'price' => 59.99,
                'genre' => 'Racing',
                'image' => null
            ],
            [
                'title' => 'Need for Speed Heat',
                'description' => 'Hustle by day and risk it all at night in Need for Speed Heat, a white-knuckle street racer.',
                'price' => 39.99,
                'genre' => 'Racing',
                'image' => null
            ],
            [
                'title' => 'F1 23',
                'description' => 'Be the last to brake in F1 23, the official video game of the 2023 FIA Formula One World Championship.',
                'price' => 69.99,
                'genre' => 'Racing',
                'image' => null
            ],
            [
                'title' => 'Gran Turismo 7',
                'description' => 'Whether you\'re a competitive racer, collector, tuner, livery designer or photographer – find your line with a staggering collection of game modes.',
                'price' => 69.99,
                'genre' => 'Racing',
                'image' => null
            ],

            // Strategy Games
            [
                'title' => 'Civilization VI',
                'description' => 'Build an empire to stand the test of time in the ultimate turn-based strategy experience.',
                'price' => 59.99,
                'genre' => 'Strategy',
                'image' => null
            ],
            [
                'title' => 'Age of Empires IV',
                'description' => 'Return to History. The past is prologue as you are immersed in a rich historical setting of 8 diverse civilizations.',
                'price' => 59.99,
                'genre' => 'Strategy',
                'image' => null
            ],
            [
                'title' => 'Total War: Warhammer III',
                'description' => 'The cataclysmic conclusion to the Total War: Warhammer trilogy is here. Rally your forces and step into the Realm of Chaos.',
                'price' => 59.99,
                'genre' => 'Strategy',
                'image' => null
            ],
            [
                'title' => 'StarCraft II',
                'description' => 'You are a commander from Earth, sent to the front lines of a brutal war raging across the galaxy.',
                'price' => 39.99,
                'genre' => 'Strategy',
                'image' => null
            ],

            // Platformer Games
            [
                'title' => 'Super Mario Odyssey',
                'description' => 'Join Mario on a massive, globe-trotting 3D adventure and use his incredible new abilities to collect Moons.',
                'price' => 59.99,
                'genre' => 'Platformer',
                'image' => null
            ],
            [
                'title' => 'Hollow Knight',
                'description' => 'Forge your own path in Hollow Knight! An epic action adventure through a vast ruined kingdom of insects and heroes.',
                'price' => 14.99,
                'genre' => 'Platformer',
                'image' => null
            ],
            [
                'title' => 'Celeste',
                'description' => 'Help Madeline survive her inner demons on her journey to the top of Celeste Mountain, in this super-tight platformer.',
                'price' => 19.99,
                'genre' => 'Platformer',
                'image' => null
            ],
            [
                'title' => 'A Hat in Time',
                'description' => 'A Hat in Time is a cute-as-heck 3D platformer featuring a little girl who stitches hats for wicked powers.',
                'price' => 29.99,
                'genre' => 'Platformer',
                'image' => null
            ],

            // Stealth Games
            [
                'title' => 'Metal Gear Solid V',
                'description' => 'Experience ultimate freedom in this open-world stealth game. Create your own infiltration methods in a world where every enemy action affects the game.',
                'price' => 29.99,
                'genre' => 'Stealth',
                'image' => null
            ],
            [
                'title' => 'Hitman 3',
                'description' => 'Death awaits. Agent 47 returns in HITMAN 3, the dramatic conclusion to the World of Assassination trilogy.',
                'price' => 59.99,
                'genre' => 'Stealth',
                'image' => null
            ],
            [
                'title' => 'Dishonored 2',
                'description' => 'Play your way in a world where mysticism and industry collide. Will you choose to play as Empress Emily or the royal protector Corvo?',
                'price' => 39.99,
                'genre' => 'Stealth',
                'image' => null
            ],
            [
                'title' => 'Thief',
                'description' => 'Garrett, the Master Thief, steps out of the shadows into the City. With the Baron\'s Watch spreading a rising tide of fear and oppression.',
                'price' => 29.99,
                'genre' => 'Stealth',
                'image' => null
            ],

            // Simulation Games
            [
                'title' => 'Microsoft Flight Simulator',
                'description' => 'The world is at your fingertips. From light planes to wide-body jets, fly highly detailed aircraft in the next generation of Microsoft Flight Simulator.',
                'price' => 59.99,
                'genre' => 'Simulation',
                'image' => null
            ],
            [
                'title' => 'Cities: Skylines',
                'description' => 'Cities: Skylines is a modern take on the classic city simulation. The game introduces new game play elements.',
                'price' => 29.99,
                'genre' => 'Simulation',
                'image' => null
            ],
            [
                'title' => 'The Sims 4',
                'description' => 'Create unique Sims and build the home of their dreams. Control their lives, explore vibrant worlds, and play with life like never before.',
                'price' => 39.99,
                'genre' => 'Simulation',
                'image' => null
            ],
            [
                'title' => 'Planet Coaster',
                'description' => 'Surprise, delight and thrill crowds as you build the theme park of your dreams. Build and design incredible coaster parks with unparalleled attention to detail.',
                'price' => 44.99,
                'genre' => 'Simulation',
                'image' => null
            ]
        ];

        foreach ($games as $game) {
            Game::create($game);
        }
    }
}
