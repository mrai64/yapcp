<?php

/**
 * auxiliary table
 * - for user_contacts
 * - for federations
 * - for organizations
 * - for contests
 */

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::truncate();

        Country::factory()->create([
            'id' => 'AFG',
            'country' => 'Afghanistan',
            'flag_code' => '🇦🇫',
        ]);

        Country::factory()->create([
            'id' => 'ALA',
            'country' => 'Åland Islands',
            'flag_code' => '🇦🇽',
        ]);

        Country::factory()->create([
            'id' => 'ALB',
            'country' => 'Albania',
            'flag_code' => '🇦🇱',
        ]);

        Country::factory()->create([
            'id' => 'DZA',
            'country' => 'Algeria',
            'flag_code' => '🇩🇿',
        ]);

        Country::factory()->create([
            'id' => 'ASM',
            'country' => 'American Samoa',
            'flag_code' => '🇼🇸',
        ]);

        Country::factory()->create([
            'id' => 'AND',
            'country' => 'Andorra',
            'flag_code' => '🇦🇩',
        ]);

        Country::factory()->create([
            'id' => 'AGO',
            'country' => 'Angola',
            'flag_code' => '🇦🇴',
        ]);

        Country::factory()->create([
            'id' => 'AIA',
            'country' => 'Anguilla',
            'flag_code' => '🇦🇮',
        ]);

        Country::factory()->create([
            'id' => 'ATA',
            'country' => 'Antarctica',
            'flag_code' => '🇦🇶',
        ]);

        Country::factory()->create([
            'id' => 'ATG',
            'country' => 'Antigua and Barbuda',
            'flag_code' => '🇦🇬',
        ]);

        Country::factory()->create([
            'id' => 'ARG',
            'country' => 'Argentina',
            'flag_code' => '🇦🇷',
        ]);

        Country::factory()->create([
            'id' => 'ARM',
            'country' => 'Armenia',
            'flag_code' => '🇦🇲',
        ]);

        Country::factory()->create([
            'id' => 'ABW',
            'country' => 'Aruba',
            'flag_code' => '🇦🇼',
        ]);

        Country::factory()->create([
            'id' => 'AUS',
            'country' => 'Australia',
            'flag_code' => '🇦🇺',
        ]);

        Country::factory()->create([
            'id' => 'AUT',
            'country' => 'Austria',
            'flag_code' => '🇦🇹',
        ]);

        Country::factory()->create([
            'id' => 'AZE',
            'country' => 'Azerbaijan',
            'flag_code' => '🇦🇿',
        ]);

        Country::factory()->create([
            'id' => 'BHS',
            'country' => 'Bahamas (The)',
            'flag_code' => '🇧🇸',
        ]);

        Country::factory()->create([
            'id' => 'BHR',
            'country' => 'Bahrain',
            'flag_code' => '🇧🇸',
        ]);

        Country::factory()->create([
            'id' => 'BGD',
            'country' => 'Bangladesh',
            'flag_code' => '🇧🇩',
        ]);

        Country::factory()->create([
            'id' => 'BRB',
            'country' => 'Barbados',
            'flag_code' => '🇧🇧',
        ]);

        Country::factory()->create([
            'id' => 'BLR',
            'country' => 'Belarus',
            'flag_code' => '🇧🇾',
        ]);

        Country::factory()->create([
            'id' => 'BEL',
            'country' => 'Belgium',
            'flag_code' => '🇧🇪',
        ]);

        Country::factory()->create([
            'id' => 'BLZ',
            'country' => 'Belize',
            'flag_code' => '🇧🇿',
        ]);

        Country::factory()->create([
            'id' => 'BEN',
            'country' => 'Benin',
            'flag_code' => '🇧🇯',
        ]);

        Country::factory()->create([
            'id' => 'BMU',
            'country' => 'Bermuda',
            'flag_code' => '🇧🇲',
        ]);

        Country::factory()->create([
            'id' => 'BTN',
            'country' => 'Bhutan',
            'flag_code' => '🇧🇹',
        ]);

        Country::factory()->create([
            'id' => 'BOL',
            'country' => 'Bolivia (Plurinational State of)',
            'flag_code' => '🇧🇴',
        ]);

        Country::factory()->create([
            'id' => 'BES',
            'country' => 'Bonaire, Sint Eustatius and Saba',
            'flag_code' => '🇧🇶',
        ]);

        Country::factory()->create([
            'id' => 'BIH',
            'country' => 'Bosnia and Herzegovina',
            'flag_code' => '🇧🇦',
        ]);

        Country::factory()->create([
            'id' => 'BWA',
            'country' => 'Botswana',
            'flag_code' => '🇧🇼',
        ]);

        Country::factory()->create([
            'id' => 'BVT',
            'country' => 'Bouvet Island',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'BRA',
            'country' => 'Brazil',
            'flag_code' => '🇧🇷',
        ]);

        Country::factory()->create([
            'id' => 'IOT',
            'country' => 'British Indian Ocean Territory (the)',
            'flag_code' => '🇮🇴',
        ]);

        Country::factory()->create([
            'id' => 'BRN',
            'country' => 'Brunei Darussalam',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'BGR',
            'country' => 'Bulgaria',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'BFA',
            'country' => 'Burkina Faso',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'BDI',
            'country' => 'Burundi',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CPV',
            'country' => 'Cabo Verde',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'KHM',
            'country' => 'Cambodia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CMR',
            'country' => 'Cameroon',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CAN',
            'country' => 'Canada',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CYM',
            'country' => 'Cayman Islands (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CAF',
            'country' => 'Central African Republic (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TCD',
            'country' => 'Chad',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CHL',
            'country' => 'Chile',
            'flag_code' => '🇨🇱',
        ]);

        Country::factory()->create([
            'id' => 'CHN',
            'country' => 'China',
            'flag_code' => '🇨🇳',
        ]);

        Country::factory()->create([
            'id' => 'CXR',
            'country' => 'Christmas Island',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CCK',
            'country' => 'Cocos (Keeling) Islands (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'COL',
            'country' => 'Colombia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'COM',
            'country' => 'Comoros (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'COD',
            'country' => 'Congo (the Democratic Republic of the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'COG',
            'country' => 'Congo (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'COK',
            'country' => 'Cook Islands (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CRI',
            'country' => 'Costa Rica',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CIV',
            'country' => 'Côte d\'Ivoire',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'HRV',
            'country' => 'Croatia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CUB',
            'country' => 'Cuba',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CUW',
            'country' => 'Curaçao',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CYP',
            'country' => 'Cyprus',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CZE',
            'country' => 'Czechia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'DNK',
            'country' => 'Denmark',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'DJI',
            'country' => 'Djibouti',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'DMA',
            'country' => 'Dominica',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'DOM',
            'country' => 'Dominican Republic (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'ECU',
            'country' => 'Ecuador',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'EGY',
            'country' => 'Egypt',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SLV',
            'country' => 'El Salvador',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GNQ',
            'country' => 'Equatorial Guinea',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'ERI',
            'country' => 'Eritrea',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'EST',
            'country' => 'Estonia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SWZ',
            'country' => 'Eswatini',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'ETH',
            'country' => 'Ethiopia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'FLK',
            'country' => 'Falkland Islands (the) [Malvinas]',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'FRO',
            'country' => 'Faroe Islands (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'FJI',
            'country' => 'Fiji',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'FIN',
            'country' => 'Finland',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'FRA',
            'country' => 'France',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GUF',
            'country' => 'French Guiana',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'PYF',
            'country' => 'French Polynesia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'ATF',
            'country' => 'French Southern Territories (the)',
            'flag_code' => '🇹🇫',
        ]);

        Country::factory()->create([
            'id' => 'GAB',
            'country' => 'Gabon',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GMB',
            'country' => 'Gambia (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GEO',
            'country' => 'Georgia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'DEU',
            'country' => 'Germany',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GHA',
            'country' => 'Ghana',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GIB',
            'country' => 'Gibraltar',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GRC',
            'country' => 'Greece',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GRL',
            'country' => 'Greenland',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GRD',
            'country' => 'Grenada',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GLP',
            'country' => 'Guadeloupe',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GUM',
            'country' => 'Guam',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GTM',
            'country' => 'Guatemala',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GGY',
            'country' => 'Guernsey',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GIN',
            'country' => 'Guinea',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GNB',
            'country' => 'Guinea-Bissau',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'GUY',
            'country' => 'Guyana',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'HTI',
            'country' => 'Haiti',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'HMD',
            'country' => 'Heard Island and McDonald Islands',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'VAT',
            'country' => 'Holy See (the)',
            'flag_code' => '🇻🇦',
        ]);

        Country::factory()->create([
            'id' => 'HND',
            'country' => 'Honduras',
            'flag_code' => '🇭🇳',
        ]);

        Country::factory()->create([
            'id' => 'HKG',
            'country' => 'Hong Kong',
            'flag_code' => '🇭🇰',
        ]);

        Country::factory()->create([
            'id' => 'HUN',
            'country' => 'Hungary',
            'flag_code' => '🇭🇺',
        ]);

        Country::factory()->create([
            'id' => 'ISL',
            'country' => 'Iceland',
            'flag_code' => '🇮🇸',
        ]);

        Country::factory()->create([
            'id' => 'IND',
            'country' => 'India',
            'flag_code' => '🇮🇳',
        ]);

        Country::factory()->create([
            'id' => 'IDN',
            'country' => 'Indonesia',
            'flag_code' => '🇮🇩',
        ]);

        Country::factory()->create([
            'id' => 'IRN',
            'country' => 'Iran (Islamic Republic of)',
            'flag_code' => '🇮🇷',
        ]);

        Country::factory()->create([
            'id' => 'IRQ',
            'country' => 'Iraq',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'IRL',
            'country' => 'Ireland',
            'flag_code' => '🇮🇪',
        ]);

        Country::factory()->create([
            'id' => 'IMN',
            'country' => 'Isle of Man',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'ISR',
            'country' => 'Israel',
            'flag_code' => '🇮🇱',
        ]);

        Country::factory()->create([
            'id' => 'ITA',
            'country' => 'Italy',
            'flag_code' => '🇮🇹',
        ]);

        Country::factory()->create([
            'id' => 'JAM',
            'country' => 'Jamaica',
            'flag_code' => '🇯🇲',
        ]);

        Country::factory()->create([
            'id' => 'JPN',
            'country' => 'Japan',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'JEY',
            'country' => 'Jersey',
            'flag_code' => '🇯🇪',
        ]);

        Country::factory()->create([
            'id' => 'JOR',
            'country' => 'Jordan',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'KAZ',
            'country' => 'Kazakhstan',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'KEN',
            'country' => 'Kenya',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'KIR',
            'country' => 'Kiribati',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'PRK',
            'country' => 'Korea (the Democratic People\'s Republic of)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'KOR',
            'country' => 'Korea (the Republic of)',
            'flag_code' => '🇰🇷',
        ]);

        Country::factory()->create([
            'id' => 'KWT',
            'country' => 'Kuwait',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'KGZ',
            'country' => 'Kyrgyzstan',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'LAO',
            'country' => 'Lao People\'s Democratic Republic (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'LVA',
            'country' => 'Latvia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'LBN',
            'country' => 'Lebanon',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'LSO',
            'country' => 'Lesotho',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'LBR',
            'country' => 'Liberia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'LBY',
            'country' => 'Libya',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'LIE',
            'country' => 'Liechtenstein',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'LTU',
            'country' => 'Lithuania',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'LUX',
            'country' => 'Luxembourg',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MAC',
            'country' => 'Macao',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MDG',
            'country' => 'Madagascar',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MWI',
            'country' => 'Malawi',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MYS',
            'country' => 'Malaysia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MDV',
            'country' => 'Maldives',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MLI',
            'country' => 'Mali',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MLT',
            'country' => 'Malta',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MHL',
            'country' => 'Marshall Islands (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MTQ',
            'country' => 'Martinique',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MRT',
            'country' => 'Mauritania',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MUS',
            'country' => 'Mauritius',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MYT',
            'country' => 'Mayotte',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MEX',
            'country' => 'Mexico',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'FSM',
            'country' => 'Micronesia (Federated States of)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MDA',
            'country' => 'Moldova (the Republic of)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MCO',
            'country' => 'Monaco',
            'flag_code' => '🇲🇨',
        ]);

        Country::factory()->create([
            'id' => 'MNG',
            'country' => 'Mongolia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MNE',
            'country' => 'Montenegro',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MSR',
            'country' => 'Montserrat',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MAR',
            'country' => 'Morocco',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MOZ',
            'country' => 'Mozambique',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MMR',
            'country' => 'Myanmar',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'NAM',
            'country' => 'Namibia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'NRU',
            'country' => 'Nauru',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'NPL',
            'country' => 'Nepal',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'NLD',
            'country' => 'Netherlands (Kingdom of the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'NCL',
            'country' => 'New Caledonia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'NZL',
            'country' => 'New Zealand',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'NIC',
            'country' => 'Nicaragua',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'NER',
            'country' => 'Niger (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'NGA',
            'country' => 'Nigeria',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'NIU',
            'country' => 'Niue',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'NFK',
            'country' => 'Norfolk Island',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MKD',
            'country' => 'North Macedonia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MNP',
            'country' => 'Northern Mariana Islands (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'NOR',
            'country' => 'Norway',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'OMN',
            'country' => 'Oman',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'PAK',
            'country' => 'Pakistan',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'PLW',
            'country' => 'Palau',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'PSE',
            'country' => 'Palestine, State of',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'PAN',
            'country' => 'Panama',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'PNG',
            'country' => 'Papua New Guinea',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'PRY',
            'country' => 'Paraguay',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'PER',
            'country' => 'Peru',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'PHL',
            'country' => 'Philippines (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'PCN',
            'country' => 'Pitcairn',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'POL',
            'country' => 'Poland',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'PRT',
            'country' => 'Portugal',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'PRI',
            'country' => 'Puerto Rico',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'QAT',
            'country' => 'Qatar',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'REU',
            'country' => 'Réunion',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'ROU',
            'country' => 'Romania',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'RUS',
            'country' => 'Russian Federation (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'RWA',
            'country' => 'Rwanda',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'BLM',
            'country' => 'Saint Barthélemy',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SHN',
            'country' => 'Saint Helena, Ascension and Tristan da Cunha',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'KNA',
            'country' => 'Saint Kitts and Nevis',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'LCA',
            'country' => 'Saint Lucia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'MAF',
            'country' => 'Saint Martin (French part)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SPM',
            'country' => 'Saint Pierre and Miquelon',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'VCT',
            'country' => 'Saint Vincent and the Grenadines',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'WSM',
            'country' => 'Samoa',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SMR',
            'country' => 'San Marino',
            'flag_code' => '🇸🇲',
        ]);

        Country::factory()->create([
            'id' => 'STP',
            'country' => 'Sao Tome and Principe',
            'flag_code' => '🇸🇹',
        ]);

        Country::factory()->create([
            'id' => 'SAU',
            'country' => 'Saudi Arabia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SEN',
            'country' => 'Senegal',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SRB',
            'country' => 'Serbia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SYC',
            'country' => 'Seychelles',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SLE',
            'country' => 'Sierra Leone',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SGP',
            'country' => 'Singapore',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SXM',
            'country' => 'Sint Maarten (Dutch part)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SVK',
            'country' => 'Slovakia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SVN',
            'country' => 'Slovenia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SLB',
            'country' => 'Solomon Islands',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SOM',
            'country' => 'Somalia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'ZAF',
            'country' => 'South Africa',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SGS',
            'country' => 'South Georgia and the South Sandwich Islands',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SSD',
            'country' => 'South Sudan',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'ESP',
            'country' => 'Spain',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'LKA',
            'country' => 'Sri Lanka',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SDN',
            'country' => 'Sudan (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SUR',
            'country' => 'Suriname',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SJM',
            'country' => 'Svalbard and Jan Mayen',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SWE',
            'country' => 'Sweden',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'CHE',
            'country' => 'Switzerland',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'SYR',
            'country' => 'Syrian Arab Republic (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TWN',
            'country' => 'Taiwan (Province of China)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TJK',
            'country' => 'Tajikistan',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TZA',
            'country' => 'Tanzania, the United Republic of',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'THA',
            'country' => 'Thailand',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TLS',
            'country' => 'Timor-Leste',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TGO',
            'country' => 'Togo',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TKL',
            'country' => 'Tokelau',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TON',
            'country' => 'Tonga',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TTO',
            'country' => 'Trinidad and Tobago',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TUN',
            'country' => 'Tunisia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TUR',
            'country' => 'Türkiye',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TKM',
            'country' => 'Turkmenistan',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TCA',
            'country' => 'Turks and Caicos Islands (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'TUV',
            'country' => 'Tuvalu',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'UGA',
            'country' => 'Uganda',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'UKR',
            'country' => 'Ukraine',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'ARE',
            'country' => 'United Arab Emirates (the)',
            'flag_code' => '🇦🇪',
        ]);

        Country::factory()->create([
            'id' => 'GBR',
            'country' => 'United Kingdom of Great Britain and Northern Ireland (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'UMI',
            'country' => 'United States Minor Outlying Islands (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'USA',
            'country' => 'United States of America (the)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'URY',
            'country' => 'Uruguay',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'UZB',
            'country' => 'Uzbekistan',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'VUT',
            'country' => 'Vanuatu',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'VEN',
            'country' => 'Venezuela (Bolivarian Republic of)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'VNM',
            'country' => 'Viet Nam',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'VGB',
            'country' => 'Virgin Islands (British)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'VIR',
            'country' => 'Virgin Islands (U.S.)',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'WLF',
            'country' => 'Wallis and Futuna',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'ESH',
            'country' => 'Western Sahara*',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'YEM',
            'country' => 'Yemen',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'ZMB',
            'country' => 'Zambia',
            'flag_code' => 'NULL',
        ]);

        Country::factory()->create([
            'id' => 'ZWE',
            'country' => 'Zimbabwe',
            'flag_code' => 'NULL',
        ]);

    }
}
