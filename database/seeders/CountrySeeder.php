<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Country::factory()->create([
            'country' => "Afghanistan, Afghānistān, Afghanistan (l'), Afghānistān",
            'id' => "AFG",
        ]);
        Country::factory()->create([
            'country' => "Albania, Albanie (l'), Shqipëria; Shqipëri",
            'id' => "ALB",
        ]);
        Country::factory()->create([
            'country' => "Al Jazā'ir, Algeria, Algérie (l')",
            'id' => "DZA",
        ]);
        Country::factory()->create([
            'country' => "American Samoa, Samoa américaines (les)",
            'id' => "ASM",
        ]);
        Country::factory()->create([
            'country' => "Andorra, Andorra, Andorre (l')",
            'id' => "AND",
        ]);
        Country::factory()->create([
            'country' => "Angola, Angola (l'), Angola",
            'id' => "AGO",
        ]);
        Country::factory()->create([
            'country' => "Anguilla, Anguilla",
            'id' => "AIA",
        ]);
        Country::factory()->create([
            'country' => "Antarctica, Antarctique (l')",
            'id' => "ATA",
        ]);
        Country::factory()->create([
            'country' => "Antigua and Barbuda, Antigua-et-Barbuda",
            'id' => "ATG",
        ]);
        Country::factory()->create([
            'country' => "Argentina, Argentine (l'), Argentina (la)",
            'id' => "ARG",
        ]);
        Country::factory()->create([
            'country' => "Armenia, Arménie (l'), Hayastan",
            'id' => "ARM",
        ]);
        Country::factory()->create([
            'country' => "Aruba, Aruba, Aruba, Aruba",
            'id' => "ABW",
        ]);
        Country::factory()->create([
            'country' => "Australia, Australie (l')",
            'id' => "AUS",
        ]);
        Country::factory()->create([
            'country' => "Österreich, Austria, Autriche (l')",
            'id' => "AUT",
        ]);
        Country::factory()->create([
            'country' => "Azərbaycan, Azerbaijan, Azerbaïdjan (l')",
            'id' => "AZE",
        ]);
        Country::factory()->create([
            'country' => "Bahamas (The), Bahamas (Les)",
            'id' => "BHS",
        ]);
        Country::factory()->create([
            'country' => "Al Baḩrayn, Bahrain, Bahreïn",
            'id' => "BHR",
        ]);
        Country::factory()->create([
            'country' => "Bāṁlādesh, Bangladesh, Bangladesh (le)",
            'id' => "BGD",
        ]);
        Country::factory()->create([
            'country' => "Barbados, Barbade (la)",
            'id' => "BRB",
        ]);
        Country::factory()->create([
            'country' => "Bielaruś, Belarus, Bélarus (le), Belarus'",
            'id' => "BLR",
        ]);
        Country::factory()->create([
            'country' => "Belgien, Belgium, Belgique (la), België",
            'id' => "BEL",
        ]);
        Country::factory()->create([
            'country' => "Belize, Belize (le)",
            'id' => "BLZ",
        ]);
        Country::factory()->create([
            'country' => "Benin, Bénin (le)",
            'id' => "BEN",
        ]);
        Country::factory()->create([
            'country' => "Bermuda, Bermudes (les)",
            'id' => "BMU",
        ]);
        Country::factory()->create([
            'country' => "Åland Islands, Åland(les Îles), Åland",
            'id' => "ALA",
        ]);
        Country::factory()->create([
            'country' => "Druk-Yul, Bhutan, Bhoutan (le)",
            'id' => "BTN",
        ]);
        Country::factory()->create([
            'country' => "Bolivia (Plurinational State of), Bolivie (État plurinational de), Bolivia,  Estado Plurinacional de",
            'id' => "BOL",
        ]);
        Country::factory()->create([
            'country' => "Bonaire, Sint Eustatius and Saba, Bonaire, Saint-Eustache et Saba, Bonaire, Sint Eustatius en Saba, Boneiru, Sint Eustatius y Saba",
            'id' => "BES",
        ]);
        Country::factory()->create([
            'country' => "Bosna i Hercegovina, Bosnia and Herzegovina, Bosnie-Herzégovine (la), Bosna i Hercegovina, Bosna i Hercegovina",
            'id' => "BIH",
        ]);
        Country::factory()->create([
            'country' => "Botswana, Botswana (le)",
            'id' => "BWA",
        ]);
        Country::factory()->create([
            'country' => "Bouvet Island, Bouvet (l'Île), Bouvetøya, Bouvetøya",
            'id' => "BVT",
        ]);
        Country::factory()->create([
            'country' => "Brazil, Brésil (le), Brasil (o)",
            'id' => "BRA",
        ]);
        Country::factory()->create([
            'country' => "British Indian Ocean Territory (the), Indien (le Territoire britannique de l'océan)",
            'id' => "IOT",
        ]);
        Country::factory()->create([
            'country' => "Brunei Darussalam, Brunéi Darussalam (le), Negara Brunei Darussalam",
            'id' => "BRN",
        ]);
        Country::factory()->create([
            'country' => "Bulgaria, Bulgaria, Bulgarie (la)",
            'id' => "BGR",
        ]);
        Country::factory()->create([
            'country' => "Burkina Faso, Burkina Faso (le)",
            'id' => "BFA",
        ]);
        Country::factory()->create([
            'country' => "Burundi, Burundi (le), Burundi",
            'id' => "BDI",
        ]);
        Country::factory()->create([
            'country' => "Cabo Verde, Cabo Verde, Cabo Verde",
            'id' => "CPV",
        ]);
        Country::factory()->create([
            'country' => "Cambodia, Cambodge (le), Kâmpŭchéa",
            'id' => "KHM",
        ]);
        Country::factory()->create([
            'country' => "Cameroon, Cameroun (le)",
            'id' => "CMR",
        ]);
        Country::factory()->create([
            'country' => "Canada, Canada (le)",
            'id' => "CAN",
        ]);
        Country::factory()->create([
            'country' => "Cayman Islands (the), Caïmans (les Îles)",
            'id' => "CYM",
        ]);
        Country::factory()->create([
            'country' => "Central African Republic (the), République centrafricaine (la), Ködörösêse tî Bêafrîka",
            'id' => "CAF",
        ]);
        Country::factory()->create([
            'country' => "Tshād, Chad, Tchad (le)",
            'id' => "TCD",
        ]);
        Country::factory()->create([
            'country' => "Chile, Chili (le), Chile",
            'id' => "CHL",
        ]);
        Country::factory()->create([
            'country' => "China, Chine (la), Zhongguo",
            'id' => "CHN",
        ]);
        Country::factory()->create([
            'country' => "Christmas Island, Christmas (l'Île)",
            'id' => "CXR",
        ]);
        Country::factory()->create([
            'country' => "Cocos (Keeling) Islands (the), Cocos (les Îles)/ Keeling (les Îles)",
            'id' => "CCK",
        ]);
        Country::factory()->create([
            'country' => "Colombia, Colombie (la), Colombia",
            'id' => "COL",
        ]);
        Country::factory()->create([
            'country' => "Komori, Al Qamar, Comoros (the), Comores (les)",
            'id' => "COM",
        ]);
        Country::factory()->create([
            'country' => "Congo (the Democratic Republic of the), Congo (la République démocratique du)",
            'id' => "COD",
        ]);
        Country::factory()->create([
            'country' => "Congo (the), Congo (le)",
            'id' => "COG",
        ]);
        Country::factory()->create([
            'country' => "Cook Islands (the), Cook (les Îles)",
            'id' => "COK",
        ]);
        Country::factory()->create([
            'country' => "Costa Rica, Costa Rica (le), Costa Rica",
            'id' => "CRI",
        ]);
        Country::factory()->create([
            'country' => "Croatia, Croatie (la), Hrvatska",
            'id' => "HRV",
        ]);
        Country::factory()->create([
            'country' => "Cuba, Cuba, Cuba",
            'id' => "CUB",
        ]);
        Country::factory()->create([
            'country' => "Curaçao, Curaçao, Curaçao, Kòrsou",
            'id' => "CUW",
        ]);
        Country::factory()->create([
            'country' => "Kýpros, Cyprus, Chypre, Kıbrıs",
            'id' => "CYP",
        ]);
        Country::factory()->create([
            'country' => "Česko, Czechia, Tchéquie (la)",
            'id' => "CZE",
        ]);
        Country::factory()->create([
            'country' => "Côte d'Ivoire, Côte d'Ivoire (la)",
            'id' => "CIV",
        ]);
        Country::factory()->create([
            'country' => "Danmark, Denmark, Danemark (le)",
            'id' => "DNK",
        ]);
        Country::factory()->create([
            'country' => "Jībūtī, Djibouti, Djibouti",
            'id' => "DJI",
        ]);
        Country::factory()->create([
            'country' => "Dominica, Dominique (la)",
            'id' => "DMA",
        ]);
        Country::factory()->create([
            'country' => "Dominican Republic (the), dominicaine (la République), República Dominicana (la)",
            'id' => "DOM",
        ]);
        Country::factory()->create([
            'country' => "Ecuador, Équateur (l'), Ecuador (el)",
            'id' => "ECU",
        ]);
        Country::factory()->create([
            'country' => "Mişr, Egypt, Égypte (l')",
            'id' => "EGY",
        ]);
        Country::factory()->create([
            'country' => "El Salvador, El Salvador, El Salvador",
            'id' => "SLV",
        ]);
        Country::factory()->create([
            'country' => "Equatorial Guinea, Guinée équatoriale (la), Guiné Equatorial (a), Guinea Ecuatorial",
            'id' => "GNQ",
        ]);
        Country::factory()->create([
            'country' => "Irītrīyā, Eritrea, Érythrée (l'), Iertra",
            'id' => "ERI",
        ]);
        Country::factory()->create([
            'country' => "Estonia, Eesti, Estonie (l')",
            'id' => "EST",
        ]);
        Country::factory()->create([
            'country' => "Eswatini, Eswatini (l'), eSwatini",
            'id' => "SWZ",
        ]);
        Country::factory()->create([
            'country' => "Ītyop'iya, Ethiopia, Éthiopie (l')",
            'id' => "ETH",
        ]);
        Country::factory()->create([
            'country' => "Falkland Islands (the) [Malvinas], Falkland (les Îles)/Malouines (les Îles)",
            'id' => "FLK",
        ]);
        Country::factory()->create([
            'country' => "Færøerne, Faroe Islands (the), Føroyar, Féroé (les Îles)",
            'id' => "FRO",
        ]);
        Country::factory()->create([
            'country' => "Fiji, Viti, Fidji (les)",
            'id' => "FJI",
        ]);
        Country::factory()->create([
            'country' => "Finland, Suomi, Finlande (la), Finland",
            'id' => "FIN",
        ]);
        Country::factory()->create([
            'country' => "France, France (la)",
            'id' => "FRA",
        ]);
        Country::factory()->create([
            'country' => "French Guiana, Guyane française (la )",
            'id' => "GUF",
        ]);
        Country::factory()->create([
            'country' => "French Polynesia, Polynésie française (la)",
            'id' => "PYF",
        ]);
        Country::factory()->create([
            'country' => "French Southern Territories (the), Terres australes françaises (les)",
            'id' => "ATF",
        ]);
        Country::factory()->create([
            'country' => "Gabon, Gabon (le)",
            'id' => "GAB",
        ]);
        Country::factory()->create([
            'country' => "Gambia (the), Gambie (la)",
            'id' => "GMB",
        ]);
        Country::factory()->create([
            'country' => "Georgia, Géorgie (la), Sakartvelo",
            'id' => "GEO",
        ]);
        Country::factory()->create([
            'country' => "Deutschland, Germany, Allemagne (l')",
            'id' => "DEU",
        ]);
        Country::factory()->create([
            'country' => "Ghana, Ghana (le)",
            'id' => "GHA",
        ]);
        Country::factory()->create([
            'country' => "Gibraltar, Gibraltar",
            'id' => "GIB",
        ]);
        Country::factory()->create([
            'country' => "Elláda, Greece, Grèce (la)",
            'id' => "GRC",
        ]);
        Country::factory()->create([
            'country' => "Grønland, Greenland, Groenland (le), Kalaallit Nunaat",
            'id' => "GRL",
        ]);
        Country::factory()->create([
            'country' => "Grenada, Grenade (la)",
            'id' => "GRD",
        ]);
        Country::factory()->create([
            'country' => "Guadeloupe, Guadeloupe (la)",
            'id' => "GLP",
        ]);
        Country::factory()->create([
            'country' => "Guam, Guam",
            'id' => "GUM",
        ]);
        Country::factory()->create([
            'country' => "Guatemala, Guatemala (le), Guatemala",
            'id' => "GTM",
        ]);
        Country::factory()->create([
            'country' => "Guernsey, Guernesey",
            'id' => "GGY",
        ]);
        Country::factory()->create([
            'country' => "Guinea, Guinée (la)",
            'id' => "GIN",
        ]);
        Country::factory()->create([
            'country' => "Guinea-Bissau, Guinée-Bissau (la), Guiné-Bissau (a)",
            'id' => "GNB",
        ]);
        Country::factory()->create([
            'country' => "Guyana, Guyana (le)",
            'id' => "GUY",
        ]);
        Country::factory()->create([
            'country' => "Haiti, Haïti, Ayiti",
            'id' => "HTI",
        ]);
        Country::factory()->create([
            'country' => "Heard Island and McDonald Islands, Heard-et-Îles MacDonald (l'Île)",
            'id' => "HMD",
        ]);
        Country::factory()->create([
            'country' => "Holy See (the), Saint-Siège (le), Santa Sede (la), Sancta Sedes",
            'id' => "VAT",
        ]);
        Country::factory()->create([
            'country' => "Honduras, Honduras (le), Honduras",
            'id' => "HND",
        ]);
        Country::factory()->create([
            'country' => "Hong Kong, Hong Kong, Xianggang",
            'id' => "HKG",
        ]);
        Country::factory()->create([
            'country' => "Hungary, Hongrie (la), Magyarország",
            'id' => "HUN",
        ]);
        Country::factory()->create([
            'country' => "Iceland, Islande (l'), Ísland",
            'id' => "ISL",
        ]);
        Country::factory()->create([
            'country' => "India, Inde (l'), Bhārat",
            'id' => "IND",
        ]);
        Country::factory()->create([
            'country' => "Indonesia, Indonésie (l'), Indonesia",
            'id' => "IDN",
        ]);
        Country::factory()->create([
            'country' => "Iran (Islamic Republic of), Jomhūrī-ye Eslāmī-ye Īrān, Iran (République Islamique d')",
            'id' => "IRN",
        ]);
        Country::factory()->create([
            'country' => "Al ‘Irāq, Iraq, Iraq (l'), ‘Êraq",
            'id' => "IRQ",
        ]);
        Country::factory()->create([
            'country' => "Ireland, Irlande (l'), Éire",
            'id' => "IRL",
        ]);
        Country::factory()->create([
            'country' => "Isle of Man, Île de Man",
            'id' => "IMN",
        ]);
        Country::factory()->create([
            'country' => "Isrā'īl, Israel, Israël, Yisra'el",
            'id' => "ISR",
        ]);
        Country::factory()->create([
            'country' => "Italy, Italie (l'), Italia (l')",
            'id' => "ITA",
        ]);
        Country::factory()->create([
            'country' => "Jamaica, Jamaïque (la)",
            'id' => "JAM",
        ]);
        Country::factory()->create([
            'country' => "Japan, Japon (le), Nihon/Nippon",
            'id' => "JPN",
        ]);
        Country::factory()->create([
            'country' => "Jersey, Jersey",
            'id' => "JEY",
        ]);
        Country::factory()->create([
            'country' => "Al Urdun, Jordan, Jordanie (la)",
            'id' => "JOR",
        ]);
        Country::factory()->create([
            'country' => "Kazakhstan, Kazakhstan (le), Qazaqstan, Kazahstan",
            'id' => "KAZ",
        ]);
        Country::factory()->create([
            'country' => "Kenya, Kenya (le), Kenya",
            'id' => "KEN",
        ]);
        Country::factory()->create([
            'country' => "Kiribati, Kiribati, Kiribati",
            'id' => "KIR",
        ]);
        Country::factory()->create([
            'country' => "Korea (the Democratic People's Republic of), Corée (la République populaire démocratique de), Chosŏn",
            'id' => "PRK",
        ]);
        Country::factory()->create([
            'country' => "Korea (the Republic of), Corée (la République de), Hanguk",
            'id' => "KOR",
        ]);
        Country::factory()->create([
            'country' => "Al Kuwayt, Kuwait, Koweït (le)",
            'id' => "KWT",
        ]);
        Country::factory()->create([
            'country' => "Kyrgyzstan, Kirghizistan (le), Kyrgyzstan, Kyrgyzstan",
            'id' => "KGZ",
        ]);
        Country::factory()->create([
            'country' => "Lao People's Democratic Republic (the), Lao (la République démocratique populaire), Sathalanalat Paxathipatai Paxaxôn Lao",
            'id' => "LAO",
        ]);
        Country::factory()->create([
            'country' => "Latvia, Lettonie (la), Latvija",
            'id' => "LVA",
        ]);
        Country::factory()->create([
            'country' => "Lubnān, Lebanon, Liban (le)",
            'id' => "LBN",
        ]);
        Country::factory()->create([
            'country' => "Lesotho, Lesotho (le), Lesotho",
            'id' => "LSO",
        ]);
        Country::factory()->create([
            'country' => "Liberia, Libéria (le)",
            'id' => "LBR",
        ]);
        Country::factory()->create([
            'country' => "Lībiyā, Libya, Libye (la)",
            'id' => "LBY",
        ]);
        Country::factory()->create([
            'country' => "Liechtenstein, Liechtenstein, Liechtenstein (le)",
            'id' => "LIE",
        ]);
        Country::factory()->create([
            'country' => "Lithuania, Lituanie (la), Lietuva",
            'id' => "LTU",
        ]);
        Country::factory()->create([
            'country' => "Luxemburg, Luxembourg, Luxembourg (le), Lëtzebuerg",
            'id' => "LUX",
        ]);
        Country::factory()->create([
            'country' => "Macao, Macao, Macau, Aomen",
            'id' => "MAC",
        ]);
        Country::factory()->create([
            'country' => "Madagascar, Madagascar, Madagasikara",
            'id' => "MDG",
        ]);
        Country::factory()->create([
            'country' => "Malawi, Malawi (le), Malaŵi",
            'id' => "MWI",
        ]);
        Country::factory()->create([
            'country' => "Malaysia, Malaisie (la), Malaysia",
            'id' => "MYS",
        ]);
        Country::factory()->create([
            'country' => "Dhivehi Raajje, Maldives, Maldives (les)",
            'id' => "MDV",
        ]);
        Country::factory()->create([
            'country' => "Mali, Mali (le)",
            'id' => "MLI",
        ]);
        Country::factory()->create([
            'country' => "Malta, Malte, Malta",
            'id' => "MLT",
        ]);
        Country::factory()->create([
            'country' => "Marshall Islands (the), Marshall (les Îles), Aelōn̄ in M̧ajeļ",
            'id' => "MHL",
        ]);
        Country::factory()->create([
            'country' => "Martinique, Martinique (la)",
            'id' => "MTQ",
        ]);
        Country::factory()->create([
            'country' => "Mūrītāniyā, Mauritania, Mauritanie (la)",
            'id' => "MRT",
        ]);
        Country::factory()->create([
            'country' => "Mauritius, Maurice",
            'id' => "MUS",
        ]);
        Country::factory()->create([
            'country' => "Mayotte, Mayotte",
            'id' => "MYT",
        ]);
        Country::factory()->create([
            'country' => "Mexico, Mexique (le), México",
            'id' => "MEX",
        ]);
        Country::factory()->create([
            'country' => "Micronesia (Federated States of), Micronésie (États fédérés de)",
            'id' => "FSM",
        ]);
        Country::factory()->create([
            'country' => "Moldova (the Republic of), Moldova (la République de), Republica Moldova",
            'id' => "MDA",
        ]);
        Country::factory()->create([
            'country' => "Monaco, Monaco",
            'id' => "MCO",
        ]);
        Country::factory()->create([
            'country' => "Mongolia, Mongolie (la), Mongol",
            'id' => "MNG",
        ]);
        Country::factory()->create([
            'country' => "Crna Gora, Montenegro, Monténégro (le)",
            'id' => "MNE",
        ]);
        Country::factory()->create([
            'country' => "Montserrat, Montserrat",
            'id' => "MSR",
        ]);
        Country::factory()->create([
            'country' => "Al Maghrib, Morocco, Maroc (le)",
            'id' => "MAR",
        ]);
        Country::factory()->create([
            'country' => "Mozambique, Mozambique (le), Moçambique",
            'id' => "MOZ",
        ]);
        Country::factory()->create([
            'country' => "Myanmar, Myanmar (le), Myanma",
            'id' => "MMR",
        ]);
        Country::factory()->create([
            'country' => "Namibia, Namibie (la)",
            'id' => "NAM",
        ]);
        Country::factory()->create([
            'country' => "Nauru, Nauru, Naoero",
            'id' => "NRU",
        ]);
        Country::factory()->create([
            'country' => "Nepal, Népal (le), Nepāl",
            'id' => "NPL",
        ]);
        Country::factory()->create([
            'country' => "Netherlands (Kingdom of the), Pays-Bas (Royaume des), Nederland",
            'id' => "NLD",
        ]);
        Country::factory()->create([
            'country' => "New Caledonia, Nouvelle-Calédonie (la)",
            'id' => "NCL",
        ]);
        Country::factory()->create([
            'country' => "New Zealand, Nouvelle-Zélande (la), Aotearoa",
            'id' => "NZL",
        ]);
        Country::factory()->create([
            'country' => "Nicaragua, Nicaragua (le), Nicaragua",
            'id' => "NIC",
        ]);
        Country::factory()->create([
            'country' => "Niger (the), Niger (le)",
            'id' => "NER",
        ]);
        Country::factory()->create([
            'country' => "Nigeria, Nigéria (le)",
            'id' => "NGA",
        ]);
        Country::factory()->create([
            'country' => "Niue, Niue, Niue",
            'id' => "NIU",
        ]);
        Country::factory()->create([
            'country' => "Norfolk Island, Norfolk (l'Île)",
            'id' => "NFK",
        ]);
        Country::factory()->create([
            'country' => "North Macedonia, Macédoine du Nord (la), Severna Makedonija",
            'id' => "MKD",
        ]);
        Country::factory()->create([
            'country' => "Northern Mariana Islands (the), Mariannes du Nord (les Îles)",
            'id' => "MNP",
        ]);
        Country::factory()->create([
            'country' => "Norway, Norvège (la), Noreg, Norge",
            'id' => "NOR",
        ]);
        Country::factory()->create([
            'country' => "‘Umān, Oman, Oman",
            'id' => "OMN",
        ]);
        Country::factory()->create([
            'country' => "Pakistan, Pakistan (le), Pākistān",
            'id' => "PAK",
        ]);
        Country::factory()->create([
            'country' => "Palau, Palaos (les), Belau",
            'id' => "PLW",
        ]);
        Country::factory()->create([
            'country' => "Dawlat Filasţīn, Palestine, State of, Palestine, État de",
            'id' => "PSE",
        ]);
        Country::factory()->create([
            'country' => "Panama, Panama (le), Panamá",
            'id' => "PAN",
        ]);
        Country::factory()->create([
            'country' => "Papua New Guinea, Papouasie-Nouvelle-Guinée (la), Papuaniugini, Papuaniugini",
            'id' => "PNG",
        ]);
        Country::factory()->create([
            'country' => "Paraguay, Paraguay (le), Paraguay, Paraguay (el)",
            'id' => "PRY",
        ]);
        Country::factory()->create([
            'country' => "Perú, Peru, Pérou (le), Perú, Perú (el)",
            'id' => "PER",
        ]);
        Country::factory()->create([
            'country' => "Philippines (the), Philippines (les), Pilipinas",
            'id' => "PHL",
        ]);
        Country::factory()->create([
            'country' => "Pitcairn, Pitcairn",
            'id' => "PCN",
        ]);
        Country::factory()->create([
            'country' => "Poland, Pologne (la), Polska",
            'id' => "POL",
        ]);
        Country::factory()->create([
            'country' => "Portugal, Portugal (le), Portugal",
            'id' => "PRT",
        ]);
        Country::factory()->create([
            'country' => "Puerto Rico, Porto Rico, Puerto Rico",
            'id' => "PRI",
        ]);
        Country::factory()->create([
            'country' => "Qaţar, Qatar, Qatar (le)",
            'id' => "QAT",
        ]);
        Country::factory()->create([
            'country' => "Romania, Roumanie (la), România",
            'id' => "ROU",
        ]);
        Country::factory()->create([
            'country' => "Russian Federation (the), Russie (la Fédération de), Rossijskaja Federacija",
            'id' => "RUS",
        ]);
        Country::factory()->create([
            'country' => "Rwanda, Rwanda (le), Rwanda",
            'id' => "RWA",
        ]);
        Country::factory()->create([
            'country' => "Réunion, Réunion (La)",
            'id' => "REU",
        ]);
        Country::factory()->create([
            'country' => "Saint Barthélemy, Saint-Barthélemy",
            'id' => "BLM",
        ]);
        Country::factory()->create([
            'country' => "Saint Helena, Ascension and Tristan da Cunha, Sainte-Hélène, Ascension et Tristan da Cunha",
            'id' => "SHN",
        ]);
        Country::factory()->create([
            'country' => "Saint Kitts and Nevis, Saint-Kitts-et-Nevis",
            'id' => "KNA",
        ]);
        Country::factory()->create([
            'country' => "Saint Lucia, Sainte-Lucie",
            'id' => "LCA",
        ]);
        Country::factory()->create([
            'country' => "Saint Martin (French part), Saint-Martin (partie française)",
            'id' => "MAF",
        ]);
        Country::factory()->create([
            'country' => "Saint Pierre and Miquelon, Saint-Pierre-et-Miquelon",
            'id' => "SPM",
        ]);
        Country::factory()->create([
            'country' => "Saint Vincent and the Grenadines, Saint-Vincent-et-les Grenadines",
            'id' => "VCT",
        ]);
        Country::factory()->create([
            'country' => "Samoa, Samoa (le), Samoa",
            'id' => "WSM",
        ]);
        Country::factory()->create([
            'country' => "San Marino, Saint-Marin, San Marino",
            'id' => "SMR",
        ]);
        Country::factory()->create([
            'country' => "Sao Tome and Principe, Sao Tomé-et-Principe, São Tomé e Príncipe",
            'id' => "STP",
        ]);
        Country::factory()->create([
            'country' => "As Su‘ūdīyah, Saudi Arabia, Arabie saoudite (l')",
            'id' => "SAU",
        ]);
        Country::factory()->create([
            'country' => "Senegal, Sénégal (le)",
            'id' => "SEN",
        ]);
        Country::factory()->create([
            'country' => "Serbia, Serbie (la), Srbija",
            'id' => "SRB",
        ]);
        Country::factory()->create([
            'country' => "Sesel, Seychelles, Seychelles (les)",
            'id' => "SYC",
        ]);
        Country::factory()->create([
            'country' => "Sierra Leone, Sierra Leone (la)",
            'id' => "SLE",
        ]);
        Country::factory()->create([
            'country' => "Singapore, Singapour, Singapura, Chiṅkappūr, Xinjiapo",
            'id' => "SGP",
        ]);
        Country::factory()->create([
            'country' => "Sint Maarten (Dutch part), Saint-Martin (partie néerlandaise), Sint Maarten",
            'id' => "SXM",
        ]);
        Country::factory()->create([
            'country' => "Slovakia, Slovaquie (la), Slovensko",
            'id' => "SVK",
        ]);
        Country::factory()->create([
            'country' => "Slovenia, Slovénie (la), Slovenija",
            'id' => "SVN",
        ]);
        Country::factory()->create([
            'country' => "Solomon Islands, Salomon (les Îles)",
            'id' => "SLB",
        ]);
        Country::factory()->create([
            'country' => "Aş Şūmāl, Somalia, Somalie (la), Soomaaliya",
            'id' => "SOM",
        ]);
        Country::factory()->create([
            'country' => "Suid-Afrika, South Africa, Afrique du Sud (l'), Sewula Afrika, Afrika-Borwa, Afrika-Borwa, Ningizimu Afrika, Afrika-Borwa, Afrika-Dzonga, Afrika Tshipembe, Mzantsi Afrika, Ningizimu Afrika",
            'id' => "ZAF",
        ]);
        Country::factory()->create([
            'country' => "South Georgia and the South Sandwich Islands, Géorgie du Sud-et-les Îles Sandwich du Sud (la)",
            'id' => "SGS",
        ]);
        Country::factory()->create([
            'country' => "South Sudan, Soudan du Sud (le)",
            'id' => "SSD",
        ]);
        Country::factory()->create([
            'country' => "Spain, Espagne (l'), España",
            'id' => "ESP",
        ]);
        Country::factory()->create([
            'country' => "Sri Lanka, Sri Lanka, Shrī Laṁkā, Ilaṅkai",
            'id' => "LKA",
        ]);
        Country::factory()->create([
            'country' => "As Sūdān, Sudan (the), Soudan (le)",
            'id' => "SDN",
        ]);
        Country::factory()->create([
            'country' => "Suriname, Suriname (le), Suriname",
            'id' => "SUR",
        ]);
        Country::factory()->create([
            'country' => "Svalbard and Jan Mayen, Svalbard et l'Île Jan Mayen (le), Svalbard og Jan Mayen, Svalbard og Jan Mayen",
            'id' => "SJM",
        ]);
        Country::factory()->create([
            'country' => "Sweden, Suède (la), Sverige",
            'id' => "SWE",
        ]);
        Country::factory()->create([
            'country' => "Schweiz (die), Switzerland, Suisse (la), Svizzera (la), Svizra (la)",
            'id' => "CHE",
        ]);
        Country::factory()->create([
            'country' => "Al Jumhūrīyah al ‘Arabīyah as Sūrīyah, Syrian Arab Republic (the), République arabe syrienne (la)",
            'id' => "SYR",
        ]);
        Country::factory()->create([
            'country' => "Taiwan (Province of China), Taïwan (Province de Chine), Taiwan",
            'id' => "TWN",
        ]);
        Country::factory()->create([
            'country' => "Tajikistan, Tadjikistan (le), Tojikiston",
            'id' => "TJK",
        ]);
        Country::factory()->create([
            'country' => "Tanzania, the United Republic of, Tanzanie (la République-Unie de), Jamhuri ya Muungano wa Tanzania",
            'id' => "TZA",
        ]);
        Country::factory()->create([
            'country' => "Thailand, Thaïlande (la), Prathet Thai",
            'id' => "THA",
        ]);
        Country::factory()->create([
            'country' => "Timor-Leste, Timor-Leste (le), Timor-Leste, Timor Lorosa'e",
            'id' => "TLS",
        ]);
        Country::factory()->create([
            'country' => "Togo, Togo (le)",
            'id' => "TGO",
        ]);
        Country::factory()->create([
            'country' => "Tokelau, Tokelau (les), Tokelau",
            'id' => "TKL",
        ]);
        Country::factory()->create([
            'country' => "Tonga, Tonga (les), Tonga",
            'id' => "TON",
        ]);
        Country::factory()->create([
            'country' => "Trinidad and Tobago, Trinité-et-Tobago (la)",
            'id' => "TTO",
        ]);
        Country::factory()->create([
            'country' => "Tūnis, Tunisia, Tunisie (la)",
            'id' => "TUN",
        ]);
        Country::factory()->create([
            'country' => "Turkmenistan, Turkménistan (le), Türkmenistan",
            'id' => "TKM",
        ]);
        Country::factory()->create([
            'country' => "Turks and Caicos Islands (the), Turks-et-Caïcos (les Îles)",
            'id' => "TCA",
        ]);
        Country::factory()->create([
            'country' => "Tuvalu, Tuvalu (les), Tuvalu",
            'id' => "TUV",
        ]);
        Country::factory()->create([
            'country' => "Türkiye, Türkiye (la), Türkiye",
            'id' => "TUR",
        ]);
        Country::factory()->create([
            'country' => "Uganda, Ouganda (l')",
            'id' => "UGA",
        ]);
        Country::factory()->create([
            'country' => "Ukraine, Ukraine (l'), Ukraina",
            'id' => "UKR",
        ]);
        Country::factory()->create([
            'country' => "Al Imārāt, United Arab Emirates (the), Émirats arabes unis (les)",
            'id' => "ARE",
        ]);
        Country::factory()->create([
            'country' => "United Kingdom of Great Britain and Northern Ireland (the), Royaume-Uni de Grande-Bretagne et d'Irlande du Nord (le)",
            'id' => "GBR",
        ]);
        Country::factory()->create([
            'country' => "United States Minor Outlying Islands (the), Îles mineures éloignées des États-Unis (les)",
            'id' => "UMI",
        ]);
        Country::factory()->create([
            'country' => "United States of America (the), États-Unis d'Amérique (les)",
            'id' => "USA",
        ]);
        Country::factory()->create([
            'country' => "Uruguay, Uruguay (l'), Uruguay (el)",
            'id' => "URY",
        ]);
        Country::factory()->create([
            'country' => "Uzbekistan, Ouzbékistan (l'), O‘zbekiston",
            'id' => "UZB",
        ]);
        Country::factory()->create([
            'country' => "Vanuatu, Vanuatu, Vanuatu (le)",
            'id' => "VUT",
        ]);
        Country::factory()->create([
            'country' => "Venezuela (Bolivarian Republic of), Venezuela (République bolivarienne du), Venezuela, República Bolivariana de",
            'id' => "VEN",
        ]);
        Country::factory()->create([
            'country' => "Viet Nam, Viet Nam (le), Việt Nam",
            'id' => "VNM",
        ]);
        Country::factory()->create([
            'country' => "Virgin Islands (British), Vierges britanniques (les Îles)",
            'id' => "VGB",
        ]);
        Country::factory()->create([
            'country' => "Virgin Islands (U.S.), Vierges des États-Unis (les Îles)",
            'id' => "VIR",
        ]);
        Country::factory()->create([
            'country' => "Wallis and Futuna, Wallis-et-Futuna ",
            'id' => "WLF",
        ]);
        Country::factory()->create([
            'country' => "Aş Şaḩrā' al Gharbīyah, Western Sahara*, Sahara occidental (le)*",
            'id' => "ESH",
        ]);
        Country::factory()->create([
            'country' => "Al Yaman, Yemen, Yémen (le)",
            'id' => "YEM",
        ]);
        Country::factory()->create([
            'country' => "Zambia, Zambie (la)",
            'id' => "ZMB",
        ]);
        Country::factory()->create([
            'country' => "Zimbabwe, Zimbabwe (le)",
            'id' => "ZWE",
        ]);
    }
}
