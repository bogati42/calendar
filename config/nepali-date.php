<?php
return [
    'nepali-date' => [
        'date_format' => 'Y-m-d',
        'locale' => 'ne', // Package uses 'ne' for Nepali locale
        'month_translations' => [
            'en' => [
                1 => 'Baisakh', 2 => 'Jestha', 3 => 'Ashad', 4 => 'Shrawan',
                5 => 'Bhadra', 6 => 'Ashwin', 7 => 'Kartik', 8 => 'Mangsir',
                9 => 'Poush', 10 => 'Magh', 11 => 'Falgun', 12 => 'Chaitra'
            ],
            'ne' => [ // Changed from 'np' to 'ne'
                1 => 'वैशाख', 2 => 'जेठ', 3 => 'असार', 4 => 'साउन',
                5 => 'भदौ', 6 => 'असोज', 7 => 'कार्तिक', 8 => 'मंसिर',
                9 => 'पुष', 10 => 'माघ', 11 => 'फागुन', 12 => 'चैत'
            ]
        ],
        'day_translations' => [
            'en' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            'ne' => ['आइत', 'सोम', 'मङ्गल', 'बुध', 'बिही', 'शुक्र', 'शनि']
        ]
    ]
];
