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
        Country::truncate();
        Country::factory()->create([
            'country' =>  "Afghanistan",
            'id' => "AFG",
        ]);
        Country::factory()->create([
            'country' =>  "Albania",
            'id' => "ALB",
        ]);
        Country::factory()->create([
            'country' =>  "Algeria",
            'id' => "DZA",
        ]);
        Country::factory()->create([
            'country' =>  "American Samoa",
            'id' => "ASM",
        ]);
        Country::factory()->create([
            'country' =>  "Andorra",
            'id' => "AND",
        ]);
        Country::factory()->create([
            'country' =>  "Angola",
            'id' => "AGO",
        ]);
        Country::factory()->create([
            'country' =>  "Anguilla",
            'id' => "AIA",
        ]);
        Country::factory()->create([
            'country' =>  "Antarctica",
            'id' => "ATA",
        ]);
        Country::factory()->create([
            'country' =>  "Antigua and Barbuda",
            'id' => "ATG",
        ]);
        Country::factory()->create([
            'country' =>  "Argentina",
            'id' => "ARG",
        ]);
        Country::factory()->create([
            'country' =>  "Armenia",
            'id' => "ARM",
        ]);
        Country::factory()->create([
            'country' =>  "Aruba",
            'id' => "ABW",
        ]);
        Country::factory()->create([
            'country' =>  "Australia",
            'id' => "AUS",
        ]);
        Country::factory()->create([
            'country' =>  "Austria",
            'id' => "AUT",
        ]);
        Country::factory()->create([
            'country' =>  "Azerbaijan",
            'id' => "AZE",
        ]);
        Country::factory()->create([
            'country' =>  "Bahamas (The)",
            'id' => "BHS",
        ]);
        Country::factory()->create([
            'country' =>  "Bahrain",
            'id' => "BHR",
        ]);
        Country::factory()->create([
            'country' =>  "Bangladesh",
            'id' => "BGD",
        ]);
        Country::factory()->create([
            'country' =>  "Barbados",
            'id' => "BRB",
        ]);
        Country::factory()->create([
            'country' =>  "Belarus",
            'id' => "BLR",
        ]);
        Country::factory()->create([
            'country' =>  "Belgium",
            'id' => "BEL",
        ]);
        Country::factory()->create([
            'country' =>  "Belize",
            'id' => "BLZ",
        ]);
        Country::factory()->create([
            'country' =>  "Benin",
            'id' => "BEN",
        ]);
        Country::factory()->create([
            'country' =>  "Bermuda",
            'id' => "BMU",
        ]);
        Country::factory()->create([
            'country' =>  "Åland Islands",
            'id' => "ALA",
        ]);
        Country::factory()->create([
            'country' =>  "Bhutan",
            'id' => "BTN",
        ]);
        Country::factory()->create([
            'country' =>  "Bolivia (Plurinational State of)",
            'id' => "BOL",
        ]);
        Country::factory()->create([
            'country' =>  "Bonaire, Sint Eustatius and Saba",
            'id' => "BES",
        ]);
        Country::factory()->create([
            'country' =>  "Bosnia and Herzegovina",
            'id' => "BIH",
        ]);
        Country::factory()->create([
            'country' =>  "Botswana",
            'id' => "BWA",
        ]);
        Country::factory()->create([
            'country' =>  "Bouvet Island",
            'id' => "BVT",
        ]);
        Country::factory()->create([
            'country' =>  "Brazil",
            'id' => "BRA",
        ]);
        Country::factory()->create([
            'country' =>  "British Indian Ocean Territory (the)",
            'id' => "IOT",
        ]);
        Country::factory()->create([
            'country' =>  "Brunei Darussalam",
            'id' => "BRN",
        ]);
        Country::factory()->create([
            'country' =>  "Bulgaria",
            'id' => "BGR",
        ]);
        Country::factory()->create([
            'country' =>  "Burkina Faso",
            'id' => "BFA",
        ]);
        Country::factory()->create([
            'country' =>  "Burundi",
            'id' => "BDI",
        ]);
        Country::factory()->create([
            'country' =>  "Cabo Verde",
            'id' => "CPV",
        ]);
        Country::factory()->create([
            'country' =>  "Cambodia",
            'id' => "KHM",
        ]);
        Country::factory()->create([
            'country' =>  "Cameroon",
            'id' => "CMR",
        ]);
        Country::factory()->create([
            'country' =>  "Canada",
            'id' => "CAN",
        ]);
        Country::factory()->create([
            'country' =>  "Cayman Islands (the)",
            'id' => "CYM",
        ]);
        Country::factory()->create([
            'country' =>  "Central African Republic (the)",
            'id' => "CAF",
        ]);
        Country::factory()->create([
            'country' =>  "Chad",
            'id' => "TCD",
        ]);
        Country::factory()->create([
            'country' =>  "Chile",
            'id' => "CHL",
        ]);
        Country::factory()->create([
            'country' =>  "China",
            'id' => "CHN",
        ]);
        Country::factory()->create([
            'country' =>  "Christmas Island",
            'id' => "CXR",
        ]);
        Country::factory()->create([
            'country' =>  "Cocos (Keeling) Islands (the)",
            'id' => "CCK",
        ]);
        Country::factory()->create([
            'country' =>  "Colombia",
            'id' => "COL",
        ]);
        Country::factory()->create([
            'country' =>  "Comoros (the)",
            'id' => "COM",
        ]);
        Country::factory()->create([
            'country' =>  "Congo (the Democratic Republic of the)",
            'id' => "COD",
        ]);
        Country::factory()->create([
            'country' =>  "Congo (the)",
            'id' => "COG",
        ]);
        Country::factory()->create([
            'country' =>  "Cook Islands (the)",
            'id' => "COK",
        ]);
        Country::factory()->create([
            'country' =>  "Costa Rica",
            'id' => "CRI",
        ]);
        Country::factory()->create([
            'country' =>  "Croatia",
            'id' => "HRV",
        ]);
        Country::factory()->create([
            'country' =>  "Cuba",
            'id' => "CUB",
        ]);
        Country::factory()->create([
            'country' =>  "Curaçao",
            'id' => "CUW",
        ]);
        Country::factory()->create([
            'country' =>  "Cyprus",
            'id' => "CYP",
        ]);
        Country::factory()->create([
            'country' =>  "Czechia",
            'id' => "CZE",
        ]);
        Country::factory()->create([
            'country' =>  "Côte d'Ivoire",
            'id' => "CIV",
        ]);
        Country::factory()->create([
            'country' =>  "Denmark",
            'id' => "DNK",
        ]);
        Country::factory()->create([
            'country' =>  "Djibouti",
            'id' => "DJI",
        ]);
        Country::factory()->create([
            'country' =>  "Dominica",
            'id' => "DMA",
        ]);
        Country::factory()->create([
            'country' =>  "Dominican Republic (the)",
            'id' => "DOM",
        ]);
        Country::factory()->create([
            'country' =>  "Ecuador",
            'id' => "ECU",
        ]);
        Country::factory()->create([
            'country' =>  "Egypt",
            'id' => "EGY",
        ]);
        Country::factory()->create([
            'country' =>  "El Salvador",
            'id' => "SLV",
        ]);
        Country::factory()->create([
            'country' =>  "Equatorial Guinea",
            'id' => "GNQ",
        ]);
        Country::factory()->create([
            'country' =>  "Eritrea",
            'id' => "ERI",
        ]);
        Country::factory()->create([
            'country' =>  "Estonia",
            'id' => "EST",
        ]);
        Country::factory()->create([
            'country' =>  "Eswatini",
            'id' => "SWZ",
        ]);
        Country::factory()->create([
            'country' =>  "Ethiopia",
            'id' => "ETH",
        ]);
        Country::factory()->create([
            'country' =>  "Falkland Islands (the) [Malvinas]",
            'id' => "FLK",
        ]);
        Country::factory()->create([
            'country' =>  "Faroe Islands (the)",
            'id' => "FRO",
        ]);
        Country::factory()->create([
            'country' =>  "Fiji",
            'id' => "FJI",
        ]);
        Country::factory()->create([
            'country' =>  "Finland",
            'id' => "FIN",
        ]);
        Country::factory()->create([
            'country' =>  "France",
            'id' => "FRA",
        ]);
        Country::factory()->create([
            'country' =>  "French Guiana",
            'id' => "GUF",
        ]);
        Country::factory()->create([
            'country' =>  "French Polynesia",
            'id' => "PYF",
        ]);
        Country::factory()->create([
            'country' =>  "French Southern Territories (the)",
            'id' => "ATF",
        ]);
        Country::factory()->create([
            'country' =>  "Gabon",
            'id' => "GAB",
        ]);
        Country::factory()->create([
            'country' =>  "Gambia (the)",
            'id' => "GMB",
        ]);
        Country::factory()->create([
            'country' =>  "Georgia",
            'id' => "GEO",
        ]);
        Country::factory()->create([
            'country' =>  "Germany",
            'id' => "DEU",
        ]);
        Country::factory()->create([
            'country' =>  "Ghana",
            'id' => "GHA",
        ]);
        Country::factory()->create([
            'country' =>  "Gibraltar",
            'id' => "GIB",
        ]);
        Country::factory()->create([
            'country' =>  "Greece",
            'id' => "GRC",
        ]);
        Country::factory()->create([
            'country' =>  "Greenland",
            'id' => "GRL",
        ]);
        Country::factory()->create([
            'country' =>  "Grenada",
            'id' => "GRD",
        ]);
        Country::factory()->create([
            'country' =>  "Guadeloupe",
            'id' => "GLP",
        ]);
        Country::factory()->create([
            'country' =>  "Guam",
            'id' => "GUM",
        ]);
        Country::factory()->create([
            'country' =>  "Guatemala",
            'id' => "GTM",
        ]);
        Country::factory()->create([
            'country' =>  "Guernsey",
            'id' => "GGY",
        ]);
        Country::factory()->create([
            'country' =>  "Guinea",
            'id' => "GIN",
        ]);
        Country::factory()->create([
            'country' =>  "Guinea-Bissau",
            'id' => "GNB",
        ]);
        Country::factory()->create([
            'country' =>  "Guyana",
            'id' => "GUY",
        ]);
        Country::factory()->create([
            'country' =>  "Haiti",
            'id' => "HTI",
        ]);
        Country::factory()->create([
            'country' =>  "Heard Island and McDonald Islands",
            'id' => "HMD",
        ]);
        Country::factory()->create([
            'country' =>  "Holy See (the)",
            'id' => "VAT",
        ]);
        Country::factory()->create([
            'country' =>  "Honduras",
            'id' => "HND",
        ]);
        Country::factory()->create([
            'country' =>  "Hong Kong",
            'id' => "HKG",
        ]);
        Country::factory()->create([
            'country' =>  "Hungary",
            'id' => "HUN",
        ]);
        Country::factory()->create([
            'country' =>  "Iceland",
            'id' => "ISL",
        ]);
        Country::factory()->create([
            'country' =>  "India",
            'id' => "IND",
        ]);
        Country::factory()->create([
            'country' =>  "Indonesia",
            'id' => "IDN",
        ]);
        Country::factory()->create([
            'country' =>  "Iran (Islamic Republic of)",
            'id' => "IRN",
        ]);
        Country::factory()->create([
            'country' =>  "Iraq",
            'id' => "IRQ",
        ]);
        Country::factory()->create([
            'country' =>  "Ireland",
            'id' => "IRL",
        ]);
        Country::factory()->create([
            'country' =>  "Isle of Man",
            'id' => "IMN",
        ]);
        Country::factory()->create([
            'country' =>  "Israel",
            'id' => "ISR",
        ]);
        Country::factory()->create([
            'country' =>  "Italy",
            'id' => "ITA",
        ]);
        Country::factory()->create([
            'country' =>  "Jamaica",
            'id' => "JAM",
        ]);
        Country::factory()->create([
            'country' =>  "Japan",
            'id' => "JPN",
        ]);
        Country::factory()->create([
            'country' =>  "Jersey",
            'id' => "JEY",
        ]);
        Country::factory()->create([
            'country' =>  "Jordan",
            'id' => "JOR",
        ]);
        Country::factory()->create([
            'country' =>  "Kazakhstan",
            'id' => "KAZ",
        ]);
        Country::factory()->create([
            'country' =>  "Kenya",
            'id' => "KEN",
        ]);
        Country::factory()->create([
            'country' =>  "Kiribati",
            'id' => "KIR",
        ]);
        Country::factory()->create([
            'country' =>  "Korea (the Democratic People's Republic of)",
            'id' => "PRK",
        ]);
        Country::factory()->create([
            'country' =>  "Korea (the Republic of)",
            'id' => "KOR",
        ]);
        Country::factory()->create([
            'country' =>  "Kuwait",
            'id' => "KWT",
        ]);
        Country::factory()->create([
            'country' =>  "Kyrgyzstan",
            'id' => "KGZ",
        ]);
        Country::factory()->create([
            'country' =>  "Lao People's Democratic Republic (the)",
            'id' => "LAO",
        ]);
        Country::factory()->create([
            'country' =>  "Latvia",
            'id' => "LVA",
        ]);
        Country::factory()->create([
            'country' =>  "Lebanon",
            'id' => "LBN",
        ]);
        Country::factory()->create([
            'country' =>  "Lesotho",
            'id' => "LSO",
        ]);
        Country::factory()->create([
            'country' =>  "Liberia",
            'id' => "LBR",
        ]);
        Country::factory()->create([
            'country' =>  "Libya",
            'id' => "LBY",
        ]);
        Country::factory()->create([
            'country' =>  "Liechtenstein",
            'id' => "LIE",
        ]);
        Country::factory()->create([
            'country' =>  "Lithuania",
            'id' => "LTU",
        ]);
        Country::factory()->create([
            'country' =>  "Luxembourg",
            'id' => "LUX",
        ]);
        Country::factory()->create([
            'country' =>  "Macao",
            'id' => "MAC",
        ]);
        Country::factory()->create([
            'country' =>  "Madagascar",
            'id' => "MDG",
        ]);
        Country::factory()->create([
            'country' =>  "Malawi",
            'id' => "MWI",
        ]);
        Country::factory()->create([
            'country' =>  "Malaysia",
            'id' => "MYS",
        ]);
        Country::factory()->create([
            'country' =>  "Maldives",
            'id' => "MDV",
        ]);
        Country::factory()->create([
            'country' =>  "Mali",
            'id' => "MLI",
        ]);
        Country::factory()->create([
            'country' =>  "Malta",
            'id' => "MLT",
        ]);
        Country::factory()->create([
            'country' =>  "Marshall Islands (the)",
            'id' => "MHL",
        ]);
        Country::factory()->create([
            'country' =>  "Martinique",
            'id' => "MTQ",
        ]);
        Country::factory()->create([
            'country' =>  "Mauritania",
            'id' => "MRT",
        ]);
        Country::factory()->create([
            'country' =>  "Mauritius",
            'id' => "MUS",
        ]);
        Country::factory()->create([
            'country' =>  "Mayotte",
            'id' => "MYT",
        ]);
        Country::factory()->create([
            'country' =>  "Mexico",
            'id' => "MEX",
        ]);
        Country::factory()->create([
            'country' =>  "Micronesia (Federated States of)",
            'id' => "FSM",
        ]);
        Country::factory()->create([
            'country' =>  "Moldova (the Republic of)",
            'id' => "MDA",
        ]);
        Country::factory()->create([
            'country' =>  "Monaco",
            'id' => "MCO",
        ]);
        Country::factory()->create([
            'country' =>  "Mongolia",
            'id' => "MNG",
        ]);
        Country::factory()->create([
            'country' =>  "Montenegro",
            'id' => "MNE",
        ]);
        Country::factory()->create([
            'country' =>  "Montserrat",
            'id' => "MSR",
        ]);
        Country::factory()->create([
            'country' =>  "Morocco",
            'id' => "MAR",
        ]);
        Country::factory()->create([
            'country' =>  "Mozambique",
            'id' => "MOZ",
        ]);
        Country::factory()->create([
            'country' =>  "Myanmar",
            'id' => "MMR",
        ]);
        Country::factory()->create([
            'country' =>  "Namibia",
            'id' => "NAM",
        ]);
        Country::factory()->create([
            'country' =>  "Nauru",
            'id' => "NRU",
        ]);
        Country::factory()->create([
            'country' =>  "Nepal",
            'id' => "NPL",
        ]);
        Country::factory()->create([
            'country' =>  "Netherlands (Kingdom of the)",
            'id' => "NLD",
        ]);
        Country::factory()->create([
            'country' =>  "New Caledonia",
            'id' => "NCL",
        ]);
        Country::factory()->create([
            'country' =>  "New Zealand",
            'id' => "NZL",
        ]);
        Country::factory()->create([
            'country' =>  "Nicaragua",
            'id' => "NIC",
        ]);
        Country::factory()->create([
            'country' =>  "Niger (the)",
            'id' => "NER",
        ]);
        Country::factory()->create([
            'country' =>  "Nigeria",
            'id' => "NGA",
        ]);
        Country::factory()->create([
            'country' =>  "Niue",
            'id' => "NIU",
        ]);
        Country::factory()->create([
            'country' =>  "Norfolk Island",
            'id' => "NFK",
        ]);
        Country::factory()->create([
            'country' =>  "North Macedonia",
            'id' => "MKD",
        ]);
        Country::factory()->create([
            'country' =>  "Northern Mariana Islands (the)",
            'id' => "MNP",
        ]);
        Country::factory()->create([
            'country' =>  "Norway",
            'id' => "NOR",
        ]);
        Country::factory()->create([
            'country' =>  "Oman",
            'id' => "OMN",
        ]);
        Country::factory()->create([
            'country' =>  "Pakistan",
            'id' => "PAK",
        ]);
        Country::factory()->create([
            'country' =>  "Palau",
            'id' => "PLW",
        ]);
        Country::factory()->create([
            'country' =>  "Palestine, State of",
            'id' => "PSE",
        ]);
        Country::factory()->create([
            'country' =>  "Panama",
            'id' => "PAN",
        ]);
        Country::factory()->create([
            'country' =>  "Papua New Guinea",
            'id' => "PNG",
        ]);
        Country::factory()->create([
            'country' =>  "Paraguay",
            'id' => "PRY",
        ]);
        Country::factory()->create([
            'country' =>  "Peru",
            'id' => "PER",
        ]);
        Country::factory()->create([
            'country' =>  "Philippines (the)",
            'id' => "PHL",
        ]);
        Country::factory()->create([
            'country' =>  "Pitcairn",
            'id' => "PCN",
        ]);
        Country::factory()->create([
            'country' =>  "Poland",
            'id' => "POL",
        ]);
        Country::factory()->create([
            'country' =>  "Portugal",
            'id' => "PRT",
        ]);
        Country::factory()->create([
            'country' =>  "Puerto Rico",
            'id' => "PRI",
        ]);
        Country::factory()->create([
            'country' =>  "Qatar",
            'id' => "QAT",
        ]);
        Country::factory()->create([
            'country' =>  "Romania",
            'id' => "ROU",
        ]);
        Country::factory()->create([
            'country' =>  "Russian Federation (the)",
            'id' => "RUS",
        ]);
        Country::factory()->create([
            'country' =>  "Rwanda",
            'id' => "RWA",
        ]);
        Country::factory()->create([
            'country' =>  "Réunion",
            'id' => "REU",
        ]);
        Country::factory()->create([
            'country' =>  "Saint Barthélemy",
            'id' => "BLM",
        ]);
        Country::factory()->create([
            'country' =>  "Saint Helena, Ascension and Tristan da Cunha",
            'id' => "SHN",
        ]);
        Country::factory()->create([
            'country' =>  "Saint Kitts and Nevis",
            'id' => "KNA",
        ]);
        Country::factory()->create([
            'country' =>  "Saint Lucia",
            'id' => "LCA",
        ]);
        Country::factory()->create([
            'country' =>  "Saint Martin (French part)",
            'id' => "MAF",
        ]);
        Country::factory()->create([
            'country' =>  "Saint Pierre and Miquelon",
            'id' => "SPM",
        ]);
        Country::factory()->create([
            'country' =>  "Saint Vincent and the Grenadines",
            'id' => "VCT",
        ]);
        Country::factory()->create([
            'country' =>  "Samoa",
            'id' => "WSM",
        ]);
        Country::factory()->create([
            'country' =>  "San Marino",
            'id' => "SMR",
        ]);
        Country::factory()->create([
            'country' =>  "Sao Tome and Principe",
            'id' => "STP",
        ]);
        Country::factory()->create([
            'country' =>  "Saudi Arabia",
            'id' => "SAU",
        ]);
        Country::factory()->create([
            'country' =>  "Senegal",
            'id' => "SEN",
        ]);
        Country::factory()->create([
            'country' =>  "Serbia",
            'id' => "SRB",
        ]);
        Country::factory()->create([
            'country' =>  "Seychelles",
            'id' => "SYC",
        ]);
        Country::factory()->create([
            'country' =>  "Sierra Leone",
            'id' => "SLE",
        ]);
        Country::factory()->create([
            'country' =>  "Singapore",
            'id' => "SGP",
        ]);
        Country::factory()->create([
            'country' =>  "Sint Maarten (Dutch part)",
            'id' => "SXM",
        ]);
        Country::factory()->create([
            'country' =>  "Slovakia",
            'id' => "SVK",
        ]);
        Country::factory()->create([
            'country' =>  "Slovenia",
            'id' => "SVN",
        ]);
        Country::factory()->create([
            'country' =>  "Solomon Islands",
            'id' => "SLB",
        ]);
        Country::factory()->create([
            'country' =>  "Somalia",
            'id' => "SOM",
        ]);
        Country::factory()->create([
            'country' =>  "South Africa",
            'id' => "ZAF",
        ]);
        Country::factory()->create([
            'country' =>  "South Georgia and the South Sandwich Islands",
            'id' => "SGS",
        ]);
        Country::factory()->create([
            'country' =>  "South Sudan",
            'id' => "SSD",
        ]);
        Country::factory()->create([
            'country' =>  "Spain",
            'id' => "ESP",
        ]);
        Country::factory()->create([
            'country' =>  "Sri Lanka",
            'id' => "LKA",
        ]);
        Country::factory()->create([
            'country' =>  "Sudan (the)",
            'id' => "SDN",
        ]);
        Country::factory()->create([
            'country' =>  "Suriname",
            'id' => "SUR",
        ]);
        Country::factory()->create([
            'country' =>  "Svalbard and Jan Mayen",
            'id' => "SJM",
        ]);
        Country::factory()->create([
            'country' =>  "Sweden",
            'id' => "SWE",
        ]);
        Country::factory()->create([
            'country' =>  "Switzerland",
            'id' => "CHE",
        ]);
        Country::factory()->create([
            'country' =>  "Syrian Arab Republic (the)",
            'id' => "SYR",
        ]);
        Country::factory()->create([
            'country' =>  "Taiwan (Province of China)",
            'id' => "TWN",
        ]);
        Country::factory()->create([
            'country' =>  "Tajikistan",
            'id' => "TJK",
        ]);
        Country::factory()->create([
            'country' =>  "Tanzania, the United Republic of",
            'id' => "TZA",
        ]);
        Country::factory()->create([
            'country' =>  "Thailand",
            'id' => "THA",
        ]);
        Country::factory()->create([
            'country' =>  "Timor-Leste",
            'id' => "TLS",
        ]);
        Country::factory()->create([
            'country' =>  "Togo",
            'id' => "TGO",
        ]);
        Country::factory()->create([
            'country' =>  "Tokelau",
            'id' => "TKL",
        ]);
        Country::factory()->create([
            'country' =>  "Tonga",
            'id' => "TON",
        ]);
        Country::factory()->create([
            'country' =>  "Trinidad and Tobago",
            'id' => "TTO",
        ]);
        Country::factory()->create([
            'country' =>  "Tunisia",
            'id' => "TUN",
        ]);
        Country::factory()->create([
            'country' =>  "Turkmenistan",
            'id' => "TKM",
        ]);
        Country::factory()->create([
            'country' =>  "Turks and Caicos Islands (the)",
            'id' => "TCA",
        ]);
        Country::factory()->create([
            'country' =>  "Tuvalu",
            'id' => "TUV",
        ]);
        Country::factory()->create([
            'country' =>  "Türkiye",
            'id' => "TUR",
        ]);
        Country::factory()->create([
            'country' =>  "Uganda",
            'id' => "UGA",
        ]);
        Country::factory()->create([
            'country' =>  "Ukraine",
            'id' => "UKR",
        ]);
        Country::factory()->create([
            'country' =>  "United Arab Emirates (the)",
            'id' => "ARE",
        ]);
        Country::factory()->create([
            'country' =>  "United Kingdom of Great Britain and Northern Ireland (the)",
            'id' => "GBR",
        ]);
        Country::factory()->create([
            'country' =>  "United States Minor Outlying Islands (the)",
            'id' => "UMI",
        ]);
        Country::factory()->create([
            'country' =>  "United States of America (the)",
            'id' => "USA",
        ]);
        Country::factory()->create([
            'country' =>  "Uruguay",
            'id' => "URY",
        ]);
        Country::factory()->create([
            'country' =>  "Uzbekistan",
            'id' => "UZB",
        ]);
        Country::factory()->create([
            'country' =>  "Vanuatu",
            'id' => "VUT",
        ]);
        Country::factory()->create([
            'country' =>  "Venezuela (Bolivarian Republic of)",
            'id' => "VEN",
        ]);
        Country::factory()->create([
            'country' =>  "Viet Nam",
            'id' => "VNM",
        ]);
        Country::factory()->create([
            'country' =>  "Virgin Islands (British)",
            'id' => "VGB",
        ]);
        Country::factory()->create([
            'country' =>  "Virgin Islands (U.S.)",
            'id' => "VIR",
        ]);
        Country::factory()->create([
            'country' =>  "Wallis and Futuna",
            'id' => "WLF",
        ]);
        Country::factory()->create([
            'country' =>  "Western Sahara*",
            'id' => "ESH",
        ]);
        Country::factory()->create([
            'country' =>  "Yemen",
            'id' => "YEM",
        ]);
        Country::factory()->create([
            'country' =>  "Zambia",
            'id' => "ZMB",
        ]);
        Country::factory()->create([
            'country' =>  "Zimbabwe",
            'id' => "ZWE",
        ]);
    }
}
