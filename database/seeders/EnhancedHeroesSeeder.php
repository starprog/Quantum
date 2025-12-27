<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hero;

class EnhancedHeroesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing Marvel heroes
        $marvelUpdates = [
            'thor' => [
                'rarity' => 'legendary',
                'special_ability' => 'Lightning Strike',
                'special_description' => 'Boosts Strength and Powers by 2 points each',
                'bio' => 'God of Thunder from Asgard wielding the mighty hammer Mjolnir.',
                'image' => '/images/heroes/thor.jpg'
            ],
            'hulk' => [
                'rarity' => 'legendary',
                'special_ability' => 'Rage Mode',
                'special_description' => 'Boosts Strength by 3 and Durability by 2',
                'bio' => 'Bruce Banner transforms into an unstoppable green rage monster when angry.',
                'image' => '/images/heroes/hulk.jpg'
            ],
            'iron-man' => [
                'rarity' => 'legendary',
                'special_ability' => 'Arc Reactor Overload',
                'special_description' => 'Boosts Powers by 2 points',
                'bio' => 'Genius billionaire Tony Stark uses his powered armor suit to fight evil.',
                'image' => '/images/heroes/iron-man.jpg'
            ],
            'spider-man' => [
                'rarity' => 'common',
                'special_ability' => 'Web Strike',
                'special_description' => 'Boosts Endurance by 2 points',
                'bio' => 'Peter Parker gained spider powers and uses them to protect New York City.',
                'image' => '/images/heroes/spider-man.jpg'
            ],
            'dr-strange' => [
                'rarity' => 'legendary',
                'special_ability' => 'Time Manipulation',
                'special_description' => 'Doubles Powers stat for one round',
                'bio' => 'Master of the Mystic Arts protecting reality from magical threats.',
                'image' => '/images/heroes/doctor-strange.jpg'
            ],
            'black-widow' => [
                'rarity' => 'rare',
                'special_ability' => 'Tactical Strike',
                'special_description' => 'Boosts Endurance by 2 points',
                'bio' => 'Master spy and assassin with unmatched combat skills.',
                'image' => '/images/heroes/black-widow.jpg'
            ],
            'storm' => [
                'rarity' => 'rare',
                'special_ability' => 'Weather Control',
                'special_description' => 'Boosts Powers by 2 points',
                'bio' => 'Mutant with the ability to control weather and atmospheric phenomena.',
                'image' => '/images/heroes/storm.jpg'
            ],
            'namor' => [
                'rarity' => 'rare',
                'special_ability' => 'Aquatic Superiority',
                'special_description' => 'Boosts Strength and Durability by 1 each',
                'bio' => 'King of Atlantis with superhuman strength and aquatic abilities.',
                'image' => '/images/heroes/namor.jpg'
            ],
            'luke-cage' => [
                'rarity' => 'common',
                'special_ability' => 'Unbreakable Skin',
                'special_description' => 'Boosts Durability by 2 points',
                'bio' => 'Hero with superhuman strength and steel-hard unbreakable skin.',
                'image' => '/images/heroes/luke-cage.jpg'
            ],
            'captain-america' => [
                'rarity' => 'rare',
                'special_ability' => 'Shield Defense',
                'special_description' => 'Boosts Durability by 2 points',
                'bio' => 'Super soldier Steve Rogers leads with his indestructible shield.',
                'image' => '/images/heroes/captain-america.jpg'
            ],
        ];

        foreach ($marvelUpdates as $slug => $data) {
            Hero::where('slug', $slug)->update($data);
        }

        // Update existing DC heroes
        $dcUpdates = [
            'superman' => [
                'rarity' => 'legendary',
                'special_ability' => 'Heat Vision',
                'special_description' => 'Boosts Strength by 3 points',
                'bio' => 'Last son of Krypton with incredible powers under Earth\'s yellow sun.',
                'image' => '/images/heroes/superman.jpg'
            ],
            'batman' => [
                'rarity' => 'legendary',
                'special_ability' => 'Tactical Genius',
                'special_description' => 'Boosts Powers by 3 and Endurance by 1',
                'bio' => 'Dark Knight of Gotham using intellect and technology to fight crime.',
                'image' => '/images/heroes/batman.jpg'
            ],
            'wonder-woman' => [
                'rarity' => 'legendary',
                'special_ability' => 'God of War',
                'special_description' => 'Boosts all stats by 1 point',
                'bio' => 'Amazonian warrior princess with divine powers and the Lasso of Truth.',
                'image' => '/images/heroes/wonder-woman.jpg'
            ],
            'flash' => [
                'rarity' => 'legendary',
                'special_ability' => 'Speed Force',
                'special_description' => 'Doubles Endurance stat for one round',
                'bio' => 'Fastest man alive drawing power from the Speed Force dimension.',
                'image' => '/images/heroes/flash.jpg'
            ],
            'aquaman' => [
                'rarity' => 'rare',
                'special_ability' => 'Trident Strike',
                'special_description' => 'Boosts Strength by 2 and Durability by 1',
                'bio' => 'King of Atlantis with superhuman strength and ability to command sea life.',
                'image' => '/images/heroes/aquaman.jpg'
            ],
            'green-lantern' => [
                'rarity' => 'rare',
                'special_ability' => 'Will Power',
                'special_description' => 'Boosts Powers by 2 points',
                'bio' => 'Hal Jordan wields a power ring fueled by willpower to create anything imaginable.',
                'image' => '/images/heroes/green-lantern.jpg'
            ],
            'cyborg' => [
                'rarity' => 'rare',
                'special_ability' => 'Tech Interface',
                'special_description' => 'Boosts Powers by 2 and Durability by 1',
                'bio' => 'Victor Stone is part man, part machine with advanced technological abilities.',
                'image' => '/images/heroes/cyborg.jpg'
            ],
            'martian-manhunter' => [
                'rarity' => 'legendary',
                'special_ability' => 'Martian Powers',
                'special_description' => 'Boosts all stats by 1 point',
                'bio' => 'Last survivor of Mars with shapeshifting, telepathy, and super strength.',
                'image' => '/images/heroes/martian-manhunter.jpg'
            ],
            'shazam' => [
                'rarity' => 'rare',
                'special_ability' => 'Lightning Bolt',
                'special_description' => 'Boosts Strength by 2 points',
                'bio' => 'Billy Batson transforms into a superhero with the powers of six gods.',
                'image' => '/images/heroes/shazam.jpg'
            ],
            'vixen' => [
                'rarity' => 'common',
                'special_ability' => 'Animal Powers',
                'special_description' => 'Boosts Strength and Endurance by 1 each',
                'bio' => 'Mari McCabe channels the powers of any animal using her Tantu Totem.',
                'image' => '/images/heroes/vixen.jpg'
            ],
        ];

        foreach ($dcUpdates as $slug => $data) {
            Hero::where('slug', $slug)->update($data);
        }

        // Add new Marvel heroes
        $newMarvel = [
            [
                'slug' => 'scarlet-witch',
                'name' => 'Scarlet Witch',
                'universe' => 'Marvel',
                'rarity' => 'rare',
                'strength' => 6,
                'powers' => 9,
                'durability' => 6,
                'endurance' => 7,
                'special_ability' => 'Reality Warp',
                'special_description' => 'Boosts Powers by 3 points',
                'bio' => 'Wanda Maximoff wields chaos magic capable of altering reality itself.',
                'image' => '/images/heroes/scarlet-witch.jpg'
            ],
            [
                'slug' => 'vision',
                'name' => 'Vision',
                'universe' => 'Marvel',
                'rarity' => 'rare',
                'strength' => 8,
                'powers' => 8,
                'durability' => 9,
                'endurance' => 7,
                'special_ability' => 'Density Control',
                'special_description' => 'Boosts Durability by 2 points',
                'bio' => 'Synthetic being powered by the Mind Stone with phasing abilities.',
                'image' => '/images/heroes/vision.jpg'
            ],
            [
                'slug' => 'ant-man',
                'name' => 'Ant-Man',
                'universe' => 'Marvel',
                'rarity' => 'common',
                'strength' => 6,
                'powers' => 7,
                'durability' => 6,
                'endurance' => 7,
                'special_ability' => 'Size Shift',
                'special_description' => 'Boosts Endurance by 2 points',
                'bio' => 'Scott Lang can shrink to ant size or grow to giant proportions using Pym Particles.',
                'image' => '/images/heroes/ant-man.jpg'
            ],
            [
                'slug' => 'black-panther',
                'name' => 'Black Panther',
                'universe' => 'Marvel',
                'rarity' => 'rare',
                'strength' => 7,
                'powers' => 7,
                'durability' => 8,
                'endurance' => 8,
                'special_ability' => 'Vibranium Strike',
                'special_description' => 'Boosts Strength and Endurance by 1 each',
                'bio' => 'King of Wakanda with enhanced abilities from the heart-shaped herb.',
                'image' => '/images/heroes/black-panther.jpg'
            ],
        ];

        foreach ($newMarvel as $hero) {
            Hero::updateOrCreate(['slug' => $hero['slug']], $hero);
        }

        // Add new DC heroes
        $newDC = [
            [
                'slug' => 'nightwing',
                'name' => 'Nightwing',
                'universe' => 'DC',
                'rarity' => 'common',
                'strength' => 6,
                'powers' => 5,
                'durability' => 6,
                'endurance' => 8,
                'special_ability' => 'Acrobat Master',
                'special_description' => 'Boosts Endurance by 2 points',
                'bio' => 'Dick Grayson, former Robin, now protects Blüdhaven as Nightwing.',
                'image' => '/images/heroes/nightwing.jpg'
            ],
            [
                'slug' => 'green-arrow',
                'name' => 'Green Arrow',
                'universe' => 'DC',
                'rarity' => 'common',
                'strength' => 5,
                'powers' => 6,
                'durability' => 5,
                'endurance' => 7,
                'special_ability' => 'Trick Arrow',
                'special_description' => 'Boosts Powers by 2 points',
                'bio' => 'Billionaire archer Oliver Queen fights crime with specialized arrows.',
                'image' => '/images/heroes/green-arrow.jpg'
            ],
            [
                'slug' => 'harley-quinn',
                'name' => 'Harley Quinn',
                'universe' => 'DC',
                'rarity' => 'common',
                'strength' => 5,
                'powers' => 5,
                'durability' => 6,
                'endurance' => 7,
                'special_ability' => 'Acrobatic Strike',
                'special_description' => 'Boosts Endurance by 2 points',
                'bio' => 'Former psychiatrist turned chaotic anti-hero with gymnastic skills.',
                'image' => '/images/heroes/harley-quinn.jpg'
            ],
            [
                'slug' => 'zatanna',
                'name' => 'Zatanna',
                'universe' => 'DC',
                'rarity' => 'rare',
                'strength' => 4,
                'powers' => 9,
                'durability' => 5,
                'endurance' => 6,
                'special_ability' => 'Backwards Magic',
                'special_description' => 'Boosts Powers by 2 points',
                'bio' => 'Mistress of Magic who casts spells by speaking backwards.',
                'image' => '/images/heroes/zatanna.jpg'
            ],
        ];

        foreach ($newDC as $hero) {
            Hero::updateOrCreate(['slug' => $hero['slug']], $hero);
        }

        $this->command->info('Enhanced heroes seeded successfully!');
    }
}