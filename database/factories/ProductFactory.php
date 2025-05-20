<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
// Tag model is niet meer nodig
// use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Caches the categories configuration to avoid redundant processing.
     */
    protected ?array $categoriesData = null;

    /**
     * Retrieves and prepares the detailed categories configuration.
     * Contains hardcoded product generation data per category.
     * Tag-related keys ('base_tags', 'tag_logic') have been removed from this configuration.
     */
    protected function getCategoriesConfig(): array
    {
        if ($this->categoriesData === null) {
            $this->categoriesData = [
                'Elektronica' => [
                    'category_description_for_seeding' => 'Alle soorten consumentenelektronica, gadgets en high-tech apparatuur.',
                    'types' => [
                        'Smartphone Pro XMax', 'UltraBook Laptop G4', 'Draadloze Koptelefoon Elite', '4K Actiecamera Explorer II', 
                        'Geavanceerde Smartwatch Gezondheid Pro+', 'Professionele Grafische Tekentablet 16"', 'Universele Qi Draadloze Oplader Station Duo', 
                        'Compacte Powerbank 30000mAh USB-C PD', 'Krachtige Bluetooth Partyspeaker met RGB', 
                        'Autonome Cinematische HD Drone met GPS Follow-Me & Obstakeldetectie', 'Comfortabele E-reader PaperGlow Plus (300ppi)', 
                        'Immersieve VR Headset "NovaVerse G2"', 'Premium Cinema Soundbar 5.1.2 met Dolby Atmos & Draadloze Subwoofer', 
                        'Ultrabrede Curved Gaming Monitor 34" 165Hz 1ms', 'Slimme Stekker Duo Pack met Energiemeting Wi-Fi', 
                        'Draagbare SSD 2TB USB 3.2 Gen2', 'Mechanisch Gaming Toetsenbord RGB Compact', 'Netwerk Attached Storage (NAS) 4-Bay',
                        'DLP Projector Full HD', 'Hi-Res Audio Speler', 'AI Beveiligingscamera Systeem', 'Slimme Thermostaat V3', 'Digitale Spiegelreflexcamera Kit'
                    ],
                    'adjectives' => [
                        'Allernieuwste Generatie', 'Revolutionair Geavanceerde', 'Vederlichte Compacte Aluminium Design', 
                        'Ongeëvenaarde Professionele Studio-kwaliteit', 'Verrassend Betaalbare Top-', 'Extreme High-Performance Gaming', 
                        'Elegante Ultra-Slim Design', 'Onverwoestbare Robuuste Outdoor', 'Baanbrekend Innovatieve Intelligente Smart', 
                        'Zeer Energiezuinige Eco-Friendly Gecertificeerde', 'Exclusieve Premium Titanium', 'Toekomstbestendige Modulaire', 
                        'Gebruiksvriendelijke Plug-and-Play', 'Intuïtieve Next-Gen', 'Dynamische Krachtpatser', 'Subliem Vormgegeven'
                    ],
                    'features' => [
                        'met razendsnelle 5G en Wi-Fi 6E/7 connectiviteit', 'met een fenomenale batterijduur tot wel 30-40 uur actief gebruik', 
                        'volledig water- en stofdicht conform IP68/IP69K-normering', 'met geavanceerde AI-gestuurde 8K beeldstabilisatie en dynamische autofocus', 
                        'haarscherp, contrastrijk en levendig Super AMOLED / Mini-LED 4K/8K Display met 120Hz ProMotion', 
                        'superieure adaptieve actieve ruisonderdrukking (ANC Pro+) met transparantiemodus', 
                        'speciale eco-modus en slim batterijbeheer voor maximale energiebesparing', 
                        'universele ultrasnelle oplaadtechnologie (USB-C Power Delivery 120W+)', 
                        'NFC, Bluetooth 5.3 LE Audio en Ultra Wideband (UWB) chip', 
                        'uiterst precieze multi-GNSS ontvanger (GPS, GLONASS, Galileo, BeiDou, QZSS)', 
                        'krasbestendig en valbestendig Corning Gorilla Glass Victus+ of Saffierglas', 
                        'geavanceerde biometrische beveiliging (in-display ultrasone vingerafdrukscanner & 3D gezichtsherkenning)', 
                        'meeslepende 3D ruimtelijke audio met head-tracking', 'met quantum dot-technologie voor kleurechtheid', 
                        'AI-optimalisatie voor beeld en geluid', 'ondersteuning voor de nieuwste codecs en standaarden'
                    ],
                    'brands' => [
                        'AlphaTech Innovations X', 'OmegaDigital Systems Pro', 'SpectraGadget Labs Fusion', 'NovaElektronica Corp Apex', 
                        'CoreWare Solutions Elite', 'DigitalPrime Technologies Max', 'Epsilon Dynamics Inc. Quantum', 'QuantumLeap Devices NextGen', 
                        'AstralTech Creations Universe', 'Zenith Future Systems Prime', 'AuraElec Signature', 'StratosGear Terra', 'NexaTech', 
                        'CygnusElec', 'VoltaMax Power', 'Photon Devices', 'Aetherius Sound'
                    ],
                    'materials' => [
                        'Gerecycled Aluminium Chassis', 'Versterkt Polycarbonaat', 'Saffierglas Display', 'Titanium Legering', 
                        'Antibacteriële Coating', 'Eco-vriendelijk Kunststof'
                    ],
                    'description_templates' => [
                        "Ontdek de {adjective} {brand} {type}! Dit technologisch meesterwerk biedt {feature1} en {feature2}, en is perfect ontworpen voor zowel veeleisend dagelijks gebruik als gespecialiseerde professionele toepassingen.",
                        "Ervaar de toekomst van persoonlijke technologie met de {brand} {type}. Superieur uitgerust met {feature1}, {feature2} en {feature3}, is dit innovatieve apparaat een absolute must-have voor de moderne tech-enthousiasteling, professional en early adopter.",
                        "De {adjective} {brand} {type} herdefinieert de standaard in zijn klasse door een verbluffend minimalistisch design te combineren met baanbrekende, intuïtieve functionaliteit. Geniet van {feature1}, een naadloze en snelle gebruikerservaring, en {feature2}, verpakt in een {adjective} en uiterst duurzame behuizing van {material}.",
                        "Zet de volgende stap in innovatie met de {brand} {type}. Dit {adjective} apparaat, gemaakt van {material}, levert {feature1}, {feature2}, en {feature3}, en is ontworpen voor maximale prestaties."
                    ]
                ],
                'Mode & Accessoires' => [
                    'category_description_for_seeding' => 'Kleding, schoeisel, sieraden en mode-accessoires voor elke stijl en gelegenheid.',
                    'types' => [
                        'Linnen Zomer T-shirt', 'Japanse Selvedge Slim-fit Jeans', 'Donsgevulde Lichtgewicht Winterjas', 
                        'Handgemaakte Italiaanse Leren Sneakers', 'Zijden Maxi Jurk met Abstracte Print', 
                        'Zwitsers Automatisch Chronograaf Horloge Saffierglas', 'Titanium Gepolariseerde Aviator Zonnebril UV400', 
                        'Artisanale Volnerf Leren Schoudertas', '100% Kasjmier Sjaal met Franjes', 'Merinowollen Vissers Beanie Muts', 
                        'Naadloze High-waist Compressie Sportlegging', 'Egyptisch Katoenen Kreukvrij Business Overhemd', 
                        'Statement Ketting met Echte Edelstenen', 'Grote Canvas Weekendtas met Lederen Accenten', 
                        'Minimalistische Vegan Leren Portemonnee met RFID-bescherming', 'Vintage Suède Riem', 'Designer Zonnehoed Brede Rand',
                        'Gebreide Oversized Cardigan', 'Zijde Kimono met Bloemenprint', 'Leren Enkellaarsjes met Blokhak', 'Sterling Zilveren Manchetknopen'
                    ],
                    'adjectives' => [
                        'Exclusieve Stijlvolle Italiaanse Couture', 'Ultiem Comfortabele Ademende Biologische', 
                        'Uniek Trendy Vintage Geïnspireerde Limited', 'Klassieke Tijdloze Duurzame Handgemaakte', 
                        'Avantgardistische Moderne Strakke Minimalistische', 'Ethisch Verantwoorde Duurzame Eco-vriendelijke Vegan', 
                        'Gelimiteerde Exclusieve Designer Collaboratie', 'Meesterlijk Ambachtelijk Handgemaakte Originele', 
                        'Nonchalant Casual Chique Veelzijdige', 'Adembenemend Elegante Formele Avond', 
                        'Technisch Functioneel Sportieve High-Performance', 'Opvallende Artistieke', 'Geraffineerd Subtiele', 'Gedurfd Expressieve'
                    ],
                    'materials' => [
                        '100% GOTS-gecertificeerd biologisch Egyptisch katoen', 'premium volnerf Italiaans plantaardig gelooid leer', 
                        'luxueus 22 momme moerbei zijde satijn', 'extra zacht en warm 100% ethisch verkregen merinowol', 
                        'innovatief gerecycled PET-polyester met elastaan voor superieure stretch', 
                        'ademend en verkoelend biologisch linnen-katoen chambray', 
                        'duurzaam en authentiek Japans premium selvedge denim (14oz)', 
                        'chirurgisch roestvrij staal (316L) met duurzame PVD-coating', 'ultralicht en sterk hypoallergeen titanium', 
                        'eco-vriendelijk Pinatex (ananasleer)', 'Tencel™ Lyocell vezels', 'Bamboe Viscose', 'Gerecycled Kasjmier'
                    ],
                    'brands' => [
                        'Atelier ModeFabriek Deluxe Signature', 'StijlAccent Premium Design House', 'TrendSetter Gold Label Limited', 
                        'EcoWear Conscious Future Collection', 'UrbanLook Street Couture Division', 'ClassicChic Heritage Bespoke', 
                        'AvantGarde Mode Experimentals Lab', 'Nomad Travelwear Global Essentials', 'Aura Jewels Artisan Goldsmiths', 
                        'Veritas Leatherworks Mastercraft', 'Silas Sartorial', 'Elysian Threads', 'Vanguard Attire', 'Terra Nova Outfitters'
                    ],
                    'features' => [
                        'een absoluut perfecte, flatterende en moderne pasvorm', 'een uniek, artistiek, handgemaakt en opvallend design', 
                        'uitzonderlijk hoog en langdurig draagcomfort de hele dag door', 
                        'prominent onderdeel van de exclusieve, veelgeprezen nieuwste seizoenscollectie', 
                        'tijdloze elegantie en klasse die trends overstijgt en nooit uit de mode raakt', 
                        'volledig duurzaam, milieuvriendelijk en ethisch verantwoord geproduceerd met traceerbare materialen', 
                        'verfijnd afgewerkt met subtiele, handgemaakte luxe details en signature elementen', 
                        'superieur kleurvast en vormbestendig, zelfs na veelvuldig en zorgvuldig wassen', 
                        'limited edition, slechts enkele stuks wereldwijd beschikbaar', 'verborgen zakken voor extra functionaliteit',
                        'verstelbare elementen voor een gepersonaliseerde fit', 'makkelijk te onderhouden en kreukherstellend'
                    ],
                    'description_templates' => [
                        "Herdefinieer je persoonlijke stijl en upgrade je garderobe met dit {adjective} {material} {type} van het gerenommeerde en exclusieve modehuis {brand}. Een perfecte samensmelting van ongeëvenaard comfort en pure elegantie, ideaal voor elke denkbare gelegenheid en biedt {feature1} en {feature2}.",
                        "Voel je zelfverzekerd, krachtig en zie er onberispelijk en modieus uit in onze exclusieve {brand} {type}. Vervaardigd uit de meest hoogwaardige en duurzame {material} materialen voor een ultiem zacht en luxueus draagcomfort, een {feature1}, een {feature2}, en een duurzame, tijdloze stijl die trends overstijgt.",
                        "Maak een onvergetelijke en gedurfde modieuze indruk met de {adjective} {brand} {type}. Dit unieke en exclusieve designer item combineert {feature1} met een {feature2} en {feature3}, speciaal ontworpen voor de modebewuste individualist die diepe waarde hecht aan sublieme kwaliteit, vakmanschap en originaliteit van {material}.",
                        "Dit {type} van {brand} is de ultieme uiting van {adjective} elegantie. Gemaakt van prachtig {material}, biedt het {feature1}, {feature2} en is een essentieel stuk voor de veeleisende garderobe."
                    ]
                ],
                'Huis & Keuken' => [
                    'category_description_for_seeding' => 'Apparaten, kookgerei, decoratie en meubilair voor huis en keuken.',
                    'types' => [
                        'Zelflerende Slimme LED Thermostaat Kit', 'Intelligente Laser Robotstofzuiger met Automatisch Leegstation en Dweilfunctie', 
                        'Medische Kwaliteit HEPA H13 Luchtreiniger XL (voor grote ruimtes)', 
                        'Professionele Volautomatische Barista Espressomachine met Touchscreen & App', 
                        'Heavy-Duty Professionele Slowjuicer RVS Koudpers', '7-delige Tri-Ply Koperen Pannenset met Glazen Deksels', 
                        'Minimalistische Scandinavische Design Boog Vloerlamp Dimbaar', 'Volledig Ergonomische High-Back Mesh Bureaustoel Deluxe Pro', 
                        'Stille Ultrasone Aroma Geurdiffuser (500ml) met Ambiance LED & Timer', 
                        'Extra Grote Acaciahouten Snijplankenset met Sapgeul (3 stuks)', 
                        'Precisie Digitale Keukenweegschaal Pro RVS (0.1g nauwkeurigheid)', 
                        'Multi-Deurs Smart Koelkast met Family Hub Touchscreen & Interne Camera\'s', 'Sous-Vide Precisie Koker Wi-Fi', 
                        'Inductie Kookplaat FlexZone 5-pits', 'Stoomoven met Pyrolyse Reiniging', 'Modulaire Wandsysteem Kasten', 'Fluwelen Accentstoel'
                    ],
                    'adjectives' => [
                        'Hyper-Efficiënte Energiebesparende', 'Adembenemend Stijlvolle Design', 'Toekomstgerichte Futuristisch Moderne', 
                        'Onverwoestbaar Robuust Duurzame', 'Ingenieus Slimme Compacte', 'Uitzonderlijk Veelzijdige Multifunctionele', 
                        'Extreem Uiterst Gebruiksvriendelijke', 'Zelflerende Intelligente AI-gestuurde', 
                        'Professionele Gastronomie Horeca-kwaliteit', 'Fluisterstille Eco-vriendelijke', 'Ambachtelijk Vervaardigde', 'Ruimtebesparende Modulaire'
                    ],
                    'materials' => [
                        'Hoogwaardig Roestvrij Staal (316L)', 'Gehard Borosilicaatglas', 'Massief Eiken- of Walnoothout', 
                        'Duurzaam Bamboe Composiet', 'BPA-vrij Tritan Kunststof', 'Keramische Anti-aanbaklaag', 'Gerecycled ABS Plastic'
                    ],
                    'features' => [
                        'significant energiebesparend (energielabel A+++) en kostenverlagend', 
                        'extreem eenvoudig te reinigen en te onderhouden dankzij speciale coatings', 
                        'volledig en intuïtief te bedienen met geavanceerde smartphone app en diverse spraakassistenten (Google, Alexa, Siri)', 
                        'vervaardigd uit uitsluitend premium, food-grade en duurzame materialen voor een lange levensduur', 
                        'innovatief en modulair ruimtebesparend design, past in elk interieur', 
                        'verbetert significant het algehele wooncomfort, de productiviteit en de binnenluchtkwaliteit', 
                        'voorzien van geavanceerde automatische functies, sensoren en zelfdiagnose voor optimaal gebruiksgemak', 
                        'nagenoeg volledig fluisterstille werking, ideaal voor slaapkamers en stille omgevingen', 
                        'bekroond met meerdere internationale design- en innovatieprijzen', 'ingebouwde veiligheidsfuncties voor gemoedsrust',
                        'kindveilige bediening en materialen', 'vaatwasserbestendige onderdelen voor eenvoudig onderhoud'
                    ],
                    'brands' => [
                        'HomeComfort Elite Series', 'KeukenPerfect ProChef Line', 'EcoThuis Innovate Systems', 
                        'DesignLiving Signature Collection', 'SmartLiving Solutions Xperience', 'ChefLine Gastronomy Master', 
                        'AtmoSphere Wellness Pro', 'DomusIntelli', 'CulinaMax', 'Habitat Harmony', 'Artisan Home Goods'
                    ],
                    'description_templates' => [
                        "Transformeer je huis tot een oase van comfort en efficiëntie met de {adjective} {brand} {type}. Dit technologische topproduct, gemaakt van {material}, biedt {feature1}, {feature2} en {feature3}, en is ontworpen voor een modern, duurzaam en intelligent huishouden.",
                        "De innovatieve {brand} {type} is een {adjective} en tegelijkertijd onmisbare toevoeging aan elke moderne, designbewuste keuken of woonruimte. Geniet van {feature1}, {feature2} en een {feature3} voor een significant aangenamer en gezonder dagelijks leven, met de duurzaamheid van {material}.",
                        "Ervaar het ultieme gemak en luxe met de {adjective} {brand} {type}. Dit product, vervaardigd uit {material}, is voorzien van {feature1} en {feature2}, waardoor het {feature3} en je dagelijkse routines vereenvoudigt.",
                        "Upgrade uw woonervaring met de {brand} {type}. Deze {adjective} oplossing biedt {feature1}, {feature2}, en een stijlvol design met {material}."
                    ]
                ],
                'Speelgoed & Spellen' => [
                    'category_description_for_seeding' => 'Educatief en vermakelijk speelgoed, spellen en puzzels voor alle leeftijden.',
                    'types' => [
                        'Gigantische Bouwblokken Set (1000 stuks)', 'Interactieve Leerrobot Vriendje', 'Houten Poppenhuis Villa XL', 
                        'Radiografisch Bestuurbare Monster Truck 4x4', 'Uitgebreide Wetenschap Experimenteerkit', 'Strategisch Bordspel "Koninkrijken Strijd"',
                        'Pluche Knuffel Eenhoorn Magisch Glow', 'Educatieve Tablet voor Kinderen Pro', 'Kunst & Knutsel Mega Box Creatief',
                        'Opblaasbaar Springkasteel met Glijbaan & Waterpark', 'Houten Treinset met Bruggen & Tunnels (150-delig)', 
                        'Elektronisch Dartbord Pro Series', '3D Puzzel Wereldberoemde Gebouwen Collectie', 'Rollenspel Verkleedset Superhelden'
                    ],
                    'adjectives' => [
                        'Super Kleurrijke Fantasie', 'Educatief Uitdagende Interactieve', 'Onverwoestbaar Veilige Duurzame', 
                        'Magisch Betoverende Avontuurlijke', 'Gigantische Imposante Ultieme', 'Compacte Reisvriendelijke Draagbare', 
                        'Innovatief Prijswinnende Leerzame', 'Klassiek Nostalgische Geliefde', 'Razendsnelle Actievolle Spannende'
                    ],
                    'materials' => [
                        'Niet-toxisch, BPA-vrij ABS Plastic', 'Duurzaam Europees Beukenhout', 'Zacht Hypoallergeen Pluche', 
                        'Gerecycled Karton met Soja-inkt', 'Kindveilige Siliconen', 'Robuust Metaal'
                    ],
                    'features' => [
                        'stimuleert de fijne motoriek en hand-oogcoördinatie', 'bevordert creatief denken en probleemoplossend vermogen', 
                        'met spectaculaire realistische licht- en geluidseffecten die de zintuigen prikkelen', 
                        'geschikt voor zowel individueel spel als interactie met vriendjes en familie', 
                        'kan zowel binnen als buiten gebruikt worden voor veelzijdig plezier', 
                        'voldoet aan de strengste internationale veiligheidsnormen voor speelgoed (EN71, ASTM)', 
                        'eenvoudig schoon te maken en op te bergen', 'ontworpen om jarenlang speelplezier te garanderen',
                        'helpt bij de ontwikkeling van sociale vaardigheden en samenwerking', 'biedt verschillende moeilijkheidsgraden voor langdurige uitdaging'
                    ],
                    'brands' => [
                        'SpeelPlezier Goud Deluxe', 'LeerSlim Educatief Entertainment', 'FantasieWereld Creaties', 'AvontuurKidz Outdoor Fun',
                        'EcoToy Duurzaam Spelen', 'RoboTech Interactief', 'PluchePal Vriendjes', 'PuzzelPro Breinbrekers', 'MiniAvonturiers'
                    ],
                    'description_templates' => [
                        "Laat de fantasie en creativiteit van je kind de vrije loop met de {adjective} {brand} {type}! Dit prachtige, uitgebreide speelgoed van {material} {feature1}, {feature2} en is perfect voor jonge avonturiers en kleine ontdekkers.",
                        "Ontdek de magische en leerzame wereld van {brand} met dit {adjective} {type}. Dit unieke speelgoed, gemaakt van {material}, is speciaal ontworpen om {feature1}, {feature2} en tegelijkertijd {feature3}, voor gegarandeerd speelsucces.",
                        "Het ideale en meest gewilde cadeau voor elke gelegenheid: de {brand} {type}! {adjective}, {feature1} en {feature2}, dit speelgoed van {material} biedt eindeloos vermaak, ondersteunt de algehele ontwikkeling en tovert een lach op elk gezicht.",
                        "Stimuleer de ontwikkeling met het {adjective} {type} van {brand}. Vervaardigd uit {material}, biedt dit speelgoed {feature1}, {feature2} en {feature3}."
                    ]
                ],
                'Sport & Outdoor' => [
                    'category_description_for_seeding' => 'Uitrusting, kleding en accessoires voor sport, fitness en outdoor avonturen.',
                    'types' => [
                        'Professionele Hardloopschoenen Trail', 'Ultralichte Carbon Racefiets', 'Waterdichte Gore-Tex Hardshell Jas',
                        'Multifunctionele Fitness Tracker met GPS', 'Yoga & Pilates Mat Eco-vriendelijk Extra Dik', 
                        'Verstelbare Dumbbell Set Compact', 'Kampeer Tent 4-Persoons 3-Seizoenen', 'Trekking Rugzak 65L Ergonomisch',
                        'Opvouwbare Elektrische Step Lange Afstand', 'SUP Board Opblaasbaar Compleet Pakket', 
                        'Klimschoenen Allround Performance', 'Isolerende Waterfles RVS 1L Duurzaam', 'Skibril met Verwisselbare Lenzen Sferisch',
                        'Compacte Verrekijker 10x42 Waterdicht'
                    ],
                    'adjectives' => [
                        'Ultralichtgewicht Performance Pro', 'Onverwoestbaar Extreem Duurzame', 'Technisch Geavanceerde Innovatieve', 
                        'Ergonomisch Comfortabele Ademende', 'Competitieklare Professionele Elite', 'Veelzijdige Multifunctionele Allround',
                        'Compacte Reisvriendelijke Opvouwbare', 'Eco-bewuste Duurzaam Geproduceerde', 'Explosieve Krachtige High-Impact'
                    ],
                    'materials' => [
                        'Ademend Gore-Tex Pro Shell', 'Lichtgewicht Carbonfiber Composiet', 'Duurzaam Ripstop Nylon met DWR Coating',
                        'Hoogwaardig Roestvrij Staal', 'Flexibel Neopreen', 'Schokabsorberend EVA-schuim', 'Gerecycled Polyester'
                    ],
                    'features' => [
                        'superieure multidirectionele schokdemping en explosieve energieteruggave voor topprestaties op elke ondergrond', 
                        'geoptimaliseerde aerodynamica voor maximale snelheid en efficiëntie', 
                        'volledig wind- en waterdicht met uitzonderlijk ademend vermogen voor comfort in alle weersomstandigheden', 
                        'geavanceerde tracking van gezondheidsstatistieken, activiteit en slaappatronen', 
                        'YKK AquaGuard® waterdichte ritsen en getapete naden voor complete bescherming', 
                        'reflecterende details voor verbeterde zichtbaarheid en veiligheid in het donker', 
                        'sneldrogend en vochtafvoerend materiaal houdt je droog en comfortabel', 
                        'anti-geur technologie voor langdurige frisheid', 'ingebouwde UV-bescherming (UPF 50+)',
                        'versterkte slijtvaste panelen op kritieke punten', 'compatibel met hydratatiesystemen'
                    ],
                    'brands' => [
                        'SportMax Elite X', 'OutdoorPro Gear Performance', 'FitLife Active Wear Solutions', ' शिखर Adventures Equipment',
                        'EcoTrail Duurzame Sportartikelen', 'AquaRide Watersport Innovaties', 'CycleTech Pro Fietsen', 'Terra Firma Outdoor',
                        'Momentum Fitness Gear'
                    ],
                    'description_templates' => [
                        "Verleg je grenzen en bereik je sportieve topprestaties met de {adjective} {brand} {type}. Dit state-of-the-art product van {material} is speciaal ontworpen voor {feature1} en {feature2}, en vormt de ultieme keuze voor serieuze, gepassioneerde en toegewijde atleten.",
                        "Ga vol vertrouwen, veilig en optimaal voorbereid op elk avontuur met de onverwoestbare {brand} {type}. Deze {adjective} en uiterst robuuste uitrusting van {material} biedt {feature1}, {feature2} en {feature3} voor de ultieme outdoor ervaring onder alle denkbare weersomstandigheden en op elk terrein.",
                        "Optimaliseer je training, maximaliseer je resultaten en geniet van elke beweging met de {adjective} {brand} {type}. Profiteer van {feature1}, {feature2} en een ongeëvenaard, ergonomisch comfort dankzij {material}, zodat jij je volledig kunt focussen op het behalen van je persoonlijke doelen.",
                        "Domineer het veld met de {brand} {type}. Deze {adjective} uitrusting, gemaakt van {material}, levert {feature1} en {feature2} voor de serieuze sporter."
                    ]
                ],
                'Boeken' => [
                    'category_description_for_seeding' => 'Fictie, non-fictie, educatieve boeken en literatuur in diverse genres.',
                    'types' => [
                        'Meeslepende Historische Roman (700 pag.)', 'Spannende Sciencefiction Thriller Boxset', 
                        'Diepgaande Biografie Invloedrijk Persoon', 'Praktisch Handboek Digitale Fotografie Pro', 
                        'Poëziebundel Verzamelde Werken Bekroond', 'Kinderprentenboek Interactief Geluid', 
                        'Kookboek Wereldkeukens Authentiek & Modern', 'Managementboek Strategie & Leiderschap Nieuwe Editie',
                        'Grafische Roman / Manga Serie Compleet', 'Leerboek Programmeren in Python voor Beginners & Gevorderden',
                        'Filosofisch Essay Verzameling', 'Reisgids Avontuurlijke Bestemmingen', 'Young Adult Fantasy Bestseller'
                    ],
                    'adjectives' => [
                        'Meeslepende Internationale Bestseller Hit', 'Prijswinnende Diepgaande Kritisch Acclaimed', 
                        'Prachtig Geïllustreerde Visueel Verbluffende', 'Controversiële Gedachte Prikkelende Onthullende', 
                        'Hartverwarmende Inspirerende Feelgood', 'Pageturner Adembenemende Nagelbijtend Spannende',
                        'Educatieve Uitgebreide Toegankelijke', 'Zeldzame Gelimiteerde Collector\'s Edition', 'Hilarische Satirische Scherpzinnige'
                    ],
                    'materials' => [
                        'FSC-gecertificeerd Crèmekleurig Papier', 'Luxe Hardcover met Linnen Omslag en Stofomslag', 
                        'Flexibele Softcover met Flappen', 'Hoogglans Gelamineerd Papier voor Fotoboeken', 'Duurzame Eco-inkt'
                    ],
                    'features' => [
                        'geschreven door een wereldberoemde, meermaals gelauwerde en alom geprezen bestseller auteur met miljoenen verkochte exemplaren wereldwijd', 
                        'vertaald in meer dan 30 talen en verfilmd tot een succesvolle bioscoopfilm of tv-serie', 
                        'inclusief een exclusief voorwoord van de auteur en bonusmateriaal zoals interviews of verwijderde hoofdstukken', 
                        'rijk geïllustreerd met originele kunstwerken, foto\'s of gedetailleerde kaarten en schema\'s', 
                        'gedrukt op hoogwaardig, zuurvrij papier voor een optimale leeservaring en lange levensduur', 
                        'speciale editie met handtekening van de auteur of unieke nummering', 
                        'inclusief online toegangscode tot aanvullend digitaal materiaal, oefeningen of community forums',
                        'deel van een veelgeprezen en langlopende serie', 'bevat diepgaande analyses en expertcommentaar'
                    ],
                    'brands' => [ // Hier kunnen uitgeverijen of auteurs als "merk" fungeren
                        'Elena Schrijver Gold Collection', 'De Literaire Uil Uitgeverij', 'Wetenschap & Kennis Publicaties', 
                        'FantasieWereld Boeken', 'Meestervertellers Klassiekers', 'Code Academie Leerboeken', 'Historische Perspectieven',
                        'Artemis Prime Press', 'The Storyteller Guild'
                    ],
                    'description_templates' => [
                        "Duik diep in dit {adjective} {type}, een waar meesterwerk geschreven door de legendarische {brand}. Een onvergetelijk, gelaagd en rijk verhaal dat je {feature1} en {feature2} zal bieden, gedrukt op {material}, en je kijk op de wereld en jezelf voorgoed zal veranderen.",
                        "Een {adjective} {type} dat je als fervent en kritisch lezer absoluut niet mag missen en direct aan je collectie moet toevoegen. {brand} presenteert met trots een literair en intellectueel juweel dat {feature1}, {feature2} en tevens {feature3}. Een ware verrijking voor elke boekenkast, uitgevoerd in prachtig {material}, en elke geest die zoekt naar diepgang.",
                        "Verlies jezelf volledig en onherroepelijk in de meeslepende en ingenieuze pagina's van '{type}', het langverwachte nieuwste werk van de gevierde {brand}. Dit {adjective} en alom veelgeprezen boek van {material} is {feature1}, zal je {feature2} en biedt gegarandeerd urenlang leesplezier en stof tot nadenken.",
                        "Het {adjective} {type} van {brand} is een must-read. Met {feature1} en {feature2}, biedt dit boek een unieke leeservaring."
                    ]
                ],
                'Gezondheid & Beauty' => [
                    'category_description_for_seeding' => 'Producten voor persoonlijke verzorging, welzijn, schoonheid en gezondheid.',
                    'types' => [
                        'Klinisch Geteste Anti-Aging Dagcrème SPF50+', 'Biologische Arganolie Haarserum Herstellend', 
                        'Elektrische Tandenborstel Sonisch Pro Clean', 'Aromatherapie Diffuser Ultrasoon Houtdesign', 
                        'Natuurlijke Deodorant Stick Aluminiumvrij Gevoelige Huid', 'Vitamine C Supplement Hooggedoseerd Liposomaal',
                        'Zijdezacht Bamboe Badjas Unisex Luxe', 'Professionele Make-up Kwastenset Vegan Haren (12-delig)',
                        'Baardverzorging Set Compleet met Olie, Balsem en Kam', 'Thuis Fitness Weerstandsbanden Set Pro',
                        'Slaapmasker Zijde Verduisterend Ergonomisch', 'Massage Gun Diepe Weefsel Percussie Therapie', 'Detox Kleimasker Actieve Houtskool'
                    ],
                    'adjectives' => [
                        'Klinisch Bewezen Revolutionair Effectieve', '100% Natuurlijke Biologische Gecertificeerde', 
                        'Dermatologisch Geteste Hypoallergene Zachte', 'Innovatieve Wetenschappelijk Onderbouwde Geavanceerde',
                        'Verjongende Herstellende Revitaliserende', 'Kalmerende Rustgevende Ontspannende Pure',
                        'Luxueuze Premium Spa-kwaliteit Professionele', 'Vegan Dierproefvrije Ethisch Verantwoorde', 'Verfrissende Energieke Stimulerende'
                    ],
                    'materials' => [ // Deze waren al goed, eventueel kleine toevoegingen
                        'hoogmoleculair en laagmoleculair hyaluronzuurcomplex', 'gestabiliseerde en geëncapsuleerde vitamine C (L-ascorbinezuur 20%)', 
                        'koudgeperste, ongeraffineerde biologische arganolie en jojoba-olie', 'geconcentreerd puur aloë vera gel extract (200:1)', 
                        'extracten van groene thee, kamille, calendula en zoethoutwortel', 'rijke biologische en fairtrade shea butter en cacaoboter', 
                        'professionele ionische keramische toermalijn technologie', 'actieve houtskool poeder en bentoniet- en kaolienklei', 
                        'pure essentiële oliën van rozen, lavendel en sandelhout', 'bakuchiol (natuurlijk retinol alternatief) en peptidencomplex', 
                        'probiotica en prebiotica voor de huidflora', 'extract van algen en zeewier', 'natuurlijke minerale pigmenten'
                    ],
                    'features' => [
                        'zichtbaar rimpelverminderend, huidverstevigend en elasticiteit-verhogend binnen slechts 2-4 weken consistent gebruik', 
                        'diep hydraterend en voedend voor een zijdezachte, soepele en stralende huid of glanzend haar', 
                        'vrij van parabenen, sulfaten, ftalaten, siliconen, synthetische kleurstoffen en parfums', 
                        'verrijkt met krachtige antioxidanten die beschermen tegen vrije radicalen en vroegtijdige veroudering', 
                        'ondersteunt het natuurlijke herstelvermogen van de huid en versterkt de huidbarrière', 
                        'geschikt voor alle huidtypen, inclusief de gevoelige, acne-gevoelige of rijpe huid', 
                        'verbetert de algehele gezondheid en weerstand van het lichaam en geest', 
                        'zorgt voor een ontspannen en evenwichtig gevoel, vermindert stress en bevordert een goede nachtrust',
                        'duurzaam verpakt in recyclebare of biologisch afbreekbare materialen', 'stimuleert de collageenproductie',
                        'biedt breedspectrum UVA/UVB bescherming'
                    ],
                    'brands' => [
                        'DermaPure Advance Clinical Skincare', 'NatuurKracht Organics & Wellness', 'BeautySense Laboratoires Paris', 
                        'Vitalis Health Supplements Pro', 'ZenGarden Aromatherapie Essentials', 'ManCave Grooming Co. Premium', 
                        'EcoBeauty Verantwoorde Cosmetica', 'Aura Glow Naturals', 'Serene Rituals Bodycare'
                    ],
                    'description_templates' => [
                        "Ervaar de wetenschappelijk bewezen en transformerende kracht van {material} met de {adjective} {brand} {type}. Deze geavanceerde, met zorg ontwikkelde formule {feature1}, {feature2} en {feature3} voor een zichtbaar gezondere, stralende, veerkrachtige en jeugdige uitstraling.",
                        "Verwen jezelf en je huid/haar/lichaam met de pure, geconcentreerde luxe van {brand} {type}. Dit {adjective}, met passie en expertise samengestelde product met {material} is {feature1}, {feature2} en helpt je jouw natuurlijke schoonheid en welzijn te {feature3} en langdurig te behouden.",
                        "De revolutionaire {adjective} {brand} {type} is jouw dagelijkse, onmisbare geheim voor {feature1} en een stralend, zelfverzekerd gevoel. Dankzij de unieke combinatie van {material}, {feature2} en {feature3} voel je je elke dag op je allerbest, van binnen en van buiten.",
                        "Ontdek de {adjective} {type} van {brand}, verrijkt met {material}. Het belooft {feature1}, {feature2} en een boost voor {feature3}."
                    ]
                ],
            ];

            // Ensure all category configurations have default fallbacks for essential keys
            foreach ($this->categoriesData as $categoryKey => &$categoryConfig) {
                $categoryConfig['category_description_for_seeding'] = $categoryConfig['category_description_for_seeding'] ?? "Algemene producten in de categorie {$categoryKey}";
                $categoryConfig['types'] = $categoryConfig['types'] ?? ['Standaard Type in '.$categoryKey];
                $categoryConfig['adjectives'] = $categoryConfig['adjectives'] ?? ['Algemeen'];
                $categoryConfig['brands'] = $categoryConfig['brands'] ?? ['Merkloos'];
                $categoryConfig['description_templates'] = $categoryConfig['description_templates'] ?? ["Dit is een {adjective} {brand} {type} uit de categorie {$categoryKey}. Het heeft {feature1} en {feature2}."];
                $categoryConfig['features'] = $categoryConfig['features'] ?? ['standaard feature', 'goede kwaliteit'];
                $categoryConfig['materials'] = $categoryConfig['materials'] ?? ['standaard materiaal'];
                // base_tags and tag_logic are now fully removed from consideration here
            }
            unset($categoryConfig); // Unset reference
        }
        return $this->categoriesData;
    }

    public function definition(): array
    {
        Log::debug("ProductFactory Definition START");
        $categoriesConfig = $this->getCategoriesConfig();

        if (empty($categoriesConfig)) {
            Log::critical('ProductFactory: categoriesData is EMPTY or not correctly initialized! Check getCategoriesConfig(). Using error fallback.');
            $errorCategory = Category::firstOrCreate(
                ['name' => 'Uncategorized/Error'],
                ['slug' => Str::slug('Uncategorized/Error'), 'description' => 'Default category for factory errors due to missing configuration.']
            );

            return [
                'category_id' => $errorCategory->id,
                'name' => 'FABRIEKSFOUT: Product Configuratie Data Ontbreekt!',
                'description' => 'De $categoriesData array in ProductFactory::getCategoriesConfig() is leeg of incorrect geladen. Controleer de factory code.',
                'external_id' => 'FATAL_ERROR-' . strtoupper(Str::random(8)),
                'ai_enhanced_description' => null,
            ];
        }

        $chosenCategoryNameFromConfig = $this->faker->randomElement(array_keys($categoriesConfig));
        $categorySpecificConfig = $categoriesConfig[$chosenCategoryNameFromConfig];

        $categoryModel = Category::firstOrCreate(
            ['name' => $chosenCategoryNameFromConfig],
            [
                'slug' => Str::slug($chosenCategoryNameFromConfig),
                // Use the specific description if available, otherwise fallback
                'description' => $categorySpecificConfig['category_description_for_seeding'] ?? "Producten in de categorie {$chosenCategoryNameFromConfig}",
            ]
        );

        $type = $this->faker->randomElement($categorySpecificConfig['types']);
        $adjective = $this->faker->randomElement($categorySpecificConfig['adjectives']);
        $brand = $this->faker->randomElement($categorySpecificConfig['brands']);
        // Ensure material is always available by using the fallback from the loop if not defined per category,
        // or a general fallback if somehow still null (though the loop should prevent this).
        $material = $this->faker->randomElement($categorySpecificConfig['materials'] ?? ['standaard materiaal']);


        $productName = "{$adjective} {$brand} {$type}";
        if ($this->faker->boolean(60)) { // 60% chance to shuffle name parts for more variety
            $nameParts = [$adjective, $brand, $type];
            if ($this->faker->boolean(30) && $chosenCategoryNameFromConfig !== 'Boeken') { // Occasionally add material to name
                 $nameParts[] = "({$material})";
            }
            shuffle($nameParts);
            $productName = implode(' ', $nameParts);
        }
        // Specific name patterns for certain categories can add more realism
        if ($chosenCategoryNameFromConfig === 'Speelgoed & Spellen') {
             $variant = $this->faker->randomElement(['', " Deluxe Editie", " Pretpark Editie", " Avonturenset", " Educatieve Versie"]);
             $namePattern = $this->faker->randomElement([1,2,3,4]); 
             switch($namePattern) {
                case 1: $productName = "{$adjective} {$brand} {$type}{$variant}"; break;
                case 2: $productName = "{$brand} {$type} - {$adjective} Speelplezier{$variant}"; break;
                case 3: $productName = "De Ultieme {$type} van {$brand} ({$adjective}){$variant}"; break;
                case 4: $productName = "{$adjective} {$type} ({$brand}){$variant}"; break;
             }
        } elseif ($chosenCategoryNameFromConfig === 'Elektronica') {
            if ($this->faker->boolean(25)) { // Add model numbers or series
                $productName .= $this->faker->randomElement([' X2000', ' Pro Series', ' Mark II', ' G5 Edition', ' Ultra']);
            }
        }

        $productName = Str::title(trim(preg_replace('/\s+/', ' ', $productName))); // Ensure single spaces and title case
        $productName = substr($productName, 0, 250); // Ensure name isn't too long for DB

        $categoryFeatures = $categorySpecificConfig['features'];
        $numAvailableFeatures = count($categoryFeatures);
        // Pick 2 to 3 features, or fewer if not enough are available.
        $numFeaturesToPick = $numAvailableFeatures > 0 ? min($numAvailableFeatures, $this->faker->numberBetween(2, ($numAvailableFeatures >=3 ? 3 : $numAvailableFeatures))) : 0;
        
        $descFeatures = [];
        if ($numFeaturesToPick > 0 && $numAvailableFeatures > 0) {
             $descFeatures = (array) $this->faker->randomElements($categoryFeatures, $numFeaturesToPick, false); // Ensure unique features
        }
        
        // Provide fallbacks for features if not enough are picked (e.g., if a category has <2 features defined)
        $feature1 = $descFeatures[0] ?? $this->faker->sentence(8); // Slightly longer fallback
        $feature2 = $descFeatures[1] ?? ($numFeaturesToPick >= 2 ? $this->faker->sentence(7) : ($this->faker->boolean(50) ? $this->faker->catchPhrase() : '')); // Varied fallback
        $feature3 = $descFeatures[2] ?? ($numFeaturesToPick >= 3 ? $this->faker->sentence(9) : ''); // Fallback, possibly empty

        // Filter out empty features before using them in templates
        $featurePlaceholders = ['{feature1}', '{feature2}', '{feature3}'];
        $actualFeatures = array_filter([$feature1, $feature2, $feature3], fn($f) => !empty(trim($f)));
        $descriptionTemplate = $this->faker->randomElement($categorySpecificConfig['description_templates']);
        
        // Dynamically adjust template based on available features to avoid empty ", ," or similar
        $tempDesc = $descriptionTemplate;

        // Simplified replacement logic:
        // Replace features first, then other placeholders.
        // This basic replacement assumes templates are structured to handle missing features gracefully
        // or that feature placeholders are distinct enough not to cause issues if one is empty.
        $tempDesc = str_replace('{feature1}', $feature1, $tempDesc);
        $tempDesc = str_replace('{feature2}', $feature2, $tempDesc);
        $tempDesc = str_replace('{feature3}', $feature3, $tempDesc);

        $productDescription = str_replace(
            ['{adjective}', '{brand}', '{type}', '{material}'],
            [Str::lower($adjective), $brand, Str::lower($type), $material],
            $tempDesc
        );
        
        // Clean up potential double commas or hanging conjunctions due to empty features (basic cleanup)
        $productDescription = preg_replace('/,\s*,/', ',', $productDescription);
        $productDescription = preg_replace('/en\s*,/', 'en ', $productDescription);
        $productDescription = preg_replace('/,\s*en\s*$/', '', $productDescription); // Remove trailing ", en "
        $productDescription = preg_replace('/,\s*$/', '', $productDescription); // Remove trailing comma
        $productDescription = preg_replace('/\s{2,}/', ' ', $productDescription); // Normalize spaces


        $productDescription .= " " . $this->faker->paragraphs($this->faker->numberBetween(1, 3), true); // More paragraphs for variety
        $productDescription = ucfirst(trim($productDescription));

        Log::debug("ProductFactory Definition END - Product: {$productName}", [
            'selected_category_id' => $categoryModel->id,
            'chosen_category_name' => $chosenCategoryNameFromConfig
        ]);

        return [
            'category_id' => $categoryModel->id,
            'name' => $productName,
            'description' => $productDescription,
            'external_id' => 'PROD-' . strtoupper(Str::random(12)),
            'ai_enhanced_description' => null, // Keep this null as per original
        ];
    }

    public function configure(): static
    {
        Log::debug("ProductFactory Configure START - Setting up hooks.");
        return $this->afterMaking(function (Product $product) {
            Log::debug("ProductFactory AfterMaking - Product Name: {$product->name}, Category ID: {$product->category_id}");
        })->afterCreating(function (Product $product) {
            Log::info("ProductFactory AfterCreating - Product CREATED - ID: {$product->id}, Name: {$product->name}, Category ID: {$product->category_id}");
        });
    }
}