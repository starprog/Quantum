<?php

namespace Database\Seeders;

use App\Models\Verse;
use App\Models\VerseCategory;
use Illuminate\Database\Seeder;

class VerseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Curated collection of 100 most impactful Bible verses (10 per category)
     */
    public function run(): void
    {
        $categories = VerseCategory::all()->keyBy("name");

        $verses = [
            // Gospel & Salvation (10 verses)
            ["reference" => "John 3:16", "verse" => "For God so loved the world that he gave his one and only Son, that whoever believes in him shall not perish but have eternal life.", "category_id" => $categories["Gospel & Salvation"]->id],
            ["reference" => "Romans 10:9", "verse" => "If you declare with your mouth, 'Jesus is Lord,' and believe in your heart that God raised him from the dead, you will be saved.", "category_id" => $categories["Gospel & Salvation"]->id],
            ["reference" => "Ephesians 2:8-9", "verse" => "For it is by grace you have been saved, through faith—and this is not from yourselves, it is the gift of God—not by works, so that no one can boast.", "category_id" => $categories["Gospel & Salvation"]->id],
            ["reference" => "Romans 6:23", "verse" => "For the wages of sin is death, but the gift of God is eternal life in Christ Jesus our Lord.", "category_id" => $categories["Gospel & Salvation"]->id],
            ["reference" => "John 14:6", "verse" => "Jesus answered, 'I am the way and the truth and the life. No one comes to the Father except through me.'", "category_id" => $categories["Gospel & Salvation"]->id],
            ["reference" => "Acts 4:12", "verse" => "Salvation is found in no one else, for there is no other name under heaven given to mankind by which we must be saved.", "category_id" => $categories["Gospel & Salvation"]->id],
            ["reference" => "Romans 5:8", "verse" => "But God demonstrates his own love for us in this: While we were still sinners, Christ died for us.", "category_id" => $categories["Gospel & Salvation"]->id],
            ["reference" => "2 Corinthians 5:17", "verse" => "Therefore, if anyone is in Christ, the new creation has come: The old has gone, the new is here!", "category_id" => $categories["Gospel & Salvation"]->id],
            ["reference" => "1 John 1:9", "verse" => "If we confess our sins, he is faithful and just and will forgive us our sins and purify us from all unrighteousness.", "category_id" => $categories["Gospel & Salvation"]->id],
            ["reference" => "Acts 16:31", "verse" => "They replied, 'Believe in the Lord Jesus, and you will be saved—you and your household.'", "category_id" => $categories["Gospel & Salvation"]->id],

            // Faith & Trust (10 verses)
            ["reference" => "Hebrews 11:1", "verse" => "Now faith is confidence in what we hope for and assurance about what we do not see.", "category_id" => $categories["Faith & Trust"]->id],
            ["reference" => "Proverbs 3:5-6", "verse" => "Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.", "category_id" => $categories["Faith & Trust"]->id],
            ["reference" => "Matthew 17:20", "verse" => "Truly I tell you, if you have faith as small as a mustard seed, you can say to this mountain, 'Move from here to there,' and it will move. Nothing will be impossible for you.", "category_id" => $categories["Faith & Trust"]->id],
            ["reference" => "2 Corinthians 5:7", "verse" => "For we live by faith, not by sight.", "category_id" => $categories["Faith & Trust"]->id],
            ["reference" => "Hebrews 11:6", "verse" => "And without faith it is impossible to please God, because anyone who comes to him must believe that he exists and that he rewards those who earnestly seek him.", "category_id" => $categories["Faith & Trust"]->id],
            ["reference" => "Mark 11:22-24", "verse" => "Have faith in God. Truly I tell you, if anyone says to this mountain, 'Go, throw yourself into the sea,' and does not doubt in their heart but believes that what they say will happen, it will be done for them.", "category_id" => $categories["Faith & Trust"]->id],
            ["reference" => "Psalm 56:3-4", "verse" => "When I am afraid, I put my trust in you. In God, whose word I praise—in God I trust and am not afraid. What can mere mortals do to me?", "category_id" => $categories["Faith & Trust"]->id],
            ["reference" => "Romans 10:17", "verse" => "Consequently, faith comes from hearing the message, and the message is heard through the word about Christ.", "category_id" => $categories["Faith & Trust"]->id],
            ["reference" => "Jeremiah 17:7-8", "verse" => "But blessed is the one who trusts in the Lord, whose confidence is in him. They will be like a tree planted by the water that sends out its roots by the stream.", "category_id" => $categories["Faith & Trust"]->id],
            ["reference" => "Isaiah 26:4", "verse" => "Trust in the Lord forever, for the Lord, the Lord himself, is the Rock eternal.", "category_id" => $categories["Faith & Trust"]->id],

            // Love & Compassion (10 verses)
            ["reference" => "1 Corinthians 13:13", "verse" => "And now these three remain: faith, hope and love. But the greatest of these is love.", "category_id" => $categories["Love & Compassion"]->id],
            ["reference" => "1 John 4:7-8", "verse" => "Dear friends, let us love one another, for love comes from God. Everyone who loves has been born of God and knows God. Whoever does not love does not know God, because God is love.", "category_id" => $categories["Love & Compassion"]->id],
            ["reference" => "John 13:34-35", "verse" => "A new command I give you: Love one another. As I have loved you, so you must love one another. By this everyone will know that you are my disciples, if you love one another.", "category_id" => $categories["Love & Compassion"]->id],
            ["reference" => "1 John 4:19", "verse" => "We love because he first loved us.", "category_id" => $categories["Love & Compassion"]->id],
            ["reference" => "Colossians 3:12", "verse" => "Therefore, as God's chosen people, holy and dearly loved, clothe yourselves with compassion, kindness, humility, gentleness and patience.", "category_id" => $categories["Love & Compassion"]->id],
            ["reference" => "Ephesians 4:32", "verse" => "Be kind and compassionate to one another, forgiving each other, just as in Christ God forgave you.", "category_id" => $categories["Love & Compassion"]->id],
            ["reference" => "Matthew 22:37-39", "verse" => "Jesus replied: 'Love the Lord your God with all your heart and with all your soul and with all your mind.' This is the first and greatest commandment. And the second is like it: 'Love your neighbor as yourself.'", "category_id" => $categories["Love & Compassion"]->id],
            ["reference" => "1 Peter 4:8", "verse" => "Above all, love each other deeply, because love covers over a multitude of sins.", "category_id" => $categories["Love & Compassion"]->id],
            ["reference" => "Romans 12:10", "verse" => "Be devoted to one another in love. Honor one another above yourselves.", "category_id" => $categories["Love & Compassion"]->id],
            ["reference" => "Galatians 5:22-23", "verse" => "But the fruit of the Spirit is love, joy, peace, forbearance, kindness, goodness, faithfulness, gentleness and self-control.", "category_id" => $categories["Love & Compassion"]->id],

            // Hope & Encouragement (10 verses)
            ["reference" => "Jeremiah 29:11", "verse" => "For I know the plans I have for you, declares the Lord, plans to prosper you and not to harm you, plans to give you hope and a future.", "category_id" => $categories["Hope & Encouragement"]->id],
            ["reference" => "Romans 15:13", "verse" => "May the God of hope fill you with all joy and peace as you trust in him, so that you may overflow with hope by the power of the Holy Spirit.", "category_id" => $categories["Hope & Encouragement"]->id],
            ["reference" => "Isaiah 40:31", "verse" => "But those who hope in the Lord will renew their strength. They will soar on wings like eagles; they will run and not grow weary, they will walk and not be faint.", "category_id" => $categories["Hope & Encouragement"]->id],
            ["reference" => "Philippians 4:13", "verse" => "I can do all things through Christ who gives me strength.", "category_id" => $categories["Hope & Encouragement"]->id],
            ["reference" => "Romans 8:28", "verse" => "And we know that in all things God works for the good of those who love him, who have been called according to his purpose.", "category_id" => $categories["Hope & Encouragement"]->id],
            ["reference" => "Lamentations 3:22-23", "verse" => "Because of the Lord's great love we are not consumed, for his compassions never fail. They are new every morning; great is your faithfulness.", "category_id" => $categories["Hope & Encouragement"]->id],
            ["reference" => "Psalm 42:11", "verse" => "Why, my soul, are you downcast? Why so disturbed within me? Put your hope in God, for I will yet praise him, my Savior and my God.", "category_id" => $categories["Hope & Encouragement"]->id],
            ["reference" => "Hebrews 6:19", "verse" => "We have this hope as an anchor for the soul, firm and secure. It enters the inner sanctuary behind the curtain.", "category_id" => $categories["Hope & Encouragement"]->id],
            ["reference" => "Romans 5:3-5", "verse" => "Not only so, but we also glory in our sufferings, because we know that suffering produces perseverance; perseverance, character; and character, hope. And hope does not put us to shame.", "category_id" => $categories["Hope & Encouragement"]->id],
            ["reference" => "1 Thessalonians 5:11", "verse" => "Therefore encourage one another and build each other up, just as in fact you are doing.", "category_id" => $categories["Hope & Encouragement"]->id],

            // Strength & Courage (10 verses)
            ["reference" => "Joshua 1:9", "verse" => "Have I not commanded you? Be strong and courageous. Do not be afraid; do not be discouraged, for the Lord your God will be with you wherever you go.", "category_id" => $categories["Strength & Courage"]->id],
            ["reference" => "Isaiah 41:10", "verse" => "So do not fear, for I am with you; do not be dismayed, for I am your God. I will strengthen you and help you; I will uphold you with my righteous right hand.", "category_id" => $categories["Strength & Courage"]->id],
            ["reference" => "Psalm 27:1", "verse" => "The Lord is my light and my salvation—whom shall I fear? The Lord is the stronghold of my life—of whom shall I be afraid?", "category_id" => $categories["Strength & Courage"]->id],
            ["reference" => "2 Timothy 1:7", "verse" => "For God has not given us a spirit of fear, but of power, love, and sound mind.", "category_id" => $categories["Strength & Courage"]->id],
            ["reference" => "Psalm 46:1-3", "verse" => "God is our refuge and strength, an ever-present help in trouble. Therefore we will not fear, though the earth give way and the mountains fall into the heart of the sea.", "category_id" => $categories["Strength & Courage"]->id],
            ["reference" => "Deuteronomy 31:6", "verse" => "Be strong and courageous. Do not be afraid or terrified because of them, for the Lord your God goes with you; he will never leave you nor forsake you.", "category_id" => $categories["Strength & Courage"]->id],
            ["reference" => "Ephesians 6:10", "verse" => "Finally, be strong in the Lord and in his mighty power.", "category_id" => $categories["Strength & Courage"]->id],
            ["reference" => "2 Corinthians 12:9", "verse" => "But he said to me, 'My grace is sufficient for you, for my power is made perfect in weakness.' Therefore I will boast all the more gladly about my weaknesses, so that Christ's power may rest on me.", "category_id" => $categories["Strength & Courage"]->id],
            ["reference" => "Isaiah 40:29", "verse" => "He gives strength to the weary and increases the power of the weak.", "category_id" => $categories["Strength & Courage"]->id],
            ["reference" => "Nehemiah 8:10", "verse" => "Do not grieve, for the joy of the Lord is your strength.", "category_id" => $categories["Strength & Courage"]->id],

            // Wisdom & Guidance (10 verses)
            ["reference" => "James 1:5", "verse" => "If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.", "category_id" => $categories["Wisdom & Guidance"]->id],
            ["reference" => "Proverbs 3:5-6", "verse" => "Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.", "category_id" => $categories["Wisdom & Guidance"]->id],
            ["reference" => "Psalm 119:105", "verse" => "Your word is a lamp for my feet, a light on my path.", "category_id" => $categories["Wisdom & Guidance"]->id],
            ["reference" => "Proverbs 9:10", "verse" => "The fear of the Lord is the beginning of wisdom, and knowledge of the Holy One is understanding.", "category_id" => $categories["Wisdom & Guidance"]->id],
            ["reference" => "Proverbs 2:6", "verse" => "For the Lord gives wisdom; from his mouth come knowledge and understanding.", "category_id" => $categories["Wisdom & Guidance"]->id],
            ["reference" => "Proverbs 16:9", "verse" => "In their hearts humans plan their course, but the Lord establishes their steps.", "category_id" => $categories["Wisdom & Guidance"]->id],
            ["reference" => "Colossians 3:16", "verse" => "Let the message of Christ dwell among you richly as you teach and admonish one another with all wisdom through psalms, hymns, and songs from the Spirit, singing to God with gratitude in your hearts.", "category_id" => $categories["Wisdom & Guidance"]->id],
            ["reference" => "Proverbs 4:7", "verse" => "The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.", "category_id" => $categories["Wisdom & Guidance"]->id],
            ["reference" => "Isaiah 30:21", "verse" => "Whether you turn to the right or to the left, your ears will hear a voice behind you, saying, 'This is the way; walk in it.'", "category_id" => $categories["Wisdom & Guidance"]->id],
            ["reference" => "Proverbs 19:20", "verse" => "Listen to advice and accept discipline, and at the end you will be counted among the wise.", "category_id" => $categories["Wisdom & Guidance"]->id],

            // Love & Relationships (10 verses)
            ["reference" => "1 Corinthians 13:4-7", "verse" => "Love is patient, love is kind. It does not envy, it does not boast, it is not proud. It does not dishonor others, it is not self-seeking, it is not easily angered, it keeps no record of wrongs.", "category_id" => $categories["Love & Relationships"]->id],
            ["reference" => "Ephesians 4:2-3", "verse" => "Be completely humble and gentle; be patient, bearing with one another in love. Make every effort to keep the unity of the Spirit through the bond of peace.", "category_id" => $categories["Love & Relationships"]->id],
            ["reference" => "Colossians 3:14", "verse" => "And over all these virtues put on love, which binds them all together in perfect unity.", "category_id" => $categories["Love & Relationships"]->id],
            ["reference" => "1 John 4:12", "verse" => "No one has ever seen God; but if we love one another, God lives in us and his love is made complete in us.", "category_id" => $categories["Love & Relationships"]->id],
            ["reference" => "Proverbs 17:17", "verse" => "A friend loves at all times, and a brother is born for a time of adversity.", "category_id" => $categories["Love & Relationships"]->id],
            ["reference" => "Ephesians 5:25", "verse" => "Husbands, love your wives, just as Christ loved the church and gave himself up for her.", "category_id" => $categories["Love & Relationships"]->id],
            ["reference" => "1 John 3:18", "verse" => "Dear children, let us not love with words or speech but with actions and in truth.", "category_id" => $categories["Love & Relationships"]->id],
            ["reference" => "Ecclesiastes 4:9-10", "verse" => "Two are better than one, because they have a good return for their labor: If either of them falls down, one can help the other up. But pity anyone who falls and has no one to help them up.", "category_id" => $categories["Love & Relationships"]->id],
            ["reference" => "Song of Solomon 8:7", "verse" => "Many waters cannot quench love; rivers cannot sweep it away. If one were to give all the wealth of one's house for love, it would be utterly scorned.", "category_id" => $categories["Love & Relationships"]->id],
            ["reference" => "Proverbs 18:22", "verse" => "He who finds a wife finds what is good and receives favor from the Lord.", "category_id" => $categories["Love & Relationships"]->id],

            // Prayer & Worship (10 verses)
            ["reference" => "1 Thessalonians 5:17", "verse" => "Pray continually.", "category_id" => $categories["Prayer & Worship"]->id],
            ["reference" => "Philippians 4:6", "verse" => "Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God.", "category_id" => $categories["Prayer & Worship"]->id],
            ["reference" => "Matthew 6:6", "verse" => "But when you pray, go into your room, close the door and pray to your Father, who is unseen. Then your Father, who sees what is done in secret, will reward you.", "category_id" => $categories["Prayer & Worship"]->id],
            ["reference" => "John 4:24", "verse" => "God is spirit, and his worshipers must worship in the Spirit and in truth.", "category_id" => $categories["Prayer & Worship"]->id],
            ["reference" => "Psalm 95:6", "verse" => "Come, let us bow down in worship, let us kneel before the Lord our Maker.", "category_id" => $categories["Prayer & Worship"]->id],
            ["reference" => "Psalm 100:4", "verse" => "Enter his gates with thanksgiving and his courts with praise; give thanks to him and praise his name.", "category_id" => $categories["Prayer & Worship"]->id],
            ["reference" => "Luke 11:9-10", "verse" => "So I say to you: Ask and it will be given to you; seek and you will find; knock and the door will be opened to you. For everyone who asks receives; the one who seeks finds; and to the one who knocks, the door will be opened.", "category_id" => $categories["Prayer & Worship"]->id],
            ["reference" => "Romans 12:1", "verse" => "Therefore, I urge you, brothers and sisters, in view of God's mercy, to offer your bodies as a living sacrifice, holy and pleasing to God—this is your true and proper worship.", "category_id" => $categories["Prayer & Worship"]->id],
            ["reference" => "Psalm 103:1", "verse" => "Praise the Lord, my soul; all my inmost being, praise his holy name.", "category_id" => $categories["Prayer & Worship"]->id],
            ["reference" => "Hebrews 13:15", "verse" => "Through Jesus, therefore, let us continually offer to God a sacrifice of praise—the fruit of lips that openly profess his name.", "category_id" => $categories["Prayer & Worship"]->id],

            // Peace & Comfort (10 verses)
            ["reference" => "John 14:27", "verse" => "Peace I leave with you; my peace I give you. I do not give to you as the world gives. Do not let your hearts be troubled and do not be afraid.", "category_id" => $categories["Peace & Comfort"]->id],
            ["reference" => "Philippians 4:6-7", "verse" => "Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God. And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.", "category_id" => $categories["Peace & Comfort"]->id],
            ["reference" => "Matthew 11:28-29", "verse" => "Come to me, all you who are weary and burdened, and I will give you rest. Take my yoke upon you and learn from me, for I am gentle and humble in heart, and you will find rest for your souls.", "category_id" => $categories["Peace & Comfort"]->id],
            ["reference" => "Psalm 23:4", "verse" => "Even though I walk through the darkest valley, I will fear no evil, for you are with me; your rod and your staff, they comfort me.", "category_id" => $categories["Peace & Comfort"]->id],
            ["reference" => "Isaiah 26:3", "verse" => "You will keep in perfect peace those whose minds are steadfast, because they trust in you.", "category_id" => $categories["Peace & Comfort"]->id],
            ["reference" => "2 Thessalonians 3:16", "verse" => "Now may the Lord of peace himself give you peace at all times and in every way. The Lord be with all of you.", "category_id" => $categories["Peace & Comfort"]->id],
            ["reference" => "2 Corinthians 1:3-4", "verse" => "Praise be to the God and Father of our Lord Jesus Christ, the Father of compassion and the God of all comfort, who comforts us in all our troubles.", "category_id" => $categories["Peace & Comfort"]->id],
            ["reference" => "Psalm 34:18", "verse" => "The Lord is close to the brokenhearted and saves those who are crushed in spirit.", "category_id" => $categories["Peace & Comfort"]->id],
            ["reference" => "John 16:33", "verse" => "I have told you these things, so that in me you may have peace. In this world you will have trouble. But take heart! I have overcome the world.", "category_id" => $categories["Peace & Comfort"]->id],
            ["reference" => "Psalm 29:11", "verse" => "The Lord gives strength to his people; the Lord blesses his people with peace.", "category_id" => $categories["Peace & Comfort"]->id],

            // Grace & Forgiveness (10 verses)
            ["reference" => "Ephesians 1:7", "verse" => "In him we have redemption through his blood, the forgiveness of sins, in accordance with the riches of God's grace.", "category_id" => $categories["Grace & Forgiveness"]->id],
            ["reference" => "1 John 1:9", "verse" => "If we confess our sins, he is faithful and just and will forgive us our sins and purify us from all unrighteousness.", "category_id" => $categories["Grace & Forgiveness"]->id],
            ["reference" => "Colossians 3:13", "verse" => "Bear with each other and forgive one another if any of you has a grievance against someone. Forgive as the Lord forgave you.", "category_id" => $categories["Grace & Forgiveness"]->id],
            ["reference" => "Psalm 103:12", "verse" => "As far as the east is from the west, so far has he removed our transgressions from us.", "category_id" => $categories["Grace & Forgiveness"]->id],
            ["reference" => "Matthew 6:14-15", "verse" => "For if you forgive other people when they sin against you, your heavenly Father will also forgive you. But if you do not forgive others their sins, your Father will not forgive your sins.", "category_id" => $categories["Grace & Forgiveness"]->id],
            ["reference" => "Romans 3:23-24", "verse" => "For all have sinned and fall short of the glory of God, and all are justified freely by his grace through the redemption that came by Christ Jesus.", "category_id" => $categories["Grace & Forgiveness"]->id],
            ["reference" => "Micah 7:18-19", "verse" => "Who is a God like you, who pardons sin and forgives the transgression of the remnant of his inheritance? You do not stay angry forever but delight to show mercy.", "category_id" => $categories["Grace & Forgiveness"]->id],
            ["reference" => "Ephesians 4:32", "verse" => "Be kind and compassionate to one another, forgiving each other, just as in Christ God forgave you.", "category_id" => $categories["Grace & Forgiveness"]->id],
            ["reference" => "2 Corinthians 5:17", "verse" => "Therefore, if anyone is in Christ, the new creation has come: The old has gone, the new is here!", "category_id" => $categories["Grace & Forgiveness"]->id],
            ["reference" => "Romans 5:8", "verse" => "But God demonstrates his own love for us in this: While we were still sinners, Christ died for us.", "category_id" => $categories["Grace & Forgiveness"]->id]
        ];

        foreach ($verses as $verse) {
            Verse::create($verse);
        }
    }
}
