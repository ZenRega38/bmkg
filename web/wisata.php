<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="assets/image/logo_noname.png">
    <title>Wisata - BMKG Tarakan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/wisata.css">
    <link rel="stylesheet" href="css/outer.css">
    <style>
        .dataset-selector {
            margin-top: 30px;
            text-align: center;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dataset-selector select {
            background-color: #4682b4;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
             margin-bottom: 10px;
        }
        .dataset-selector select:hover {
             background-color: #5f9ea0;
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<script src="assets/script/nav.js"></script>

<?php
$tarakan = [
    [
        'title' => 'Taman Berlabuh',
        'images' => [
            'assets/image/wisata/tarakan/taman_berlabuh/1.png',
            'assets/image/wisata/tarakan/taman_berlabuh/2.png',
            'assets/image/wisata/tarakan/taman_berlabuh/3.png',
            'assets/image/wisata/tarakan/taman_berlabuh/4.png'
        ],
        'rating' => 4.3,
        'rating_count' => 2086,
        'type' => 'Tourist attraction',
        'status' => 'Open 24 hours',
        'location' => 'Karang Anyar, Tarakan Barat, Tarakan City, North Kalimantan',
        'map_link' => 'https://www.google.co.id/maps/dir//7HPR%2BGRW+Taman+Berlabuh,+Karang+Anyar,+Tarakan+Barat,+Tarakan+City,+North+Kalimantan/@3.2863568,117.5894926,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x32138afebf223fa9:0x87fb7f6f40e19413!2m2!1d117.5920675!2d3.2863568?entry=ttu&g_ep=EgoyMDI1MDEyMS4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.286493,
        'lng' => 117.592242,
        'zoom' => 15,
        'adm4' => '65.71.02.1003'
    ],
    [
        'title' => 'Taman Berkampung',
        'images' => [
            'assets/image/wisata/tarakan/taman_berkampung/1.png',
            'assets/image/wisata/tarakan/taman_berkampung/2.png'
        ],
        'rating' => 4.4,
        'rating_count' => 1557,
        'type' => 'Park',
        'status' => 'Open 24 hours',
        'location' => 'Kampung Empat, Tarakan Timur, Tarakan City, North Kalimantan',
        'map_link' => 'https://www.google.co.id/maps/dir//7JX9%2BRQ6+Taman+Berkampung,+Kampung+Empat,+Tarakan+Timur,+Tarakan+City,+North+Kalimantan/@3.2995442,117.6168096,17z/data=!4m16!1m7!3m6!1s0x32138bed1cc62cc1:0x726a0029fcc479d4!2sTaman+Berkampung!8m2!3d3.2995442!4d117.6193845!16s%2Fg%2F11gqpxjjc0!4m7!1m0!1m5!1m1!1s0x32138bed1cc62cc1:0x726a0029fcc479d4!2m2!1d117.6193845!2d3.2995442?entry=ttu&g_ep=EgoyMDI1MDEyMS4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.299416,
        'lng' => 117.619312,
        'zoom' => 15,
        'adm4' => '65.71.02.1002'
    ],
    [
        'title' => 'Konservasi Mangrove dan Bekantan',
        'images' => [
            'assets/image/wisata/tarakan/mangrove/1.png',
            'assets/image/wisata/tarakan/mangrove/2.png',
            'assets/image/wisata/tarakan/mangrove/3.png',
            'assets/image/wisata/tarakan/mangrove/4.png'
        ],
        'rating' => 4.3,
        'rating_count' => 2577,
        'type' => 'Nature Conservation',
        'status' => '7am - 5pm',
        'location' => 'Karang Rejo, Tarakan Barat, Karang Rejo, Kec. Tarakan Bar., Kota Tarakan, Kalimantan Utara',
        'map_link' => 'https://www.google.co.id/maps/dir//Kawasan+Konservasi+Mangrove+Dan+Bekantan,+Karang+Rejo,+Tarakan+Barat,+Karang+Rejo,+Kec.+Tarakan+Bar.,+Kota+Tarakan,+Kalimantan+Utara/@3.305523,117.5008878,13z/data=!4m8!4m7!1m0!1m5!1m1!1s0x32138a9448a0a9ed:0xbaf2f265d3abbe0!2m2!1d117.5771055!2d3.305523?entry=ttu&g_ep=EgoyMDI1MDEyMS4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.305421,
        'lng' => 117.577105,
        'zoom' => 16,
        'adm4' => '65.71.01.1005'
    ],
    [
        'title' => 'Pantai Amal',
        'images' => [
            'assets/image/wisata/tarakan/amal/1.png',
            'assets/image/wisata/tarakan/amal/2.png',
            'assets/image/wisata/tarakan/amal/3.png'
        ],
        'rating' => 4.0,
        'rating_count' => 377,
        'type' => 'Nature Attraction',
        'status' => 'Open 24 hours',
        'location' => 'Pantai Amal, Tarakan Timur, Tarakan City, North Kalimantan',
        'map_link' => 'https://www.google.co.id/maps/dir//Pantai+Amal,+Tarakan+Timur,+Tarakan+City,+North+Kalimantan/@3.3127237,117.6095191,13z/data=!4m8!4m7!1m0!1m5!1m1!1s0x321389fc0b69b165:0xbe7423fd93e38927!2m2!1d117.6493515!2d3.3215344?entry=ttu&g_ep=EgoyMDI1MDEyMS4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.304793,
        'lng' => 117.656830,
        'zoom' => 17,
        'adm4' => '65.71.01.1004'
    ],
    [
        'title' => 'Pantai Binalatung',
        'images' => [
            'assets/image/wisata/tarakan/binalatung/1.png',
            'assets/image/wisata/tarakan/binalatung/2.png',
            'assets/image/wisata/tarakan/binalatung/3.png'
        ],
        'rating' => 4.1,
        'rating_count' => 170,
        'type' => 'Nature Attraction',
        'status' => 'Open 24 hours',
        'location' => 'Jl. Ringroad Binalatung, Pantai Amal, Kec. Tarakan Tim., Kota Tarakan, Kalimantan Utara',
        'map_link' => 'https://www.google.co.id/maps/dir//Binalatung+Beach,+Pantai+Amal,+Tarakan+Timur,+Tarakan+City,+North+Kalimantan/@3.3205392,117.6477005,15z/data=!4m8!4m7!1m0!1m5!1m1!1s0x32147702c02edf31:0x826d4f4ac96cb7ad!2m2!1d117.6580003!2d3.3205393?entry=ttu&g_ep=EgoyMDI1MDEyMS.0wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.254906,
        'lng' => 117.655831,
        'zoom' => 15,
        'adm4' => '65.71.01.1003'
    ],
    [
        'title' => 'Rain Forest Kingdom Farm',
        'images' => [
            'assets/image/wisata/tarakan/kingdom_farm/1.png',
            'assets/image/wisata/tarakan/kingdom_farm/2.png',
            'assets/image/wisata/tarakan/kingdom_farm/3.png'
        ],
        'rating' => 4.2,
        'rating_count' => 24,
        'type' => 'Religious Landmark',
        'status' => 'Open 24 hours',
        'location' => 'Juata Laut, Tarakan Utara, Tarakan City, North Kalimantan',
        'map_link' => 'https://www.google.co.id/maps/dir//9HQ2%2B2RX+Rain+Forest+Kingdom+Farm,+Juata+Laut,+Kec.+Tarakan+Utara,+Kota+Tarakan,+Kalimantan+Utara/@3.38769,117.5521869,17z/data=!4m16!1m7!3m6!1s0x3214736ddce7bba9:0x41640ff4094c7bfb!2sRain+Forest+Kingdom+Farm!8m2!3d3.3876237!4d117.5521066!16s%2Fg%2F11v9ldxd7_!4m7!1m0!1m5!1m1!1s0x3214736ddce7bba9:0x41640ff4094c7bfb!2m2!1d117.5521066!2d3.3876237?entry=ttu&g_ep=EgoyMDI1MDEyMS.0wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.387490,
        'lng' => 117.551798,
        'zoom' => 14,
        'adm4' => '65.71.01.1002'
    ],
    [
        'title' => 'Wisata Persemaian',
        'images' => [
            'assets/image/wisata/tarakan/persemaian/1.png',
            'assets/image/wisata/tarakan/persemaian/2.png',
            'assets/image/wisata/tarakan/persemaian/3.png'
        ],
        'rating' => 4.4,
        'rating_count' => 130,
        'type' => 'Tourist Attraction',
        'status' => 'Open 24 hours',
        'location' => 'Juata Kerikil, Tarakan Utara, Tarakan City, North Kalimantan',
        'map_link' => 'https://www.google.co.id/maps/dir//9H49%2B9PF+Wisata+Persemaian,+Juata+Kerikil,+Kec.+Tarakan+Utara,+Kota+Tarakan,+Kalimantan+Utara/@3.3559286,117.5667146,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3214750d8951c09f:0x4f3a9a5c3d27367b!2m2!1d117.5692895!2d3.3559286?entry=ttu&g_ep=EgoyMDI1MDEyMS.0wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.356082,
        'lng' => 117.569594,
        'zoom' => 15,
        'adm4' => '65.71.01.1001'
    ],
    [
        'title' => 'Kampung Nelayan Juata Laut',
        'images' => [
            'assets/image/wisata/tarakan/kampung_nelayan/1.png',
            'assets/image/wisata/tarakan/kampung_nelayan/2.png'
        ],
        'rating' => 4.9,
        'rating_count' => 9,
        'type' => 'Tourist Attraction',
        'status' => 'Open 24 hours',
        'location' => 'Jl. Kakap, Juata Laut, Kec. Tarakan Utara, Kalimantan Utara',
        'map_link' => 'https://www.google.co.id/maps/dir//CGPV%2BH56+Kampung+Nelayan+Juata+Laut,+Jl.+Kakap,+Juata+Laut,+Tarakan+Utara,+North+Kalimantan/@3.3613769,117.5180613,12z/data=!4m8!4m7!1m0!1m5!1m1!1s0x32140d8c1ac9bbcd:0x6fc1730719facad7!2m2!1d117.5428768!2d3.4364051?entry=ttu&g_ep=EgoyMDI1MDEyMS.0wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.308961,
        'lng' => 117.611501,
        'zoom' => 14,
        'adm4' => '65.71.02.1001'
    ]
];

$bulungan = [
    [
        'title' => 'Wisata Alam Mangrove Ardimulyo',
        'images' => [
            'assets/image/wisata/bulungan/mangrove_ardimulyo/1.png',
            'assets/image/wisata/bulungan/mangrove_ardimulyo/2.png',
            'assets/image/wisata/bulungan/mangrove_ardimulyo/3.png',
        ],
        'rating' => 4.7,
        'rating_count' => 24,
        'type' => 'Nature Preserve',
        'status' => 'Open',
        'location' => 'Jl. Pelabuhan Ancam, Ardi Mulya, Kec. Tj. Palas Utara, Kabupaten Bulungan, Kalimantan Utara 77215',
        'map_link' => 'https://www.google.co.id/maps/dir//467V%2B623+Wisata+Alam+Mangroove+Ardimulyo,+Jl.+Pelabuhan+Ancam,+Ardi+Mulya,+Kec.+Tj.+Palas+Utara,+Kabupaten+Bulungan,+Kalimantan+Utara+77215/@3.1130172,117.2399622,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3213e3f610bec5ff:0x9c7b9cf222342ff!2m2!1d117.2425371!2d3.1130172?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.112931,
        'lng' => 117.242623,
        'zoom' => 15,
        'adm4' => '65.01.03.2005'  // Closest Match: Ardi Mulyo
    ],
    [
        'title' => 'Gunung Rego',
        'images' => [
            'assets/image/wisata/bulungan/gunung_rego/1.png',
            'assets/image/wisata/bulungan/gunung_rego/2.png',
            'assets/image/wisata/bulungan/gunung_rego/3.png',
        ],
        'rating' => 4.8,
        'rating_count' => 28,
        'type' => 'Mountain',
        'status' => 'Open',
        'location' => 'Desa Pimping, Tanjung Palas Utara, Bulungan Regency, North Kalimantan 77263',
        'map_link' => 'https://www.google.co.id/maps/dir//25QG%2BXRP+Gunung+Rego,+Desa,+Pimping,+Kec.+Tj.+Palas+Utara,+Kabupaten+Bulungan,+Kalimantan+Utara+77263/@3.0399573,117.1744976,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3213dfb182655abd:0x5e111db1ce1f466e!2m2!1d117.1770725!2d3.0399573?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.039794,
        'lng' => 117.176977,
        'zoom' => 15,
        'adm4' => '65.01.03.2002'  // Closest Match: Pimping
    ],
    [
        'title' => 'Kesultanan Bulungan',
        'images' => [
            'assets/image/wisata/bulungan/kesultanan_bulungan/1.png',
            'assets/image/wisata/bulungan/kesultanan_bulungan/2.png',
            'assets/image/wisata/bulungan/kesultanan_bulungan/3.png',
        ],
        'rating' => 4.2,
        'rating_count' => 468,
        'type' => 'Historical Landmark',
        'status' => 'Open',
        'location' => 'Central Tanjung Palas, Tanjung Palas, Bulungan Regency, North Kalimantan 77211',
        'map_link' => 'https://www.google.co.id/maps/dir//R9J4%2BQVF+Museum+Kesultanan+Bulungan,+Central+Tanjung+Palas,+Tanjung+Palas,+Bulungan+Regency,+North+Kalimantan+77211/@2.8319334,117.354598,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3213d1fccb45bc41:0xe17af808b6b65870!2m2!1d117.3571713!2d2.8319407?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 2.831989,
        'lng' => 117.357315,
        'zoom' => 15,
        'adm4' => '65.01.01.1002' // Closest Match: Tanjung Palas Tengah
    ],
    [
        'title' => 'Gunung Putih',
        'images' => [
            'assets/image/wisata/bulungan/gunung_putih/1.png',
            'assets/image/wisata/bulungan/gunung_putih/2.png',
            'assets/image/wisata/bulungan/gunung_putih/3.png',
        ],
        'rating' => 3.9,
        'rating_count' => 338,
        'type' => 'Mountain',
        'status' => 'Open',
        'location' => 'Central Tanjung Palas, Tanjung Palas, Bulungan Regency, North Kalimantan 77211',
        'map_link' => 'https://www.google.co.id/maps/dir//R8HV%2B3W8+White+Mountain+Tourism,+Central+Tanjung+Palas,+Tanjung+Palas,+Bulungan+Regency,+North+Kalimantan+77211/@2.8454783,117.3067183,14z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3213d1f6b21db5f7:0x670056c0535066d9!2m2!1d117.3448168!2d2.8276566?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 2.827622,
        'lng' => 117.344821,
        'zoom' => 15,
         'adm4' => '65.01.01.2005' //Closest Match: Gunung Putih
    ],
    [
        'title' => 'Muara Sekatak',
        'images' => [
            'assets/image/wisata/bulungan/muara_sekatak/1.png'
        ],
        'rating' => null,
        'rating_count' => null,
        'type' => 'Estuary',
        'status' => 'Open',
        'location' => 'Sekatak Buji, Sekatak, Bulungan Regency, North Kalimantan',
        'map_link' => 'https://www.google.co.id/maps/dir//Muara+Sekatak/@3.2166659,117.3776976,14z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3213f1076e3d84f1:0xb3be3d6927e436df!2m2!1d117.4166667!2d3.2166667?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.218379,
        'lng' => 117.305699,
        'zoom' => 15,
        'adm4' => '65.01.09.2001'  // Closest Match: Sekatak Buji
    ],
    [
        'title' => 'Tugu Cinta Damai',
        'images' => [
            'assets/image/wisata/bulungan/tugu_cinta_damai/1.png',
            'assets/image/wisata/bulungan/tugu_cinta_damai/2.png',
           'assets/image/wisata/bulungan/tugu_cinta_damai/3.png',
        ],
        'rating' => 4.5,
        'rating_count' => 619,
        'type' => 'Monument',
        'status' => 'Open',
        'location' => 'Jl. Katamso, Kabupaten Bulungan, Kalimantan Utara 77216',
        'map_link' => 'https://www.google.co.id/maps/dir//V947%2B98G+Tugu+Cinta+Damai,+Jl.+Katamso,+Bulungan+Regency,+North+Kalimantan+77216/@2.8559462,117.3607451,870m/data=!3m1!1e3!4m8!4m7!1m0!1m5!1m1!1s0x3213ce2a434f14c3:0xa4d242f609a94d20!2m2!1d117.36332!2d2.8559462?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 2.855903,
        'lng' => 117.363234,
        'zoom' => 15,
         'adm4' => '65.01.01.1003' // Closest Match: Tanjung Palas Hilir
    ],
    [
        'title' => 'Pantai Tanah Kuning',
        'images' => [
            'assets/image/wisata/bulungan/pantai_tanah_kuning/1.png',
            'assets/image/wisata/bulungan/pantai_tanah_kuning/2.png',
            'assets/image/wisata/bulungan/pantai_tanah_kuning/3.png',
        ],
        'rating' => 4.4,
        'rating_count' => 54,
        'type' => 'Beach',
        'status' => 'Open 8:15am - 10:00pm',
        'location' => 'Tanah Kuning, East Tanjung Palas, Bulungan Regency, North Kalimantan 77215',
        'map_link' => 'https://www.google.co.id/maps/dir//HRXG%2B2PC+Tanah+Kuning+2+Beach,+Tanah+Kuning,+East+Tanjung+Palas,+Bulungan+Regency,+North+Kalimantan+77215/@2.5975664,117.8242017,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x32125b6232e8c3f5:0x51750e1639308794!2m2!1d117.8267766!2d2.5975664?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 2.597960,
        'lng' => 117.826989,
        'zoom' => 15,
         'adm4' => '65.01.04.2001' // Closest Match: Tanah Kuning
    ],
    [
        'title' => 'Air Terjun Sungai Karai',
        'images' => [
            'assets/image/wisata/bulungan/air_terjun_sungai_karai/1.png',
            'assets/image/wisata/bulungan/air_terjun_sungai_karai/2.png',
            'assets/image/wisata/bulungan/air_terjun_sungai_karai/3.png',
        ],
        'rating' => 4.4,
        'rating_count' => 18,
        'type' => 'Waterfall',
        'status' => 'Open 7:00am - 6:00pm',
        'location' => 'Pejalin, Kec. Tj. Palas, Kabupaten Bulungan, Kalimantan Utara 77211',
        'map_link' => 'https://www.google.co.id/maps/dir//P7JQ%2B3C3+WISATA+AIR+TERJUN+SUNGAI+KARAI,+Unnamed+Road,+Pejalin,+Kec.+Tj.+Palas,+Kabupaten+Bulungan,+Kalimantan+Utara+77211/@2.730134,117.2859829,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3213d376e8cf0427:0xd19ba32bc9f932c!2m2!1d117.2885578!2d2.730134?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 2.729849,
        'lng' => 117.288391,
        'zoom' => 15,
        'adm4' => '65.01.03.2001' // Closest Match: Karang Agung
    ],
];

$nunukan = [
    [
        'title' => 'Rumah Dua Negara',
        'images' => [
            'assets/image/wisata/nunukan/rumah_dua_negara/1.png',
            'assets/image/wisata/nunukan/rumah_dua_negara/2.png',
            'assets/image/wisata/nunukan/rumah_dua_negara/3.png',
        ],
        'rating' => 4.7,
        'rating_count' => 409,
        'type' => 'Landmark',
        'status' => 'Open',
        'location' => 'Jl. Sei Pancang, Nunukan, Kec. Nunukan, Kabupaten Nunukan, Kalimantan Utara 77481',
        'map_link' => 'https://www.google.co.id/maps/dir//Wisata+Rumah+Dua+Negara,+77483+Tawau,+Sabah,+Malaysia/@4.1667212,117.8612812,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3215a1c52fb3c987:0xcef633e4f840bfac!2m2!1d117.8638561!2d4.1667212?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 4.166386,
        'lng' => 117.863879,
        'zoom' => 15,
         'adm4' => '65.03.11.2001' //Closest Match : Sungai Pancang
    ],
    [
        'title' => 'Pantai Batu Lamampu',
        'images' => [
            'assets/image/wisata/nunukan/pantai_batu_lamampu/1.png',
            'assets/image/wisata/nunukan/pantai_batu_lamampu/2.png',
             'assets/image/wisata/nunukan/pantai_batu_lamampu/3.png',
        ],
        'rating' => 4.2,
        'rating_count' => 87,
        'type' => 'Beach',
        'status' => 'Open 24 Hours',
        'location' => 'Lamijung, Kec. Nunukan Sel., Kabupaten Nunukan, Kalimantan Utara',
         'map_link' => 'https://www.google.co.id/maps/dir//2WR3%2B4HH+Obejek+Batu+Lamampu,+Tanjung+Karang/@4.0403165,117.9014101,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3215a7e70471e6f5:0x6476a404bc6b2c2c!2m2!1d117.903985!2d4.0403165?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 4.040271,
        'lng' => 117.903874,
        'zoom' => 15,
         'adm4' => '65.03.08.2001' //Closest Match : Tanjung Karang
    ],
     [
        'title' => 'Air Terjun Binusan',
        'images' => [
            'assets/image/wisata/nunukan/air_terjun_binusan/1.png'
        ],
        'rating' => null,
        'rating_count' => null,
        'type' => 'Waterfall',
        'status' => 'Open',
        'location' => 'Binusan, Nunukan, Nunukan Regency, North Kalimantan',
       'map_link' => 'https://www.google.co.id/maps/dir//Jl.+Air+Terjun,+Binusan,+Kec.+Nunukan,+Kabupaten+Nunukan,+Kalimantan+Utara+77482/@4.0845183,117.6272005,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3215b977321f0701:0x285d2964011d66d4!2m2!1d117.6297754!2d4.0845183?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 4.084068,
        'lng' => 117.629475,
        'zoom' => 15,
         'adm4' => '65.03.02.2004' //Closest Match : Binusan
    ],
    [
        'title' => 'Alun-alun Kota Nunukan',
        'images' => [
            'assets/image/wisata/nunukan/alun_alun_kota_nunukan/1.png',
            'assets/image/wisata/nunukan/alun_alun_kota_nunukan/2.png',
            'assets/image/wisata/nunukan/alun_alun_kota_nunukan/3.png',
        ],
         'rating' => 4.3,
        'rating_count' => 2440,
        'type' => 'Park',
        'status' => 'Open',
        'location' => 'Jl. Pattimura, Nunukan Tim., Kec. Nunukan, Kabupaten Nunukan, Kalimantan Utara 77482',
        'map_link' => '',
        'lat' => 4.140271,
        'lng' => 117.651113,
        'zoom' => 15,
         'adm4' => '65.03.02.1003' // Closest Match: Nunukan Utara
    ],
    [
        'title' => 'Pantai Pasir Putih Mengkadu',
        'images' => [
            'assets/image/wisata/nunukan/pantai_pasir_putih_mengkadu/1.png'
        ],
        'rating' => 4.3,
        'rating_count' => 4,
        'type' => 'Beach',
        'status' => 'Open',
        'location' => 'Mengkadu, Nunukan Sel., Nunukan Regency, North Kalimantan',
        'map_link' => 'https://www.google.co.id/maps/dir//XM9G%2B3JJ+Pantai+Pasir+Putih+Sei+Mengkadu,+Tj.+Harapan,+Nunukan+Sel.,+Kabupaten+Nunukan,+Kalimantan+Utara+77482/@3.9677034,117.6765072,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3215b3d844aa2adb:0x9f2a361ec284f5f2!2m2!1d117.6765072!2d3.9677034?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 4.078614,
        'lng' => 117.727129,
        'zoom' => 15,
        'adm4' => '65.03.09.1003' //Closest Match : Mansapa
    ],
    [
        'title' => 'Pantai Encing',
        'images' => [
            'assets/image/wisata/nunukan/pantai_encing/1.png',
           'assets/image/wisata/nunukan/pantai_encing/2.png',
            'assets/image/wisata/nunukan/pantai_encing/3.png',
        ],
        'rating' => 3.8,
        'rating_count' => 135,
        'type' => 'Beach',
        'status' => 'Open',
        'location' => 'Sei Nyamuk, Sebatik Tim., Nunukan Regency, North Kalimantan',
        'map_link' => 'https://www.google.co.id/maps/dir//Pantai+Encing,+South+Nunukan,+Nunukan+Regency,+North+Kalimantan+77482/@4.1091293,117.7904945,11.27z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3215bb3e256eb0a1:0x6d84853e3c908c33!2m2!1d117.7144943!2d4.0928584?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 4.091620,
        'lng' => 117.713838,
         'zoom' => 15,
         'adm4' => '65.03.10.2001' //Closest Match : Sungai Nyamuk
    ],
    [
        'title' => 'Desa Wisata Long Bawan',
        'images' => [
            'assets/image/wisata/nunukan/desa_wisata_long_bawan/1.png',
             'assets/image/wisata/nunukan/desa_wisata_long_bawan/2.png',
             'assets/image/wisata/nunukan/desa_wisata_long_bawan/3.png',
        ],
        'rating' => null,
        'rating_count' => null,
        'type' => 'Village',
        'status' => 'Open',
        'location' => 'Long Bawan, Krayan, Nunukan Regency, North Kalimantan',
        'map_link' => '',
        'lat' => 3.903901,
        'lng' => 115.698391,
        'zoom' => 15,
        'adm4' => '65.03.05.2041' //Closest Match : Long Bawan
    ],
];

$tana_tidung = [
    [
        'title' => 'Air Terjun Gunung Rian',
        'images' => [
             'assets/image/wisata/tana_tidung/air_terjun_gunung_rian/1.png',
            'assets/image/wisata/tana_tidung/air_terjun_gunung_rian/2.png',
            'assets/image/wisata/tana_tidung/air_terjun_gunung_rian/3.png',
            'assets/image/wisata/tana_tidung/air_terjun_gunung_rian/4.png'
        ],
        'rating' => 4.4,
        'rating_count' => 173,
        'type' => 'Waterfall',
        'status' => 'Open 7:00am - 5:00pm',
        'location' => 'Gunung Rian, Sesayap Hilir, Tana Tidung Regency, North Kalimantan',
        'map_link' => 'https://www.google.co.id/maps/dir//GR5G%2B6CX+Rian+Mountain+Waterfall,+Rian,+Sesayap,+Tana+Tidung+Regency,+North+Kalimantan+77152/@3.5081035,116.8165846,16z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3216b84132ed16e9:0xe209d1f9b7e74d0b!2m2!1d116.8261118!2d3.5081035?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.507632,
        'lng' => 116.825684,
        'zoom' => 15,
        'adm4' => '65.04.05.2002' // Closest Match: Rian
    ],
    [
        'title' => 'Taman Hutan Mangrove',
        'images' => [
            'assets/image/wisata/tana_tidung/taman_hutan_mangrove/1.png',
            'assets/image/wisata/tana_tidung/taman_hutan_mangrove/2.png',
            'assets/image/wisata/tana_tidung/taman_hutan_mangrove/3.png',
        ],
        'rating' => 4.5,
        'rating_count' => 60,
        'type' => 'Nature Preserve',
        'status' => 'Open 8:00am - 5:00pm',
        'location' => 'Tideng Pale Tim., Sesayap, Tana Tidung Regency, North Kalimantan',
        'map_link' => 'https://www.google.co.id/maps/dir//JW79%2B334+Taman+Hutan+Manggrove+Tana+Tidung,+Tideng+Pale,+Kec.+Sesayap,+Kabupaten+Tana+Tidung,+Kalimantan+Utara+77152/@3.6126257,116.9151261,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3216bd959e56be07:0xaf084375237091fd!2m2!1d116.917701!2d3.6126257?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.612615,
        'lng' => 116.917656,
        'zoom' => 15,
         'adm4' => '65.04.01.2005' // Closest Match: Tideng Pale Timur
    ],
    [
        'title' => 'Baloy Adat Tidung',
        'images' => [
            'assets/image/wisata/tana_tidung/baloy_adat_tidung/1.png',
             'assets/image/wisata/tana_tidung/baloy_adat_tidung/2.png',
             'assets/image/wisata/tana_tidung/baloy_adat_tidung/3.png',
        ],
        'rating' => 5.0,
        'rating_count' => 5,
       'type' => 'Historical Landmark',
        'status' => 'Open',
        'location' => 'Menjelutung, Sesayap Hilir, Tana Tidung Regency, North Kalimantan 77453',
         'map_link' => 'https://www.google.co.id/maps/dir//J5RQ%2B8HW+Balai+Adat+Tidung,+Menjelutung,+Sesayap+Hilir,+Tana+Tidung+Regency,+North+Kalimantan+77453/@3.6408749,117.1863741,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x321421042274fb47:0xe2e5b188d2a089a4!2m2!1d117.188949!2d3.6408749?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.581022,
        'lng' => 117.007007,
        'zoom' => 15,
        'adm4' => '65.04.01.2001'  // Closest Match: Tideng Pale
    ],
    [
        'title' => 'Ekowisata Kujau',
        'images' => [
             'assets/image/wisata/tana_tidung/ekowisata_kujau/1.png',
            'assets/image/wisata/tana_tidung/ekowisata_kujau/2.png',
             'assets/image/wisata/tana_tidung/ekowisata_kujau/3.png',
        ],
        'rating' => 4.1,
        'rating_count' => 63,
        'type' => 'Ecotourism',
        'status' => 'Open 8:00am - 5:00pm',
        'location' => 'Jl. Ahmad Yani, Kujau, Kec. Sesayap, Kabupaten Tana Tidung, Kalimantan Utara 77152',
        'map_link' => 'https://www.google.co.id/maps/dir//C2V7%2BXP9+Ekowisata+Yaki+Anan+Desa+Kujau,+Jl.+Ahmad+Yani,+Kujau,+Kec.+Sesayap,+Kabupaten+Tana+Tidung,+Kalimantan+Utara+77152/@3.4449045,117.0121786,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3216af61d45e28e5:0x5f756fdbd38ab8ce!2m2!1d117.0143673!2d3.4449045?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.444839,
        'lng' => 117.014444,
        'zoom' => 15,
        'adm4' => '65.04.04.2003' // Closest Match: Kujau
    ],
    [
         'title' => 'Hutan Pinus',
        'images' => [
            'assets/image/wisata/tana_tidung/hutan_pinus/1.png',
             'assets/image/wisata/tana_tidung/hutan_pinus/2.png',
             'assets/image/wisata/tana_tidung/hutan_pinus/3.png',
        ],
        'rating' => 4.4,
        'rating_count' => 44,
        'type' => 'Forest',
        'status' => 'Open',
        'location' => 'Jl. Perintis, Tideng Pale, Kec. Sesayap, Kabupaten Tana Tidung, Kalimantan Utara 77152',
         'map_link' => 'https://www.google.co.id/maps/dir//JW34%2BGRC+Hutan+Pinus+Tana+Tidung,+Jl.+Perintis,+Tideng+Pale,+Kec.+Sesayap,+Kabupaten+Tana+Tidung,+Kalimantan+Utara+77152/@3.6038169,116.9044303,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3216bdf9d3c6a371:0x77ba2193cf8f2725!2m2!1d116.9070052!2d3.6038169?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.514849,
        'lng' => 116.935876,
        'zoom' => 15,
         'adm4' => '65.04.01.2005' //Closest Match : Tideng Pale Timur
    ],
    [
        'title' => 'Sungai Rongkang',
       'images' => [
            'assets/image/wisata/tana_tidung/sungai_rongkang/1.png',
            'assets/image/wisata/tana_tidung/sungai_rongkang/2.png',
            'assets/image/wisata/tana_tidung/sungai_rongkang/3.png',
        ],
         'rating' => 4.5,
        'rating_count' => 4,
       'type' => 'River',
        'status' => 'Open',
        'location' => 'Sedulun, Sesayap, Tana Tidung Regency, North Kalimantan 77152',
        'map_link' => 'https://www.google.co.id/maps/dir//GV9H%2B58M+Wisata+Rongkang,+Sedulun,+Kec.+Sesayap,+Kabupaten+Tana+Tidung,+Kalimantan+Utara+77152/@3.5179696,116.8687669,16z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3216b98ac6c3853b:0xbf2c1adb30ee0313!2m2!1d116.8782941!2d3.5179696?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.518023,
        'lng' => 116.878062,
        'zoom' => 15,
         'adm4' => '65.04.05.2002' //Closest Match : Rian
    ],
];

$malinau = [
    [
        'title' => 'Air Terjun Semolon',
        'images' => [
            'assets/image/wisata/malinau/air_terjun_semolon/1.png',
            'assets/image/wisata/malinau/air_terjun_semolon/2.png',
             'assets/image/wisata/malinau/air_terjun_semolon/3.png',
        ],
        'rating' => 4.5,
        'rating_count' => 66,
       'type' => 'Waterfall',
        'status' => 'Open',
        'location' => 'Harapan Maju, Mentarang, Malinau Regency, North Kalimantan 77554',
        'map_link' => 'https://www.google.co.id/maps/dir//F98M%2B852+Semolon+Waterfall,+Harapan+Maju,+Mentarang,+Malinau+Regency,+North+Kalimantan+77554/@3.4657502,116.3803002,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x321728528e75e7dd:0xe682e32f75850e34!2m2!1d116.3828751!2d3.4657502?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.465443,
        'lng' => 116.383060,
        'zoom' => 15,
         'adm4' => '65.02.13.2001' //Closest Match : Setulang
    ],
    [
        'title' => 'Air Terjun Sekelibon',
        'images' => [
             'assets/image/wisata/malinau/air_terjun_sekelibon/1.png',
            'assets/image/wisata/malinau/air_terjun_sekelibon/2.png',
            'assets/image/wisata/malinau/air_terjun_sekelibon/3.png',
        ],
         'rating' => 4.4,
        'rating_count' => 12,
        'type' => 'Waterfall',
        'status' => 'Open',
        'location' => 'Paking, Mentarang, Malinau Regency, North Kalimantan 77555',
        'map_link' => 'https://www.google.co.id/maps/dir//GCJ7%2B3GC+Air+terjun+sekelibon,+Paking,+Kec.+Mentarang,+Kabupaten+Malinau,+Kalimantan+Utara+77555/@3.5301873,116.4111784,17z/data=!4m16!1m7!3m6!1s0x321725d10b6d48d9:0x1a5865d785062ed3!2sAir+terjun+sekelibon!8m2!3d3.5301873!4d116.4137533!16s%2Fg%2F11qnrlssy6!4m7!1m0!1m5!1m1!1s0x321725d10b6d48d9:0x1a5865d785062ed3!2m2!1d116.4137533!2d3.5301873?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.530181,
        'lng' => 116.413775,
        'zoom' => 15,
        'adm4' => '65.02.01.2006' // Closest Match: Paking
    ],
    [
        'title' => 'Air Terjun Marthin Bila',
        'images' => [
             'assets/image/wisata/malinau/air_terjun_marthin_bila/1.png',
            'assets/image/wisata/malinau/air_terjun_marthin_bila/2.png',
             'assets/image/wisata/malinau/air_terjun_marthin_bila/3.png',
        ],
         'rating' => 5.0,
        'rating_count' => 2,
       'type' => 'Waterfall',
        'status' => 'Open',
        'location' => 'Metut, Malinau Sel., Malinau Regency, North Kalimantan 77554',
        'map_link' => 'https://www.google.co.id/maps/dir//VGW7%2BV87+Air+Terjun+Marthin+Billa,+Metut,+Malinau+Sel.,+Kabupaten+Malinau,+Kalimantan+Utara+77554/@2.8991384,116.5031203,4627m/data=!3m1!1e3!4m16!1m7!3m6!1s0x321103433f4e9d55:0x8b529affc9794d4e!2sAir+Terjun+Marthin+Billa!8m2!3d2.8971687!4d116.5133116!16s%2Fg%2F11lrn72vpy!4m7!1m0!1m5!1m1!1s0x321103433f4e9d55:0x8b529affc9794d4e!2m2!1d116.5133116!2d2.8971687?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 2.891916,
        'lng' => 116.512699,
        'zoom' => 15,
         'adm4' => '65.02.02.2002' // Closest Match: Malinau Kota
    ],
    [
        'title' => 'Desa Wisata Setulang',
        'images' => [
            'assets/image/wisata/malinau/desa_wisata_setulang/1.png',
            'assets/image/wisata/malinau/desa_wisata_setulang/2.png',
            'assets/image/wisata/malinau/desa_wisata_setulang/3.png',
        ],
         'rating' => 4.6,
        'rating_count' => 202,
       'type' => 'Village',
        'status' => 'Open',
       'location' => 'Setulang, Malinau Sel., Malinau Regency, North Kalimantan 77554',
       'map_link' => 'https://google.co.id/maps/dir//Desa+Wisata+Setulang,+Setulang,+Malinau+Sel.,+Kabupaten+Malinau,+Kalimantan+Utara+77554/@3.4563759,116.4950313,869m/data=!3m1!1e3!4m8!4m7!1m0!1m5!1m1!1s0x3216d6d967788b4d:0xb7e371139443db59!2m2!1d116.4976062!2d3.4563759?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 3.456280,
        'lng' => 116.497703,
        'zoom' => 15,
         'adm4' => '65.02.13.2001' // Closest Match: Setulang
    ],
    [
        'title' => 'Taman Nasional Kayan Mentarang',
        'images' => [
            'assets/image/wisata/malinau/taman_nasional_kayan_mentarang/1.png',
            'assets/image/wisata/malinau/taman_nasional_kayan_mentarang/2.png',
            'assets/image/wisata/malinau/taman_nasional_kayan_mentarang/3.png',
            'assets/image/wisata/malinau/taman_nasional_kayan_mentarang/4.png',
            'assets/image/wisata/malinau/taman_nasional_kayan_mentarang/5.png',
            'assets/image/wisata/malinau/taman_nasional_kayan_mentarang/6.png',
        ],
         'rating' => 4.4,
        'rating_count' => 270,
        'type' => 'National Park',
       'status' => 'Open',
        'location' => 'Balai Taman Nasional Kayan Mentarang Pemda, Jl. Pusat Pemerintahan, Tanjung Belimbing, Pujungan, Kabupaten Malinau, Kalimantan Utara 77562',
        'map_link' => 'https://www.google.co.id/maps/dir//V9CH%2BPCG+Kayan+Mentarang+National+Park,+Balai+Taman+Nasional+Kayan+Mentarang+Pemda,+Jl.+Pusat+Pemerintahan,+Tanjung+Belimbing,+Pujungan,+Kabupaten+Malinau,+Kalimantan+Utara+77562/@2.8718169,115.3760006,17z/data=!4m8!4m7!1m0!1m5!1m1!1s0x2de5f1f024acf7dd:0x2f283b3e910b04c7!2m2!1d115.3785755!2d2.8718169?entry=ttu&g_ep=EgoyMDI1MDEyMi4wIKXMDSoASAFQAw%3D%3D',
        'lat' => 2.871742,
        'lng' => 115.378597,
        'zoom' => 15,
        'adm4' => '65.02.03.2001' // Closest Match: Pujungan
    ],
    [
        'title' => 'Desa Wisata Long Alango',
        'images' => [
            'assets/image/wisata/malinau/desa_wisata_long_alango/1.png',
             'assets/image/wisata/malinau/desa_wisata_long_alango/2.png',
            'assets/image/wisata/malinau/desa_wisata_long_alango/3.png',
        ],
         'rating' => null,
        'rating_count' => null,
        'type' => 'Village',
       'status' => 'Open',
        'location' => 'Long Tebulo, Bahau Hulu, Malinau Regency, North Kalimantan',
         'map_link' => '',
        'lat' => 2.961141,
        'lng' => 115.856618,
        'zoom' => 15,
        'adm4' => '65.02.05.2001' // Closest Match: Long Nawang
        
    ],
];

$selectedDataset = $_GET['dataset'] ?? 'tarakan';
$currentCards = ${$selectedDataset};
?>

<div class="dataset-selector">
    <form id="datasetForm">
        <select name="dataset" id="datasetSelect" onchange="this.form.submit()">
            <option value="tarakan" <?= $selectedDataset === 'tarakan' ? 'selected' : '' ?>>Kota Tarakan</option>
            <option value="bulungan" <?= $selectedDataset === 'bulungan' ? 'selected' : '' ?>>Kab. Bulungan</option>
            <option value="nunukan" <?= $selectedDataset === 'nunukan' ? 'selected' : '' ?>>Kab. Nunukan</option>
            <option value="tana_tidung" <?= $selectedDataset === 'tana_tidung' ? 'selected' : '' ?>>Kab. Tana Tidung</option>
            <option value="malinau" <?= $selectedDataset === 'malinau' ? 'selected' : '' ?>>Kab. Malinau</option>
        </select>
    </form>
</div>

<section class="card-grid">
    <?php foreach ($currentCards as $index => $card): ?>
    <div class="card-item">
        <div class="card-image">
            <div class="image-container">
                <?php foreach ($card['images'] as $image): ?>
                <img src="<?= $image ?>" alt="<?= $card['title'] ?>">
                <?php endforeach; ?>
            </div>
        </div>
        <div id="map-container<?= $index + 1 ?>" class="map-container"></div>
        <div class="card-content">
            <h2 class="card-title"><?= $card['title'] ?></h2>
            <div class="card-rating">
                <span class="rating-stars">
                    <?=                     
                        $fullStars = ($card['rating']);
                        $emptyStars = 6 - $fullStars;
                        echo str_repeat('★', $fullStars);
                        echo str_repeat('☆', $emptyStars); 
                                    
                    ?>
                </span>
                <span class="rating-count">(<?= number_format($card['rating_count']) ?>)</span>
            </div>
            <p class="card-description"><?= $card['type'] ?> · <span class="open-status"><?= $card['status'] ?></span></p>
            <p class="card-description"><?= $card['location'] ?></p>
            <div class="card-weather">
                <span class="weather-temp"></span>
                <span class="weather-desc"></span>
                <p class="weather-advice"></p>
            </div>
            <div class="card-actions">
                <a href="<?= $card['map_link'] ?>" class="navigation-button">
                    <img src="assets/image/direction.png" alt="Directions">
                </a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</section>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Map initialization
    const currentCards = <?= json_encode($currentCards) ?>;
    const mapContainers = document.querySelectorAll('.map-container');

    mapContainers.forEach((container, index) => {
        const uniqueMapId = `map${index + 1}`;
        container.innerHTML = `<div id="${uniqueMapId}"></div>`;
        const map = L.map(uniqueMapId, {
            zoomControl: false,
            attributionControl: false
        }).setView([currentCards[index].lat, currentCards[index].lng], currentCards[index].zoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        const apiKey = 'f1749350b540a2ca3c0b6a869d96894e';
        L.tileLayer(`https://tile.openweathermap.org/map/precipitation_new/{z}/{x}/{y}.png?appid=${apiKey}`, {
            zIndex: 50,
            maxZoom: 19
        }).addTo(map);
    });

    // Weather data fetching
    document.querySelectorAll('.card-item').forEach((card, index) => {
        const weatherContainer = card.querySelector('.card-weather');
        const tempSpan = weatherContainer.querySelector('.weather-temp');
        const descSpan = weatherContainer.querySelector('.weather-desc');
        const adviceP = weatherContainer.querySelector('.weather-advice');

        fetch(`https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=${currentCards[index].adm4}`)
            .then(response => response.json())
            .then(data => {
              if (data && data.data && data.data.length > 0 && data.data[0].cuaca) {
                const currentWeather = data.data[0].cuaca[0][0];
                tempSpan.innerHTML = `<img src="${currentWeather.image}" alt="Weather Icon"><span>${currentWeather.t}°C</span>`;
                descSpan.textContent = currentWeather.weather_desc;

                const nextHours = data.data[0].cuaca[0].slice(1, 7);
                const rainyHours = nextHours.filter(f => [61, 95, 97].includes(f.weather));
                let advice = `Saat ini cuaca ${currentWeather.weather_desc.toLowerCase()}. `;

                if([60, 61, 95, 97].includes(currentWeather.weather)) {
                    const clearTime = nextHours.find(f => ![60, 61, 95, 97].includes(f.weather));
                    advice += clearTime ? 
                        `Sebaiknya datang setelah jam ${new Date(clearTime.local_datetime).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}!` :
                        "Hujan mungkin berlanjut, pertimbangkan untuk menunda kunjungan!";
                } else if(rainyHours.length) {
                    const rainTime = new Date(rainyHours[0].local_datetime);
                    advice += `Membawa payung disarankan, kemungkinan hujan sekitar jam ${rainTime.toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'})}!`;
                } else {
                    advice += "Nikmati aktivitas Anda!";
                }
                adviceP.textContent = advice;
              }
              else {
                  tempSpan.textContent = 'N/A';
                  descSpan.textContent = 'Tidak ada data cuaca';
                  adviceP.textContent = '';
                }
            })
            .catch(error => {
                console.error('Weather fetch error:', error);
                tempSpan.textContent = 'N/A';
                descSpan.textContent = 'Gagal memuat data';
                adviceP.textContent = '';
            });
    });

    // Image carousel
    document.querySelectorAll('.card-image').forEach(cardImage => {
        let currentIndex = 0;
        const container = cardImage.querySelector('.image-container');
        const images = container.querySelectorAll('img');
        let interval;

        cardImage.addEventListener('mouseenter', () => {
            interval = setInterval(() => {
                currentIndex = (currentIndex + 1) % images.length;
                container.style.transform = `translateX(-${currentIndex * 100}%)`;
            }, 1500);
        });

        cardImage.addEventListener('mouseleave', () => {
            clearInterval(interval);
            currentIndex = 0;
            container.style.transform = 'translateX(0)';
        });
    });
});
</script>

<?php include 'footer.php'; ?>
</body>
</html>