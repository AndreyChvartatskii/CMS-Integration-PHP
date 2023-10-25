<?php
$settings = [
  'key'     => 'qerfsnL0NMrq7Pc9jS2YAqXf08oRDC',
  'token'   => '8c3dc3bac2ec246aa7a85fee7b1efb8374dc10c3',
  'api_url' => 'https://api.moysklad.ru/api/remap/1.2/entity',
  'organization' => [
    'ru.icolorpmu.com'  => [
      'employee_id' => '76600f4b-b77d-11e9-9ff4-3150001101d5', // Koldomova N.
      'group_id' => '11839e47-bd09-11e9-912f-f3d4001c2ef7', // Russia
      'organization_id' => '948b137c-97ec-11e9-912f-f3d400032b35', // ИП Колдомова Наталья Александровна
      'currency_id' => '948cbb57-97ec-11e9-912f-f3d400032b3c',     // Рубли
      'sklad_id' => '64f56cb8-a3e7-11e9-9ff4-34e80008e75b',     // Склад
      'delivery' => [                                              // Доставка
        'СДЭК (пункт самовывоза)' => 'D1', // СДЭК (пункт самовывоза)
        'СДЭК (постаматы, оплата картой)' => 'D1', // СДЭК (постаматы, оплата картой)
        'Доставка по Москве' => 'D1', // Доставка по Москве
        'Доставка по Санкт-Петербургу' => 'D1', // Доставка по Санкт-Петербургу
        'Самовывоз г. Санкт-Петербург, ул. Чайковского, 79, офис 5' => 'D16', // Самовывоз г. Санкт-Петербург, ул. Чайковского, 79, офис 5
        'Доставка курьером по России и странам ближнего зарубежья' => 'D1', // Доставка курьером по России и странам ближнего зарубежья
        'Суперэкспресс доставка СДЭКом по России и странам ближнего зарубежья' => 'D1', // Суперэкспресс доставка СДЭКом по России и странам ближнего зарубежья
      ],
      'paymentsystem' => [                                         // Оплата
        'yakassa' => 'P2', // Картой, ЮMoney или СБП через ЮKassa
        'tinkoff' => 'P10', // Картой через Tinkoff
        'cash' => 'P9', //Наличными при получении
      ],
    ],
    'eu.icolorpmu.com'  => [
      'employee_id' => 'b8d1ae7a-b77d-11e9-9ff4-34e80011142e', // Jaunzems K.
      'group_id' => '1183c456-bd09-11e9-912f-f3d4001c2ef8', // Latvia
      'organization_id' => '5535e5d3-bab9-11e9-912f-f3d40008ff9b', // iCOLOR SIA
      'currency_id' => '5fabddb7-a497-11e9-9109-f8fc0005a419',     // Евро
      'sklad_id' => '54c41688-a3e7-11e9-9ff4-31500008a1cd',     // Склад
      'delivery' => [                                              // Доставка
        'Standart EU shipping – 14,5 €' => 'D4', // Standart EU shipping – 14,5 €
        'Express EU shipping – 35 €' => 'D4', // Express EU shipping – 35 €
        'DPD Latvija kurjeru piegāde – 8 €' => 'D2', // DPD Latvija kurjeru piegāde – 8 €
        'Omniva Latvija pakomātu piegāde – 2.95 €' => 'D9', // Omniva Latvija pakomātu piegāde – 2.95 €
        'Omniva Baltics – 6.99 €' => 'D18', // Omniva Baltics – 6.99 €
        'QWQER piegāde Rīgā – 5 €' => 'D13', // QWQER piegāde Rīgā – 5 €
        'Worldwide UPS – 35 €' => 'D4', // Worldwide UPS – 35 €
        'Pickup: Palasta 5-1, Riga, Latvia - 0 €' => 'D6',
      ],
      'paymentsystem' => [                                         // Оплата
        'stripe' => 'P4', // Visa, Mastercard (Stripe)
        'paypal' => 'P3', // PayPal
        'cash' => 'P5',
      ],
    ],
    'int.icolorpmu.com' => [
      'employee_id' => 'b8d1ae7a-b77d-11e9-9ff4-34e80011142e', // Jaunzems K.
      'group_id' => '1183c456-bd09-11e9-912f-f3d4001c2ef8', // Latvia
      'organization_id' => '5535e5d3-bab9-11e9-912f-f3d40008ff9b', // iCOLOR SIA
      'currency_id' => '8f3c8ac2-dd9c-11eb-0a80-075000166e99',     // Доллары
      'sklad_id' => '54c41688-a3e7-11e9-9ff4-31500008a1cd',     // Склад
      'delivery' => [                                              // Доставка
        'Worldwide UPS 40$' => 'D4', // Worldwide UPS 40$
      ],
      'paymentsystem' => [                                         // Оплата
        'stripe' => 'P4', // Visa, Mastercard (Stripe)
        'paypal' => 'P3', // PayPal
      ],
    ],
    'de.icolorpmu.com'  => [
      'employee_id' => '999e1384-e098-11ea-0a80-02e10036e893', // Koln iCOLOR
      'group_id' => '1183d765-bd09-11e9-912f-f3d4001c2ef9', // Germany
      'organization_id' => '0686e67d-be69-11e9-9ff4-34e800031547', // iCOLOR PMU GMBH
      'currency_id' => '5fabddb7-a497-11e9-9109-f8fc0005a419',     // Евро
      'sklad_id' => '495d2110-a3e7-11e9-9109-f8fc00088869',     // Склад
      'delivery' => [                                              // Доставка
        'Versand nur innerhalb Deutschlands 5,90 €' => 'D3', // Versand nur innerhalb Deutschlands 5,90 €
        'EU-Versand 14,5 €' => 'D3', // EU-Versand 14,5 €
      ],
      'paymentsystem' => [                                         // Оплата
        'stripe' => 'P4', // mit Kreditkarte (Visa, Mastercard) per Zahlungsservice Stripe
        'paypal' => 'P3', // Paypal
      ],
    ],
    'uk.icolorpmu.com'  => [
      'employee_id' => '22196907-fc10-11ea-0a80-019700298ac4', // iColor UK and Ireland
      'group_id' => '2da12ad1-7d03-11eb-0a80-07da0011d3d6', // England
      'organization_id' => '8bfdfc66-74f7-11eb-0a80-0456002c9227', // IC PMU UK LTD
      'currency_id' => 'b0818a8f-74f8-11eb-0a80-0912002cd7c0',     // Фунты Стерлина
      'sklad_id' => 'a93966fe-74f7-11eb-0a80-0912002cbaf3',     // Склад
      'delivery' => [                                              // Доставка
        'Royal Mail standard delivery 5,99 GBP' => 'D14', // Royal Mail standard delivery 5,99 GBP
        'Royal Mail express delivery 8,99 GBP' => 'D15', // Royal Mail express delivery 8,99 GBP
      ],
      'paymentsystem' => [                                         // Оплата
        'stripe' => 'P4', // Stripe
      ],
    ],
    'deal.icolorpmu.com'  => [
      'employee_id' => '76600f4b-b77d-11e9-9ff4-3150001101d5', // Koldomova N.
      'group_id' => '11839e47-bd09-11e9-912f-f3d4001c2ef7', // Russia
      'organization_id' => '948b137c-97ec-11e9-912f-f3d400032b35', // ИП Колдомова Наталья Александровна
      'currency_id' => '948cbb57-97ec-11e9-912f-f3d400032b3c',     // Рубли
      'sklad_id' => '64f56cb8-a3e7-11e9-9ff4-34e80008e75b',     // Склад
    ],
    'bg.icolorpmu.com'  => [
      'employee_id' => '6fbdbc25-5a3d-11ea-0a80-02e5000de0b1', //Разработка бум
      'group_id' => '2da12ad1-7d03-11eb-0a80-07da0011d3d6', // England
      'organization_id' => '3e900d48-0381-11ee-0a80-0ea5003054ff', // Test Company
      'sklad_id' => 'a93966fe-74f7-11eb-0a80-0912002cbaf3',     // Склад
      'currency_id' => '5fabddb7-a497-11e9-9109-f8fc0005a419',     // Евро
      'delivery' => [                                              // Доставка
        // добавить варианты, если появятся
      ],
      'paymentsystem' => [                                         // Оплата
        'cash' => 'P9', // Наличными при получении
        'stripe' => 'P4', // Кредитной картой (Visa, Mastercard) через Stripe
      ],
    ],
  ],
];
