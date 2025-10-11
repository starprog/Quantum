<?php

namespace Modules\BibleVerse\src;

class BibleVerseService
{
    protected $verses = [
        // Gospel & Salvation
        ['verse' => 'For God so loved the world that he gave his one and only Son, that whoever believes in him shall not perish but have eternal life.', 'reference' => 'John 3:16'],
        ['verse' => 'For all have sinned and fall short of the glory of God.', 'reference' => 'Romans 3:23'],
        ['verse' => 'Jesus answered, "I am the way and the truth and the life. No one comes to the Father except through me."', 'reference' => 'John 14:6'],
        
        // Faith & Trust
        ['verse' => 'Trust in the Lord with all your heart and lean not on your own understanding.', 'reference' => 'Proverbs 3:5'],
        ['verse' => 'Now faith is confidence in what we hope for and assurance about what we do not see.', 'reference' => 'Hebrews 11:1'],
        ['verse' => 'And without faith it is impossible to please God, because anyone who comes to him must believe that he exists and that he rewards those who earnestly seek him.', 'reference' => 'Hebrews 11:6'],
        
        // Strength & Courage
        ['verse' => 'I can do all this through him who gives me strength.', 'reference' => 'Philippians 4:13'],
        ['verse' => 'Be strong and courageous. Do not be afraid; do not be discouraged, for the Lord your God will be with you wherever you go.', 'reference' => 'Joshua 1:9'],
        ['verse' => 'The Lord is my strength and my shield; my heart trusts in him, and he helps me.', 'reference' => 'Psalm 28:7'],
        
        // Peace & Comfort
        ['verse' => 'Peace I leave with you; my peace I give you. I do not give to you as the world gives. Do not let your hearts be troubled and do not be afraid.', 'reference' => 'John 14:27'],
        ['verse' => 'Cast your cares on the Lord and he will sustain you; he will never let the righteous be shaken.', 'reference' => 'Psalm 55:22'],
        ['verse' => 'Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God.', 'reference' => 'Philippians 4:6'],
        
        // Love & Relationships
        ['verse' => 'Love is patient, love is kind. It does not envy, it does not boast, it is not proud.', 'reference' => '1 Corinthians 13:4'],
        ['verse' => 'Above all, love each other deeply, because love covers over a multitude of sins.', 'reference' => '1 Peter 4:8'],
        ['verse' => 'Be completely humble and gentle; be patient, bearing with one another in love.', 'reference' => 'Ephesians 4:2'],
        
        // Wisdom & Guidance
        ['verse' => 'Your word is a lamp for my feet, a light on my path.', 'reference' => 'Psalm 119:105'],
        ['verse' => 'If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.', 'reference' => 'James 1:5'],
        ['verse' => 'For the Lord gives wisdom; from his mouth come knowledge and understanding.', 'reference' => 'Proverbs 2:6'],
        
        // Hope & Future
        ['verse' => '"For I know the plans I have for you," declares the Lord, "plans to prosper you and not to harm you, plans to give you hope and a future."', 'reference' => 'Jeremiah 29:11'],
        ['verse' => 'But those who hope in the Lord will renew their strength. They will soar on wings like eagles; they will run and not grow weary, they will walk and not be faint.', 'reference' => 'Isaiah 40:31'],
        ['verse' => 'Being confident of this, that he who began a good work in you will carry it on to completion until the day of Christ Jesus.', 'reference' => 'Philippians 1:6'],
        
        // Prayer & Worship
        ['verse' => 'Rejoice always, pray continually, give thanks in all circumstances; for this is God\'s will for you in Christ Jesus.', 'reference' => '1 Thessalonians 5:16-18'],
        ['verse' => 'Let us then approach God\'s throne of grace with confidence, so that we may receive mercy and find grace to help us in our time of need.', 'reference' => 'Hebrews 4:16'],
        ['verse' => 'Draw near to God and He will draw near to you.', 'reference' => 'James 4:8'],
        
        // Grace & Forgiveness
        ['verse' => 'For it is by grace you have been saved, through faith—and this is not from yourselves, it is the gift of God.', 'reference' => 'Ephesians 2:8'],
        ['verse' => 'If we confess our sins, he is faithful and just and will forgive us our sins and purify us from all unrighteousness.', 'reference' => '1 John 1:9'],
        ['verse' => 'Bear with each other and forgive one another if any of you has a grievance against someone. Forgive as the Lord forgave you.', 'reference' => 'Colossians 3:13']
    ];

    public function getRandomVerse()
    {
        return $this->verses[array_rand($this->verses)];
    }
}