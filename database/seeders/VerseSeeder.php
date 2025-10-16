<?php


namespace Database\Seeders;

use App\Models\Verse;
use App\Models\VerseCategory;
use Illuminate\Database\Seeder;

class VerseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = VerseCategory::all()->keyBy("name");

        $verses = [
            // Gospel & Salvation
            [
                "reference" => "John 3:16",
                "verse" => "For God so loved the world that he gave his one and only Son, that whoever believes in him shall not perish but have eternal life.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Romans 10:9",
                "verse" => "If you declare with your mouth, 'Jesus is Lord,' and believe in your heart that God raised him from the dead, you will be saved.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Acts 4:12",
                "verse" => "Salvation is found in no one else, for there is no other name under heaven given to mankind by which we must be saved.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Ephesians 2:8-9",
                "verse" => "For it is by grace you have been saved, through faith—and this is not from yourselves, it is the gift of God—not by works, so that no one can boast.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Romans 6:23",
                "verse" => "For the wages of sin is death, but the gift of God is eternal life in Christ Jesus our Lord.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "2 Corinthians 5:17",
                "verse" => "Therefore, if anyone is in Christ, the new creation has come: The old has gone, the new is here!",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "1 John 1:9",
                "verse" => "If we confess our sins, he is faithful and just and will forgive us our sins and purify us from all unrighteousness.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Romans 5:8",
                "verse" => "But God demonstrates his own love for us in this: While we were still sinners, Christ died for us.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],

            // Faith & Trust
            [
                "reference" => "Hebrews 11:1",
                "verse" => "Now faith is confidence in what we hope for and assurance about what we do not see.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Proverbs 3:5-6",
                "verse" => "Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "2 Corinthians 5:7",
                "verse" => "For we live by faith, not by sight.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Mark 11:22-24",
                "verse" => "Have faith in God. Truly I tell you, if anyone says to this mountain, 'Go, throw yourself into the sea,' and does not doubt in their heart but believes that what they say will happen, it will be done for them.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Romans 10:17",
                "verse" => "Consequently, faith comes from hearing the message, and the message is heard through the word about Christ.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Hebrews 11:6",
                "verse" => "And without faith it is impossible to please God, because anyone who comes to him must believe that he exists and that he rewards those who earnestly seek him.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Matthew 17:20",
                "verse" => "Truly I tell you, if you have faith as small as a mustard seed, you can say to this mountain, 'Move from here to there,' and it will move. Nothing will be impossible for you.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Psalm 56:3-4",
                "verse" => "When I am afraid, I put my trust in you. In God, whose word I praise—in God I trust and am not afraid. What can mere mortals do to me?",
                "category_id" => $categories["Faith & Trust"]->id
            ],

            // Love & Compassion
            [
                "reference" => "1 Corinthians 13:13",
                "verse" => "And now these three remain: faith, hope and love. But the greatest of these is love.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "1 John 4:7-8",
                "verse" => "Dear friends, let us love one another, for love comes from God. Everyone who loves has been born of God and knows God. Whoever does not love does not know God, because God is love.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Colossians 3:12",
                "verse" => "Therefore, as God's chosen people, holy and dearly loved, clothe yourselves with compassion, kindness, humility, gentleness and patience.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "1 Peter 4:8",
                "verse" => "Above all, love each other deeply, because love covers over a multitude of sins.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "John 13:34-35",
                "verse" => "A new command I give you: Love one another. As I have loved you, so you must love one another. By this everyone will know that you are my disciples, if you love one another.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Romans 12:10",
                "verse" => "Be devoted to one another in love. Honor one another above yourselves.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Ephesians 4:32",
                "verse" => "Be kind and compassionate to one another, forgiving each other, just as in Christ God forgave you.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Galatians 5:22-23",
                "verse" => "But the fruit of the Spirit is love, joy, peace, forbearance, kindness, goodness, faithfulness, gentleness and self-control.",
                "category_id" => $categories["Love & Compassion"]->id
            ],

            // Hope & Encouragement
            [
                "reference" => "Romans 15:13",
                "verse" => "May the God of hope fill you with all joy and peace as you trust in him, so that you may overflow with hope by the power of the Holy Spirit.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Jeremiah 29:11",
                "verse" => "For I know the plans I have for you, declares the Lord, plans to prosper you and not to harm you, plans to give you hope and a future.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Isaiah 40:31",
                "verse" => "But those who hope in the Lord will renew their strength. They will soar on wings like eagles; they will run and not grow weary, they will walk and not be faint.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Philippians 4:13",
                "verse" => "I can do all things through Christ who gives me strength.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Psalm 42:11",
                "verse" => "Why, my soul, are you downcast? Why so disturbed within me? Put your hope in God, for I will yet praise him, my Savior and my God.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Lamentations 3:22-23",
                "verse" => "Because of the Lord's great love we are not consumed, for his compassions never fail. They are new every morning; great is your faithfulness.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Romans 8:28",
                "verse" => "And we know that in all things God works for the good of those who love him, who have been called according to his purpose.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "2 Corinthians 4:16-18",
                "verse" => "Therefore we do not lose heart. Though outwardly we are wasting away, yet inwardly we are being renewed day by day.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],

            // Strength & Courage
            [
                "reference" => "Joshua 1:9",
                "verse" => "Have I not commanded you? Be strong and courageous. Do not be afraid; do not be discouraged, for the Lord your God will be with you wherever you go.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Isaiah 41:10",
                "verse" => "So do not fear, for I am with you; do not be dismayed, for I am your God. I will strengthen you and help you; I will uphold you with my righteous right hand.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Psalm 27:1",
                "verse" => "The Lord is my light and my salvation—whom shall I fear? The Lord is the stronghold of my life—of whom shall I be afraid?",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "2 Timothy 1:7",
                "verse" => "For God has not given us a spirit of fear, but of power, love, and sound mind.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Deuteronomy 31:6",
                "verse" => "Be strong and courageous. Do not be afraid or terrified because of them, for the Lord your God goes with you; he will never leave you nor forsake you.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Psalm 46:1-3",
                "verse" => "God is our refuge and strength, an ever-present help in trouble. Therefore we will not fear, though the earth give way and the mountains fall into the heart of the sea.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Ephesians 6:10",
                "verse" => "Finally, be strong in the Lord and in his mighty power.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "1 Chronicles 28:20",
                "verse" => "Be strong and courageous, and do the work. Do not be afraid or discouraged, for the Lord God, my God, is with you.",
                "category_id" => $categories["Strength & Courage"]->id
            ],

            // Wisdom & Guidance
            [
                "reference" => "James 1:5",
                "verse" => "If any of you lacks wisdom, you should ask God, who gives generously to all without finding fault, and it will be given to you.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 2:6",
                "verse" => "For the Lord gives wisdom; from his mouth come knowledge and understanding.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Psalm 119:105",
                "verse" => "Your word is a lamp for my feet, a light on my path.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 16:9",
                "verse" => "In their hearts humans plan their course, but the Lord establishes their steps.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 3:13-14",
                "verse" => "Blessed are those who find wisdom, those who gain understanding, for she is more profitable than silver and yields better returns than gold.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 4:7",
                "verse" => "The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Colossians 3:16",
                "verse" => "Let the message of Christ dwell among you richly as you teach and admonish one another with all wisdom through psalms, hymns, and songs from the Spirit, singing to God with gratitude in your hearts.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 9:10",
                "verse" => "The fear of the Lord is the beginning of wisdom, and knowledge of the Holy One is understanding.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],

            // Love & Relationships
            [
                "reference" => "Ephesians 4:2-3",
                "verse" => "Be completely humble and gentle; be patient, bearing with one another in love. Make every effort to keep the unity of the Spirit through the bond of peace.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "1 Corinthians 13:4-7",
                "verse" => "Love is patient, love is kind. It does not envy, it does not boast, it is not proud. It does not dishonor others, it is not self-seeking, it is not easily angered, it keeps no record of wrongs.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Colossians 3:14",
                "verse" => "And over all these virtues put on love, which binds them all together in perfect unity.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "1 John 4:12",
                "verse" => "No one has ever seen God; but if we love one another, God lives in us and his love is made complete in us.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Proverbs 17:17",
                "verse" => "A friend loves at all times, and a brother is born for a time of adversity.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "1 John 3:18",
                "verse" => "Dear children, let us not love with words or speech but with actions and in truth.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Ephesians 5:25",
                "verse" => "Husbands, love your wives, just as Christ loved the church and gave himself up for her.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Song of Solomon 8:7",
                "verse" => "Many waters cannot quench love; rivers cannot sweep it away. If one were to give all the wealth of one's house for love, it would be utterly scorned.",
                "category_id" => $categories["Love & Relationships"]->id
            ],

            // Prayer & Worship
            [
                "reference" => "1 Thessalonians 5:17",
                "verse" => "Pray continually.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Psalm 95:6",
                "verse" => "Come, let us bow down in worship, let us kneel before the Lord our Maker.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Matthew 6:6",
                "verse" => "But when you pray, go into your room, close the door and pray to your Father, who is unseen. Then your Father, who sees what is done in secret, will reward you.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "John 4:24",
                "verse" => "God is spirit, and his worshipers must worship in the Spirit and in truth.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Psalm 100:4",
                "verse" => "Enter his gates with thanksgiving and his courts with praise; give thanks to him and praise his name.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Philippians 4:6",
                "verse" => "Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Luke 11:9-10",
                "verse" => "So I say to you: Ask and it will be given to you; seek and you will find; knock and the door will be opened to you. For everyone who asks receives; the one who seeks finds; and to the one who knocks, the door will be opened.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Romans 12:1",
                "verse" => "Therefore, I urge you, brothers and sisters, in view of God's mercy, to offer your bodies as a living sacrifice, holy and pleasing to God—this is your true and proper worship.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],

            // Peace & Comfort
            [
                "reference" => "John 14:27",
                "verse" => "Peace I leave with you; my peace I give you. I do not give to you as the world gives. Do not let your hearts be troubled and do not be afraid.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Philippians 4:6-7",
                "verse" => "Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God. And the peace of God, which transcends all understanding, will guard your hearts and your minds in Christ Jesus.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Psalm 23:4",
                "verse" => "Even though I walk through the darkest valley, I will fear no evil, for you are with me; your rod and your staff, they comfort me.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Matthew 11:28-29",
                "verse" => "Come to me, all you who are weary and burdened, and I will give you rest. Take my yoke upon you and learn from me, for I am gentle and humble in heart, and you will find rest for your souls.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Isaiah 26:3",
                "verse" => "You will keep in perfect peace those whose minds are steadfast, because they trust in you.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "2 Thessalonians 3:16",
                "verse" => "Now may the Lord of peace himself give you peace at all times and in every way. The Lord be with all of you.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Romans 8:6",
                "verse" => "The mind governed by the flesh is death, but the mind governed by the Spirit is life and peace.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "2 Corinthians 1:3-4",
                "verse" => "Praise be to the God and Father of our Lord Jesus Christ, the Father of compassion and the God of all comfort, who comforts us in all our troubles.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],

            // Grace & Forgiveness
            [
                "reference" => "Ephesians 1:7",
                "verse" => "In him we have redemption through his blood, the forgiveness of sins, in accordance with the riches of God's grace.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Colossians 3:13",
                "verse" => "Bear with each other and forgive one another if any of you has a grievance against someone. Forgive as the Lord forgave you.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Micah 7:18-19",
                "verse" => "Who is a God like you, who pardons sin and forgives the transgression of the remnant of his inheritance? You do not stay angry forever but delight to show mercy.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Psalm 103:12",
                "verse" => "As far as the east is from the west, so far has he removed our transgressions from us.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Matthew 6:14-15",
                "verse" => "For if you forgive other people when they sin against you, your heavenly Father will also forgive you. But if you do not forgive others their sins, your Father will not forgive your sins.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Romans 3:23-24",
                "verse" => "For all have sinned and fall short of the glory of God, and all are justified freely by his grace through the redemption that came by Christ Jesus.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],

            // Additional Gospel & Salvation verses (20 more)
            [
                "reference" => "Titus 3:5",
                "verse" => "He saved us, not because of righteous things we had done, but because of his mercy. He saved us through the washing of rebirth and renewal by the Holy Spirit.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "1 Peter 1:18-19",
                "verse" => "For you know that it was not with perishable things such as silver or gold that you were redeemed from the empty way of life handed down to you from your ancestors, but with the precious blood of Christ, a lamb without blemish or defect.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "1 Timothy 2:5-6",
                "verse" => "For there is one God and one mediator between God and mankind, the man Christ Jesus, who gave himself as a ransom for all people.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Romans 1:16",
                "verse" => "For I am not ashamed of the gospel, because it is the power of God that brings salvation to everyone who believes: first to the Jew, then to the Gentile.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "John 1:12",
                "verse" => "Yet to all who did receive him, to those who believed in his name, he gave the right to become children of God.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Acts 2:38",
                "verse" => "Peter replied, 'Repent and be baptized, every one of you, in the name of Jesus Christ for the forgiveness of your sins. And you will receive the gift of the Holy Spirit.'",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "John 14:6",
                "verse" => "Jesus answered, 'I am the way and the truth and the life. No one comes to the Father except through me.'",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "2 Corinthians 6:2",
                "verse" => "For he says, 'In the time of my favor I heard you, and in the day of salvation I helped you.' I tell you, now is the time of God's favor, now is the day of salvation.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Romans 8:1",
                "verse" => "Therefore, there is now no condemnation for those who are in Christ Jesus.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Hebrews 7:25",
                "verse" => "Therefore he is able to save completely those who come to God through him, because he always lives to intercede for them.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Luke 19:10",
                "verse" => "For the Son of Man came to seek and to save the lost.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Acts 16:31",
                "verse" => "They replied, 'Believe in the Lord Jesus, and you will be saved—you and your household.'",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "1 John 5:11-12",
                "verse" => "And this is the testimony: God has given us eternal life, and this life is in his Son. Whoever has the Son has life; whoever does not have the Son of God does not have life.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "John 6:47",
                "verse" => "Very truly I tell you, the one who believes has eternal life.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Romans 10:13",
                "verse" => "For, 'Everyone who calls on the name of the Lord will be saved.'",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "1 Peter 2:24",
                "verse" => "He himself bore our sins in his body on the cross, so that we might die to sins and live for righteousness; by his wounds you have been healed.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "2 Timothy 1:9",
                "verse" => "He has saved us and called us to a holy life—not because of anything we have done but because of his own purpose and grace.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Galatians 2:20",
                "verse" => "I have been crucified with Christ and I no longer live, but Christ lives in me. The life I now live in the body, I live by faith in the Son of God, who loved me and gave himself for me.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "John 10:9",
                "verse" => "I am the gate; whoever enters through me will be saved. They will come in and go out, and find pasture.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Acts 13:38-39",
                "verse" => "Therefore, my friends, I want you to know that through Jesus the forgiveness of sins is proclaimed to you. Through him everyone who believes is set free from every sin.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Colossians 1:13-14",
                "verse" => "For he has rescued us from the dominion of darkness and brought us into the kingdom of the Son he loves, in whom we have redemption, the forgiveness of sins.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "John 5:24",
                "verse" => "Very truly I tell you, whoever hears my word and believes him who sent me has eternal life and will not be judged but has crossed over from death to life.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "1 Thessalonians 5:9",
                "verse" => "For God did not appoint us to suffer wrath but to receive salvation through our Lord Jesus Christ.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Romans 3:22",
                "verse" => "This righteousness is given through faith in Jesus Christ to all who believe. There is no difference between Jew and Gentile.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Philippians 3:9",
                "verse" => "And be found in him, not having a righteousness of my own that comes from the law, but that which is through faith in Christ—the righteousness that comes from God on the basis of faith.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Hebrews 9:28",
                "verse" => "So Christ was sacrificed once to take away the sins of many; and he will appear a second time, not to bear sin, but to bring salvation to those who are waiting for him.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "1 Peter 1:3",
                "verse" => "Praise be to the God and Father of our Lord Jesus Christ! In his great mercy he has given us new birth into a living hope through the resurrection of Jesus Christ from the dead.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "John 11:25-26",
                "verse" => "Jesus said to her, 'I am the resurrection and the life. The one who believes in me will live, even though they die; and whoever lives by believing in me will never die.'",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Mark 16:16",
                "verse" => "Whoever believes and is baptized will be saved, but whoever does not believe will be condemned.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Galatians 3:26",
                "verse" => "So in Christ Jesus you are all children of God through faith.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Romans 5:1",
                "verse" => "Therefore, since we have been justified through faith, we have peace with God through our Lord Jesus Christ.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "2 Peter 3:9",
                "verse" => "The Lord is not slow in keeping his promise, as some understand slowness. Instead he is patient with you, not wanting anyone to perish, but everyone to come to repentance.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Isaiah 53:5",
                "verse" => "But he was pierced for our transgressions, he was crushed for our iniquities; the punishment that brought us peace was on him, and by his wounds we are healed.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "John 6:40",
                "verse" => "For my Father's will is that everyone who looks to the Son and believes in him shall have eternal life, and I will raise them up at the last day.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Ephesians 1:13-14",
                "verse" => "And you also were included in Christ when you heard the message of truth, the gospel of your salvation. When you believed, you were marked in him with a seal, the promised Holy Spirit.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Acts 3:19",
                "verse" => "Repent, then, and turn to God, so that your sins may be wiped out, that times of refreshing may come from the Lord.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "1 John 4:9-10",
                "verse" => "This is how God showed his love among us: He sent his one and only Son into the world that we might live through him. This is love: not that we loved God, but that he loved us and sent his Son as an atoning sacrifice for our sins.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Romans 8:16-17",
                "verse" => "The Spirit himself testifies with our spirit that we are God's children. Now if we are children, then we are heirs—heirs of God and co-heirs with Christ.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],
            [
                "reference" => "Titus 2:11",
                "verse" => "For the grace of God has appeared that offers salvation to all people.",
                "category_id" => $categories["Gospel & Salvation"]->id
            ],

            // Additional Faith & Trust verses (20 more)
            [
                "reference" => "James 1:6",
                "verse" => "But when you ask, you must believe and not doubt, because the one who doubts is like a wave of the sea, blown and tossed by the wind.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Isaiah 26:4",
                "verse" => "Trust in the Lord forever, for the Lord, the Lord himself, is the Rock eternal.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Psalm 37:3-5",
                "verse" => "Trust in the Lord and do good; dwell in the land and enjoy safe pasture. Take delight in the Lord, and he will give you the desires of your heart. Commit your way to the Lord; trust in him and he will do this.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Nahum 1:7",
                "verse" => "The Lord is good, a refuge in times of trouble. He cares for those who trust in him.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Psalm 9:10",
                "verse" => "Those who know your name trust in you, for you, Lord, have never forsaken those who seek you.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "John 14:1",
                "verse" => "Do not let your hearts be troubled. You believe in God; believe also in me.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Psalm 125:1",
                "verse" => "Those who trust in the Lord are like Mount Zion, which cannot be shaken but endures forever.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Romans 4:20-21",
                "verse" => "Yet he did not waver through unbelief regarding the promise of God, but was strengthened in his faith and gave glory to God, being fully persuaded that God had power to do what he had promised.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "1 Peter 1:8-9",
                "verse" => "Though you have not seen him, you love him; and even though you do not see him now, you believe in him and are filled with an inexpressible and glorious joy, for you are receiving the end result of your faith, the salvation of your souls.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Galatians 2:16",
                "verse" => "Know that a person is not justified by the works of the law, but by faith in Jesus Christ. So we, too, have put our faith in Christ Jesus that we may be justified by faith in Christ.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Ephesians 3:12",
                "verse" => "In him and through faith in him we may approach God with freedom and confidence.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "1 Corinthians 16:13",
                "verse" => "Be on your guard; stand firm in the faith; be courageous; be strong.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Habakkuk 2:4",
                "verse" => "See, the enemy is puffed up; his desires are not upright—but the righteous person will live by his faithfulness.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "1 John 5:4",
                "verse" => "For everyone born of God overcomes the world. This is the victory that has overcome the world, even our faith.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Psalm 31:14-15",
                "verse" => "But I trust in you, Lord; I say, 'You are my God.' My times are in your hands.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Jeremiah 17:7-8",
                "verse" => "But blessed is the one who trusts in the Lord, whose confidence is in him. They will be like a tree planted by the water that sends out its roots by the stream.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Hebrews 10:22",
                "verse" => "Let us draw near to God with a sincere heart and with the full assurance that faith brings, having our hearts sprinkled to cleanse us from a guilty conscience.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Hebrews 10:38",
                "verse" => "And, 'But my righteous one will live by faith. And I take no pleasure in the one who shrinks back.'",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "Acts 27:25",
                "verse" => "So keep up your courage, men, for I have faith in God that it will happen just as he told me.",
                "category_id" => $categories["Faith & Trust"]->id
            ],
            [
                "reference" => "2 Chronicles 20:20",
                "verse" => "Have faith in the Lord your God and you will be upheld; have faith in his prophets and you will be successful.",
                "category_id" => $categories["Faith & Trust"]->id
            ],

            // Additional Hope & Encouragement verses (20 more)
            [
                "reference" => "1 Peter 5:10",
                "verse" => "And the God of all grace, who called you to his eternal glory in Christ, after you have suffered a little while, will himself restore you and make you strong, firm and steadfast.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Psalm 147:11",
                "verse" => "The Lord delights in those who fear him, who put their hope in his unfailing love.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Joshua 1:8",
                "verse" => "Keep this Book of the Law always on your lips; meditate on it day and night, so that you may be careful to do everything written in it. Then you will be prosperous and successful.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Psalm 31:24",
                "verse" => "Be strong and take heart, all you who hope in the Lord.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Hebrews 6:19",
                "verse" => "We have this hope as an anchor for the soul, firm and secure. It enters the inner sanctuary behind the curtain.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Colossians 1:27",
                "verse" => "To them God has chosen to make known among the Gentiles the glorious riches of this mystery, which is Christ in you, the hope of glory.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Psalm 130:5",
                "verse" => "I wait for the Lord, my whole being waits, and in his word I put my hope.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Psalm 71:5",
                "verse" => "For you have been my hope, Sovereign Lord, my confidence since my youth.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Romans 12:12",
                "verse" => "Be joyful in hope, patient in affliction, faithful in prayer.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "1 Thessalonians 5:11",
                "verse" => "Therefore encourage one another and build each other up, just as in fact you are doing.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Isaiah 41:13",
                "verse" => "For I am the Lord your God who takes hold of your right hand and says to you, Do not fear; I will help you.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Deuteronomy 31:8",
                "verse" => "The Lord himself goes before you and will be with you; he will never leave you nor forsake you. Do not be afraid; do not be discouraged.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Hebrews 10:23",
                "verse" => "Let us hold unswervingly to the hope we profess, for he who promised is faithful.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Proverbs 23:18",
                "verse" => "There is surely a future hope for you, and your hope will not be cut off.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Psalm 33:18",
                "verse" => "But the eyes of the Lord are on those who fear him, on those whose hope is in his unfailing love.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Romans 5:3-5",
                "verse" => "Not only so, but we also glory in our sufferings, because we know that suffering produces perseverance; perseverance, character; and character, hope. And hope does not put us to shame.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "2 Thessalonians 2:16-17",
                "verse" => "May our Lord Jesus Christ himself and God our Father, who loved us and by his grace gave us eternal encouragement and good hope, encourage your hearts and strengthen you in every good deed and word.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "1 Peter 1:13",
                "verse" => "Therefore, with minds that are alert and fully sober, set your hope on the grace to be brought to you when Jesus Christ is revealed at his coming.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Psalm 146:5",
                "verse" => "Blessed are those whose help is the God of Jacob, whose hope is in the Lord their God.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],
            [
                "reference" => "Titus 2:13",
                "verse" => "While we wait for the blessed hope—the appearing of the glory of our great God and Savior, Jesus Christ.",
                "category_id" => $categories["Hope & Encouragement"]->id
            ],

            // Additional Love & Compassion verses (20 more)
            [
                "reference" => "Matthew 22:37-39",
                "verse" => "Jesus replied: 'Love the Lord your God with all your heart and with all your soul and with all your mind.' This is the first and greatest commandment. And the second is like it: 'Love your neighbor as yourself.'",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Romans 13:10",
                "verse" => "Love does no harm to a neighbor. Therefore love is the fulfillment of the law.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "1 John 3:1",
                "verse" => "See what great love the Father has lavished on us, that we should be called children of God! And that is what we are!",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Psalm 86:15",
                "verse" => "But you, Lord, are a compassionate and gracious God, slow to anger, abounding in love and faithfulness.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Zechariah 7:9",
                "verse" => "This is what the Lord Almighty said: 'Administer true justice; show mercy and compassion to one another.'",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Micah 6:8",
                "verse" => "He has shown you, O mortal, what is good. And what does the Lord require of you? To act justly and to love mercy and to walk humbly with your God.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Proverbs 3:3-4",
                "verse" => "Let love and faithfulness never leave you; bind them around your neck, write them on the tablet of your heart. Then you will win favor and a good name in the sight of God and man.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Romans 5:5",
                "verse" => "And hope does not put us to shame, because God's love has been poured out into our hearts through the Holy Spirit, who has been given to us.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "1 John 4:16",
                "verse" => "And so we know and rely on the love God has for us. God is love. Whoever lives in love lives in God, and God in them.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Jeremiah 31:3",
                "verse" => "The Lord appeared to us in the past, saying: 'I have loved you with an everlasting love; I have drawn you with unfailing kindness.'",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "1 Corinthians 16:14",
                "verse" => "Do everything in love.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Luke 6:35",
                "verse" => "But love your enemies, do good to them, and lend to them without expecting to get anything back. Then your reward will be great, and you will be children of the Most High.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Proverbs 10:12",
                "verse" => "Hatred stirs up conflict, but love covers over all wrongs.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "James 2:8",
                "verse" => "If you really keep the royal law found in Scripture, 'Love your neighbor as yourself,' you are doing right.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Psalm 103:8",
                "verse" => "The Lord is compassionate and gracious, slow to anger, abounding in love.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Psalm 145:8-9",
                "verse" => "The Lord is gracious and compassionate, slow to anger and rich in love. The Lord is good to all; he has compassion on all he has made.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Matthew 5:44",
                "verse" => "But I tell you, love your enemies and pray for those who persecute you.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "1 John 4:19",
                "verse" => "We love because he first loved us.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Philippians 2:1-2",
                "verse" => "Therefore if you have any encouragement from being united with Christ, if any comfort from his love, if any common sharing in the Spirit, if any tenderness and compassion, then make my joy complete by being like-minded, having the same love, being one in spirit and of one mind.",
                "category_id" => $categories["Love & Compassion"]->id
            ],
            [
                "reference" => "Romans 12:9",
                "verse" => "Love must be sincere. Hate what is evil; cling to what is good.",
                "category_id" => $categories["Love & Compassion"]->id
            ],

            // Additional Strength & Courage verses (20 more)
            [
                "reference" => "Nehemiah 8:10",
                "verse" => "Do not grieve, for the joy of the Lord is your strength.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Psalm 118:14",
                "verse" => "The Lord is my strength and my defense; he has become my salvation.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Isaiah 40:29",
                "verse" => "He gives strength to the weary and increases the power of the weak.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Psalm 28:7",
                "verse" => "The Lord is my strength and my shield; my heart trusts in him, and he helps me. My heart leaps for joy, and with my song I praise him.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Habakkuk 3:19",
                "verse" => "The Sovereign Lord is my strength; he makes my feet like the feet of a deer, he enables me to tread on the heights.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "1 Corinthians 15:57-58",
                "verse" => "But thanks be to God! He gives us the victory through our Lord Jesus Christ. Therefore, my dear brothers and sisters, stand firm. Let nothing move you.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Psalm 31:24",
                "verse" => "Be strong and take heart, all you who hope in the Lord.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Isaiah 35:4",
                "verse" => "Say to those with fearful hearts, 'Be strong, do not fear; your God will come, he will come with vengeance; with divine retribution he will come to save you.'",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Philippians 4:19",
                "verse" => "And my God will meet all your needs according to the riches of his glory in Christ Jesus.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "2 Corinthians 12:9",
                "verse" => "But he said to me, 'My grace is sufficient for you, for my power is made perfect in weakness.' Therefore I will boast all the more gladly about my weaknesses, so that Christ's power may rest on me.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Joel 3:10",
                "verse" => "Let the weakling say, 'I am strong!'",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Psalm 138:3",
                "verse" => "When I called, you answered me; you greatly emboldened me.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "1 Peter 5:6-7",
                "verse" => "Humble yourselves, therefore, under God's mighty hand, that he may lift you up in due time. Cast all your anxiety on him because he cares for you.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Haggai 2:4",
                "verse" => "But now be strong, Zerubbabel,' declares the Lord. 'Be strong, Joshua son of Jozadak, the high priest. Be strong, all you people of the land,' declares the Lord, 'and work. For I am with you,' declares the Lord Almighty.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Zephaniah 3:17",
                "verse" => "The Lord your God is with you, the Mighty Warrior who saves. He will take great delight in you; in his love he will no longer rebuke you, but will rejoice over you with singing.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Proverbs 24:10",
                "verse" => "If you falter in a time of trouble, how small is your strength!",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Psalm 73:26",
                "verse" => "My flesh and my heart may fail, but God is the strength of my heart and my portion forever.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "1 Samuel 30:6",
                "verse" => "David was greatly distressed because the men were talking of stoning him; each one was bitter in spirit because of his sons and daughters. But David found strength in the Lord his God.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "2 Corinthians 4:8-9",
                "verse" => "We are hard pressed on every side, but not crushed; perplexed, but not in despair; persecuted, but not abandoned; struck down, but not destroyed.",
                "category_id" => $categories["Strength & Courage"]->id
            ],
            [
                "reference" => "Isaiah 12:2",
                "verse" => "Surely God is my salvation; I will trust and not be afraid. The Lord, the Lord himself, is my strength and my defense; he has become my salvation.",
                "category_id" => $categories["Strength & Courage"]->id
            ],

            // Additional Peace & Comfort verses (20 more)
            [
                "reference" => "Psalm 119:165",
                "verse" => "Great peace have those who love your law, and nothing can make them stumble.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Isaiah 26:3",
                "verse" => "You will keep in perfect peace those whose minds are steadfast, because they trust in you.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Romans 8:6",
                "verse" => "The mind governed by the flesh is death, but the mind governed by the Spirit is life and peace.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Proverbs 3:5-6",
                "verse" => "Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to him, and he will make your paths straight.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Psalm 37:11",
                "verse" => "But the meek will inherit the land and enjoy peace and prosperity.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Psalm 85:8",
                "verse" => "I will listen to what God the Lord says; he promises peace to his people, his faithful servants—but let them not turn to folly.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "John 16:33",
                "verse" => "I have told you these things, so that in me you may have peace. In this world you will have trouble. But take heart! I have overcome the world.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Hebrews 13:20-21",
                "verse" => "Now may the God of peace, who through the blood of the eternal covenant brought back from the dead our Lord Jesus, that great Shepherd of the sheep, equip you with everything good for doing his will.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Numbers 6:24-26",
                "verse" => "The Lord bless you and keep you; the Lord make his face shine on you and be gracious to you; the Lord turn his face toward you and give you peace.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Psalm 29:11",
                "verse" => "The Lord gives strength to his people; the Lord blesses his people with peace.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Isaiah 54:10",
                "verse" => "Though the mountains be shaken and the hills be removed, yet my unfailing love for you will not be shaken nor my covenant of peace be removed, says the Lord, who has compassion on you.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Colossians 1:20",
                "verse" => "And through him to reconcile to himself all things, whether things on earth or things in heaven, by making peace through his blood, shed on the cross.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "2 Thessalonians 3:16",
                "verse" => "Now may the Lord of peace himself give you peace at all times and in every way. The Lord be with all of you.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Psalm 91:1-2",
                "verse" => "Whoever dwells in the shelter of the Most High will rest in the shadow of the Almighty. I will say of the Lord, 'He is my refuge and my fortress, my God, in whom I trust.'",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Matthew 5:9",
                "verse" => "Blessed are the peacemakers, for they will be called children of God.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Psalm 34:18",
                "verse" => "The Lord is close to the brokenhearted and saves those who are crushed in spirit.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "1 Peter 5:7",
                "verse" => "Cast all your anxiety on him because he cares for you.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Psalm 62:1",
                "verse" => "Truly my soul finds rest in God; my salvation comes from him.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Isaiah 32:17",
                "verse" => "The fruit of that righteousness will be peace; its effect will be quietness and confidence forever.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],
            [
                "reference" => "Romans 15:13",
                "verse" => "May the God of hope fill you with all joy and peace as you trust in him, so that you may overflow with hope by the power of the Holy Spirit.",
                "category_id" => $categories["Peace & Comfort"]->id
            ],

            // Additional Prayer & Worship verses (20 more)
            [
                "reference" => "1 Chronicles 16:11",
                "verse" => "Look to the Lord and his strength; seek his face always.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Psalm 95:6",
                "verse" => "Come, let us bow down in worship, let us kneel before the Lord our Maker.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "John 4:24",
                "verse" => "God is spirit, and his worshipers must worship in the Spirit and in truth.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Psalm 34:1",
                "verse" => "I will extol the Lord at all times; his praise will always be on my lips.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Hebrews 13:15",
                "verse" => "Through Jesus, therefore, let us continually offer to God a sacrifice of praise—the fruit of lips that openly profess his name.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Psalm 96:9",
                "verse" => "Worship the Lord in the splendor of his holiness; tremble before him, all the earth.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Colossians 3:16",
                "verse" => "Let the message of Christ dwell among you richly as you teach and admonish one another with all wisdom through psalms, hymns, and songs from the Spirit, singing to God with gratitude in your hearts.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "1 Chronicles 29:13",
                "verse" => "Now, our God, we give you thanks, and praise your glorious name.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Psalm 29:2",
                "verse" => "Ascribe to the Lord the glory due his name; worship the Lord in the splendor of his holiness.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Romans 12:1",
                "verse" => "Therefore, I urge you, brothers and sisters, in view of God's mercy, to offer your bodies as a living sacrifice, holy and pleasing to God—this is your true and proper worship.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Psalm 103:1",
                "verse" => "Praise the Lord, my soul; all my inmost being, praise his holy name.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Matthew 4:10",
                "verse" => "Jesus said to him, 'Away from me, Satan! For it is written: Worship the Lord your God, and serve him only.'",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "1 John 5:14",
                "verse" => "This is the confidence we have in approaching God: that if we ask anything according to his will, he hears us.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "James 5:13",
                "verse" => "Is anyone among you in trouble? Let them pray. Is anyone happy? Let them sing songs of praise.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Psalm 150:6",
                "verse" => "Let everything that has breath praise the Lord. Praise the Lord.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "1 Chronicles 16:29",
                "verse" => "Ascribe to the Lord the glory due his name; bring an offering and come before him. Worship the Lord in the splendor of his holiness.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Psalm 71:8",
                "verse" => "My mouth is filled with your praise, declaring your splendor all day long.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Revelation 4:11",
                "verse" => "You are worthy, our Lord and God, to receive glory and honor and power, for you created all things, and by your will they were created and have their being.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Luke 11:2",
                "verse" => "He said to them, 'When you pray, say: Father, hallowed be your name, your kingdom come.'",
                "category_id" => $categories["Prayer & Worship"]->id
            ],
            [
                "reference" => "Psalm 145:21",
                "verse" => "My mouth will speak in praise of the Lord. Let every creature praise his holy name for ever and ever.",
                "category_id" => $categories["Prayer & Worship"]->id
            ],

            // Additional Wisdom & Guidance verses (20 more)
            [
                "reference" => "Proverbs 2:6",
                "verse" => "For the Lord gives wisdom; from his mouth come knowledge and understanding.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 4:7",
                "verse" => "The beginning of wisdom is this: Get wisdom. Though it cost all you have, get understanding.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Psalm 111:10",
                "verse" => "The fear of the Lord is the beginning of wisdom; all who follow his precepts have good understanding. To him belongs eternal praise.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 3:13",
                "verse" => "Blessed are those who find wisdom, those who gain understanding.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Colossians 3:16",
                "verse" => "Let the message of Christ dwell among you richly as you teach and admonish one another with all wisdom.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 16:16",
                "verse" => "How much better to get wisdom than gold, to get insight rather than silver!",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 19:20",
                "verse" => "Listen to advice and accept discipline, and at the end you will be counted among the wise.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Psalm 143:10",
                "verse" => "Teach me to do your will, for you are my God; may your good Spirit lead me on level ground.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Isaiah 30:21",
                "verse" => "Whether you turn to the right or to the left, your ears will hear a voice behind you, saying, 'This is the way; walk in it.'",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 11:14",
                "verse" => "For lack of guidance a nation falls, but victory is won through many advisers.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 15:22",
                "verse" => "Plans fail for lack of counsel, but with many advisers they succeed.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Job 28:28",
                "verse" => "And he said to the human race, 'The fear of the Lord—that is wisdom, and to shun evil is understanding.'",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 8:11",
                "verse" => "For wisdom is more precious than rubies, and nothing you desire can compare with her.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Ecclesiastes 7:12",
                "verse" => "Wisdom is a shelter as money is a shelter, but the advantage of knowledge is this: Wisdom preserves those who have it.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 13:10",
                "verse" => "Where there is strife, there is pride, but wisdom is found in those who take advice.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 24:5",
                "verse" => "The wise prevail through great power, and those who have knowledge muster their strength.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Psalm 90:12",
                "verse" => "Teach us to number our days, that we may gain a heart of wisdom.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 1:5",
                "verse" => "Let the wise listen and add to their learning, and let the discerning get guidance.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Proverbs 12:15",
                "verse" => "The way of fools seems right to them, but the wise listen to advice.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],
            [
                "reference" => "Daniel 2:21",
                "verse" => "He changes times and seasons; he deposes kings and raises up others. He gives wisdom to the wise and knowledge to the discerning.",
                "category_id" => $categories["Wisdom & Guidance"]->id
            ],

            // Additional Love & Relationships verses (20 more)
            [
                "reference" => "Song of Solomon 8:7",
                "verse" => "Many waters cannot quench love; rivers cannot sweep it away. If one were to give all the wealth of one's house for love, it would be utterly scorned.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Ecclesiastes 4:9-10",
                "verse" => "Two are better than one, because they have a good return for their labor: If either of them falls down, one can help the other up. But pity anyone who falls and has no one to help them up.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Ruth 1:16",
                "verse" => "But Ruth replied, 'Don't urge me to leave you or to turn back from you. Where you go I will go, and where you stay I will stay. Your people will be my people and your God my God.'",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Ephesians 5:25",
                "verse" => "Husbands, love your wives, just as Christ loved the church and gave himself up for her.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Genesis 2:24",
                "verse" => "That is why a man leaves his father and mother and is united to his wife, and they become one flesh.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "1 Peter 4:8",
                "verse" => "Above all, love each other deeply, because love covers over a multitude of sins.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Song of Solomon 2:16",
                "verse" => "My beloved is mine and I am his; he browses among the lilies.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Colossians 3:19",
                "verse" => "Husbands, love your wives and do not be harsh with them.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Proverbs 31:10",
                "verse" => "A wife of noble character who can find? She is worth far more than rubies.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "1 Corinthians 7:3",
                "verse" => "The husband should fulfill his marital duty to his wife, and likewise the wife to her husband.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Proverbs 18:22",
                "verse" => "He who finds a wife finds what is good and receives favor from the Lord.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Song of Solomon 4:7",
                "verse" => "You are altogether beautiful, my darling; there is no flaw in you.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Hebrews 13:4",
                "verse" => "Marriage should be honored by all, and the marriage bed kept pure, for God will judge the adulterer and all the sexually immoral.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Proverbs 5:18",
                "verse" => "May your fountain be blessed, and may you rejoice in the wife of your youth.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "1 Corinthians 11:11",
                "verse" => "Nevertheless, in the Lord woman is not independent of man, nor is man independent of woman.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Ephesians 5:33",
                "verse" => "However, each one of you also must love his wife as he loves himself, and the wife must respect her husband.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Song of Solomon 8:6",
                "verse" => "Place me like a seal over your heart, like a seal on your arm; for love is as strong as death, its jealousy unyielding as the grave. It burns like blazing fire, like a mighty flame.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "1 Peter 3:7",
                "verse" => "Husbands, in the same way be considerate as you live with your wives, and treat them with respect as the weaker partner and as heirs with you of the gracious gift of life, so that nothing will hinder your prayers.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Proverbs 12:4",
                "verse" => "A wife of noble character is her husband's crown, but a disgraceful wife is like decay in his bones.",
                "category_id" => $categories["Love & Relationships"]->id
            ],
            [
                "reference" => "Ephesians 5:21",
                "verse" => "Submit to one another out of reverence for Christ.",
                "category_id" => $categories["Love & Relationships"]->id
            ],

            // Additional Grace & Forgiveness verses (20 more)
            [
                "reference" => "Matthew 6:14-15",
                "verse" => "For if you forgive other people when they sin against you, your heavenly Father will also forgive you. But if you do not forgive others their sins, your Father will not forgive your sins.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Colossians 3:13",
                "verse" => "Bear with each other and forgive one another if any of you has a grievance against someone. Forgive as the Lord forgave you.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Luke 6:37",
                "verse" => "Do not judge, and you will not be judged. Do not condemn, and you will not be condemned. Forgive, and you will be forgiven.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Ephesians 1:7",
                "verse" => "In him we have redemption through his blood, the forgiveness of sins, in accordance with the riches of God's grace.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "1 John 1:9",
                "verse" => "If we confess our sins, he is faithful and just and will forgive us our sins and purify us from all unrighteousness.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Psalm 86:5",
                "verse" => "You, Lord, are forgiving and good, abounding in love to all who call to you.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Isaiah 43:25",
                "verse" => "I, even I, am he who blots out your transgressions, for my own sake, and remembers your sins no more.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Micah 7:18",
                "verse" => "Who is a God like you, who pardons sin and forgives the transgression of the remnant of his inheritance? You do not stay angry forever but delight to show mercy.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Acts 3:19",
                "verse" => "Repent, then, and turn to God, so that your sins may be wiped out, that times of refreshing may come from the Lord.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Psalm 32:5",
                "verse" => "Then I acknowledged my sin to you and did not cover up my iniquity. I said, 'I will confess my transgressions to the Lord.' And you forgave the guilt of my sin.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "2 Corinthians 5:17",
                "verse" => "Therefore, if anyone is in Christ, the new creation has come: The old has gone, the new is here!",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Hebrews 8:12",
                "verse" => "For I will forgive their wickedness and will remember their sins no more.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Psalm 130:3-4",
                "verse" => "If you, Lord, kept a record of sins, Lord, who could stand? But with you there is forgiveness, so that we can, with reverence, serve you.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Romans 5:8",
                "verse" => "But God demonstrates his own love for us in this: While we were still sinners, Christ died for us.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Proverbs 28:13",
                "verse" => "Whoever conceals their sins does not prosper, but the one who confesses and renounces them finds mercy.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Mark 11:25",
                "verse" => "And when you stand praying, if you hold anything against anyone, forgive them, so that your Father in heaven may forgive you your sins.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Ephesians 4:32",
                "verse" => "Be kind and compassionate to one another, forgiving each other, just as in Christ God forgave you.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Daniel 9:9",
                "verse" => "The Lord our God is merciful and forgiving, even though we have rebelled against him.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Psalm 103:12",
                "verse" => "As far as the east is from the west, so far has he removed our transgressions from us.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ],
            [
                "reference" => "Romans 3:24",
                "verse" => "And all are justified freely by his grace through the redemption that came by Christ Jesus.",
                "category_id" => $categories["Grace & Forgiveness"]->id
            ]
        ];

        foreach ($verses as $verse) {
            Verse::create($verse);
        }
    }
}