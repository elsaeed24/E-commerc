<?php

use App\Models\Setting;

// return [
//    'app' => [
//         'title' => 'Application Settings',
//         'setting' => [
//             'app.name' =>[
//                 'label' =>'Application Title',
//                 'type' =>'text',
//                 'validate' =>'string|max:255',
//             ],

//             'app.logo' => [
//                 'label' =>'Application Logo',
//                 'type' =>'image',
//                 'validate' =>'image',
//             ],
//             'app.locale' => [
//                 'label' =>'Default Language',
//                 'type' =>'select',
//                 'validate' =>'string',
//                 'options' => [Setting::class, 'localeOptions'],
//             ],
//             'app.timezone' => [
//                 'label' =>'Default Timezone',
//                 'type' =>'select',
//                 'validate' =>'string',
//                 'options' => [Setting::class, 'timezoneOptions'],
//             ],
//             'app.currency' => [
//                 'label' =>'Currency',
//                 'type' =>'select',
//                 'validate' =>'string',
//                 'options' => [Setting::class, 'currencyOptions'],
//             ],

//         ]

//    ]
// ];

return [
    'app' => [
        'title' => 'Application Settings',
        'label' =>'Application Title',
        'type' =>'text',
        'validate' =>'string|max:255',

    ]

 ];

