<?php
class api {
  public $organization;
  public $site;
  public $curl;

  public function __construct($organization, $site, $curl) {
    $this->organization = $organization;
    $this->site = $site;
    $this->curl = $curl;
  }
  // Берем данные из settings 
  public function get_organization_id() { // Данные об организации
    return $this->organization[$this->site]['organization_id'];
  }

  public function get_employee_id() { // Данные о сотруднике
    return $this->organization[$this->site]['employee_id'];
  }

  public function get_group_id() { // Данные об отделе
    return $this->organization[$this->site]['group_id'];
  }

  public function get_sklad_id() { // Данные о складе
    return $this->organization[$this->site]['sklad_id'];
  }

  public function get_counterparty_id($data) { // Данные о контрагенте
    $phone = $data->phone ?? $data->Phone;
    $prepare_phone = $this->prepare_phone($data);
    $counterparties = json_decode($this->curl->request('GET', 'counterparty?filter=phone='.urlencode($prepare_phone)));
    if (count($counterparties->rows) > 0) return $counterparties->rows[0]->id;
    $counterparties = json_decode($this->curl->request('GET', 'counterparty?filter=phone='.urlencode($phone)));
    if (count($counterparties->rows) > 0) return $counterparties->rows[0]->id;
    return false;
  }

  public function get_product_id($externalCode) { // Данные о продукте
    return json_decode($this->curl->request('GET', 'product?filter=externalCode='.$externalCode))->rows[0]->id;
  }

  public function get_currency() { // Данные о валюте
    return [
      'currency' => $this->prepare_entity_meta('currency', $this->organization[$this->site]['currency_id']),
    ];
  }

  public function get_currency_name() { // Имя валюты
    return json_decode($this->curl->request('GET', 'currency/'.$this->organization[$this->site]['currency_id']))->isoCode;
  }

  public function get_delivery_meta($data) { // Данные о доставке delivery type
    if (
        isset($data->payment->delivery) &&
        isset($this->organization[$this->site]['delivery']) &&
        is_array($this->organization[$this->site]['delivery']) &&
        isset($this->organization[$this->site]['delivery'][trim($data->payment->delivery)])
    ) {
      $code = $this->organization[$this->site]['delivery'][trim($data->payment->delivery)];
      $meta = json_decode($this->curl->request('GET', 'customentity/01840175-83d9-11ea-0a80-02180030cb88?filter=code='.$code))->rows[0]->meta;
      return [
        "meta" => [
          "href" => "https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata/attributes/86b3e79e-8faa-11ea-0a80-02a70028877e",
          "type" => "attributemetadata",
          "mediaType" => "application/json"
        ],
        "id" => "86b3e79e-8faa-11ea-0a80-02a70028877e",
        "name" => "Delivery type",
        "type" => "customentity",
        "value" => [
          "meta" => (array)$meta
        ]
      ];
    }
    return false;
  }
  public function get_order_meta() { 
      return [
        "meta" => [
          "href" => "https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata/attributes/9762bbd6-8f74-11ea-0a80-016b00221185",
          "type" => "attributemetadata",
          "mediaType" => "application/json"
        ],
        "id" => "9762bbd6-8f74-11ea-0a80-016b00221185",
        "name" => "Order source",
        "type" => "customentity",
        "value" => [
          "meta" => [
              "href" => "https://api.moysklad.ru/api/remap/1.2/entity/customentity/e39c538d-8f73-11ea-0a80-03a100227d8b/3581f293-8f74-11ea-0a80-03a000223dbc",
              "metadataHref" => "https://api.moysklad.ru/api/remap/1.2/context/companysettings/metadata/customEntities/e39c538d-8f73-11ea-0a80-03a100227d8b",
              "type" => "customentity",
              "mediaType" => "application/json",
              "uuidHref" => "https://api.moysklad.ru/app/#custom_e39c538d-8f73-11ea-0a80-03a100227d8b/edit?id=3581f293-8f74-11ea-0a80-03a000223dbc"
          ],
          "name" => "Website order"
      ]
      ];
  }

  public function get_promocode_meta($data) { 
    return [
      "meta" => [
        "href" => "https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata/attributes/95d75548-5c71-11ee-0a80-135c00153769",
        "type" => "attributemetadata",
        "mediaType" => "application/json"
      ],
      "id" => "95d75548-5c71-11ee-0a80-135c00153769",
      "name" => "Промокод",
      "type" => "string",
      "value" => $data->payment->discountvalue.' ' .$data->payment->promocode
    ];
}

public function get_orderid_meta($data) { 
  return [
    "meta" => [
      "href" => "https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata/attributes/515d44fb-68fd-11ee-0a80-0f2f00127210",
      "type" => "attributemetadata",
      "mediaType" => "application/json"
    ],
    "id" => "515d44fb-68fd-11ee-0a80-0f2f00127210",
    "name" => "Order ID Tilda",
    "type" => "string",
    "value" => $data->payment->orderid
  ];
}

  public function get_payment_meta($data) { // Данные о способе оплаты payment type
    if (
        isset($data->paymentsystem) &&
        isset($this->organization[$this->site]['paymentsystem']) &&
        is_array($this->organization[$this->site]['paymentsystem']) &&
        isset($this->organization[$this->site]['paymentsystem'][$data->paymentsystem])
    ) {
      $code = $this->organization[$this->site]['paymentsystem'][$data->paymentsystem];
      $meta = json_decode($this->curl->request('GET', 'customentity/2fff7c3c-83da-11ea-0a80-05d40031f8ed?filter=code='.$code))->rows[0]->meta;
      return [
        "meta" => [
          "href" => "https://api.moysklad.ru/api/remap/1.2/entity/customerorder/metadata/attributes/9193e1fc-83da-11ea-0a80-05d40032039f",
          "type" => "attributemetadata",
          "mediaType" => "application/json"
        ],
        "id" => "9193e1fc-83da-11ea-0a80-05d40032039f",
        "name" => "Payment type",
        "type" => "customentity",
        "value" => [
          "meta" => (array)$meta
        ]
      ];
    }
    return false;
  }

  public function create_counterparty($data) { // Создаем контрагента
    $result['name'] = $this->prepare_name($data);
    return json_decode($this->curl->request('POST', 'counterparty', [ 'Content-Type: application/json' ], json_encode($result)))->id;
  }

  public function update_counterparty($counterparty_id, $data) {
    $result['companyType'] = 'individual';
    $result['phone'] = $this->prepare_phone($data);
    $result['email'] = $this->prepare_email($data);
    $result['name']  = $this->prepare_name($data);
    $result['legalFirstName'] = trim($data->name);

    // Если фамилию указали — только тогда меняем старую
    if (isset($data->surname) && strlen(trim($data->surname)) > 0) $result['legalLastName'] = trim($data->surname);

    // Если адрес указали — только тогда меняем старый
    $address = $this->prepare_address($data);
    if (strlen($address) > 0) {
      $result['actualAddress'] = $address;
      $result['legalAddress']  = $address;
    }

    // Если есть доставка — формируем данные для полей доставки
    if (isset($data->payment->delivery) && strlen($data->payment->delivery) > 0) $result['attributes'] = $this->prepare_attributes($data);

    return json_decode($this->curl->request('PUT', 'counterparty/'.$counterparty_id, [ 'Content-Type: application/json' ], json_encode($result)))->id;
  }

  public function order($organization_id, $counterparty_id, $employee_id, $group_id, $sklad_id, $data) { // Отправка даных
    $result['organization'] = $this->prepare_entity_meta('organization', $organization_id); // Нвименование организации
    $result['agent'] = $this->prepare_entity_meta('counterparty', $counterparty_id); // Данные о контрагенте
    $result['rate'] = $this->get_currency(); // Сумма заказа и валюта
    $result['owner'] = $this->prepare_entity_meta('employee', $employee_id); // Поле сотрудник
    $result['group'] = $this->prepare_entity_meta('group', $group_id); // Поле отдела
    $result['store'] = $this->prepare_entity_meta('store', $sklad_id); // Поле склада
    $result['reservedSum'] = $data->payment->amount * 0;

    if (isset($data->payment->delivery_address) && strlen($data->payment->delivery_address) > 0) {
      $result['shipmentAddress'] = $data->payment->delivery_address;
      $result['shipmentAddressFull'] = [
        'addInfo' => $data->payment->delivery_address,
        'comment' => ($data->payment->delivery_comment ?? '')
      ];
    } else {
      $address = $this->prepare_address($data);
      if (strlen($address) > 0) $result['shipmentAddress'] = $address;
    }

    if (count($data->payment->products) > 0) {
      $currency_name = $this->get_currency_name();
      $i = 0;
      $description = [];
      $result['positions'] = [];
      foreach ($data->payment->products as $product) {
        $i ++;
        $description[] = $i.'. '.$product->name.' ('.$product->quantity.' шт.) по '.$product->price.' '.$currency_name.' = '.$product->amount.' '.$currency_name;
        $result['positions'][] = [
          "quantity" => (int)$product->quantity,
          "price"    => (float)$product->price * 100,
//          "rate" => $this->get_currency(),
//          "discount" => 0,
//          "vat"      => 0,
          "assortment" => $this->prepare_entity_meta('product', $this->get_product_id($product->externalid)),
          "reserve" => 0.0,
        ];
      }

      $result['attributes'] = [];

      $delivery = $this->get_delivery_meta($data);
      if ($delivery != false) $result['attributes'][] = $delivery;

      $ordersource = $this->get_order_meta();
      $result['attributes'][] = $ordersource;

      $promocode = $this->get_promocode_meta($data);
      $result['attributes'][] = $promocode;

      $orderid = $this->get_orderid_meta($data);
      $result['attributes'][] = $orderid;

      $payment = $this->get_payment_meta($data);
      if ($payment != false) $result['attributes'][] = $payment;

      // Доставки России
      if (trim($data->payment->delivery) === "СДЭК (пункт самовывоза)") {
        $service = "d70afc28-44a6-11ed-0a80-0ed3002ac249";
      }
      if (trim($data->payment->delivery) === "СДЭК (постаматы, оплата картой)") {
        $service = "d70afc28-44a6-11ed-0a80-0ed3002ac249";
      }
      if (trim($data->payment->delivery) === "Доставка по Москве") {
        $service = "d70afc28-44a6-11ed-0a80-0ed3002ac249";
      }
      if (trim($data->payment->delivery) === "Доставка по Санкт-Петербургу") {
        $service = "766bf3cc-e6dc-11ea-0a80-04050043d02c";
      }
      if (trim($data->payment->delivery) === "Самовывоз г. Санкт-Петербург, ул. Чайковского, 79, офис 5") {
        $service = "d70afc28-44a6-11ed-0a80-0ed3002ac249";
      }
      if (trim($data->payment->delivery) === "Доставка курьером по России и странам ближнего зарубежья") {
        $service = "d70afc28-44a6-11ed-0a80-0ed3002ac249";
      }
      if (trim($data->payment->delivery) === "Суперэкспресс доставка СДЭКом по России и странам ближнего зарубежья") {
        $service = "d70afc28-44a6-11ed-0a80-0ed3002ac249";
      }
      // Доставки Европа
      if (trim($data->payment->delivery) === "Standart EU shipping – 14,5 €") {
        $service = "3dc76bea-6aa3-11ea-0a80-014a0007645f";
      }
      if (trim($data->payment->delivery) === "Express EU shipping – 35 €") {
        $service = "1a2e62ac-eb61-11ea-0a80-04f600216a9e";
      }
      if (trim($data->payment->delivery) === "DPD Latvija kurjeru piegāde – 8 €") {
        $service = "f0d552a7-e6da-11ea-0a80-03dd004420d0";
      }
      if (trim($data->payment->delivery) === "Omniva Latvija pakomātu piegāde – 2.95 €") {
        $service = "4e9180cd-6aa3-11ea-0a80-027100074d70";
      }
      if (trim($data->payment->delivery) === "Omniva Baltics – 6.99 €") {
        $service = "e763dda4-01b7-11ec-0a80-0d7f000e9295";
      }
      if (trim($data->payment->delivery) === "QWQER piegāde Rīgā – 5 €") {
        $service = "e6e11a65-9364-11ea-0a80-0575000c5002";
      }
      if (trim($data->payment->delivery) === "Worldwide UPS – 35 €") {
        $service = "1a2e62ac-eb61-11ea-0a80-04f600216a9e";
      }
      if (trim($data->payment->delivery) === "Pickup: Palasta 5-1, Riga, Latvia - 0 €") {
        $service = "106eb786-e6db-11ea-0a80-09140044db2b";
      }
      // Доставки Инт
      if (trim($data->payment->delivery) === "Worldwide UPS 40$") {
        $service = "1a2e62ac-eb61-11ea-0a80-04f600216a9e";
      }
      // Доставки Германия
      if (trim($data->payment->delivery) === "Versand nur innerhalb Deutschlands 5,90 €") {
        $service = "220242e0-6aa3-11ea-0a80-063200077ba2";
      }
      if (trim($data->payment->delivery) === "EU-Versand 14,5 €") {
        $service = "3dc76bea-6aa3-11ea-0a80-014a0007645f";
      }
      // Доставки Англия
      if (trim($data->payment->delivery) === "Royal Mail standard delivery 5,99 GBP") {
        $service = "bc190cc9-8cb2-11eb-0a80-084700118e99";
      }
      if (trim($data->payment->delivery) === "Royal Mail express delivery 8,99 GBP") {
        $service = "cfea6432-8cb2-11eb-0a80-023a001178c2";
      }
      // Доставка
      if (isset($data->payment->delivery_price)) $result['positions'][] = [
        "quantity" => 1,
        "price" => (float)$data->payment->delivery_price * 100,
//        "rate" => $this->get_currency(),
        "assortment" => $this->prepare_entity_meta('service', $service),
      ];

      // Описание (Комментарий к заказу)
      if (isset($data->payment->delivery)) {
        $i ++;
        $description[] = $i.'. Доставка: '.trim($data->payment->delivery);
      }
      $description[] = '—';
      $description[] = 'ИТОГО: '.$data->payment->amount.' '.$currency_name;
      if (isset($data->payment->discountvalue)) $description[] = 'Промокод: ' .$data->payment->discountvalue.' ' .$data->payment->promocode;
      $description[] = '';
      $description[] = $this->prepare_phone($data);
      $description[] = $this->prepare_email($data);
      $description[] = $this->prepare_name($data);
      $description[] = $this->prepare_address($data);
      $result['description'] = implode("\n", $description);
    }
    return json_decode($this->curl->request('POST', 'customerorder', [ 'Content-Type: application/json' ], json_encode($result)));
  }

  private function prepare_phone($data) {
    $phone = trim($data->phone ?? $data->Phone);
    return '+'.preg_replace('{[^0-9]+}', '', $phone);
  }

  private function prepare_email($data) {
    return trim($data->email ?? $data->Email);
  }

  private function prepare_name($data) {
    return trim($data->name.(isset($data->surname) ? ' '.$data->surname : ''));
  }

  private function prepare_address($data) {
    $address = [];
    if (isset($data->{'zip-code'})) $address[] = $data->{'zip-code'};
    if (isset($data->Country)) $address[] = $data->Country;
    if (isset($data->TownCity)) $address[] = $data->TownCity;
    if (isset($data->{'delivery-adress'})) $address[] = $data->{'delivery-adress'};
    return implode(', ', $address);
  }

  private function prepare_attributes($data) {
    $result = [];

    // Доставка курьером (галочка)
    $result[] = $this->prepare_counterparty_attributemetadata('9f1387b8-adf1-11e9-9107-50480003ddb7', true);

    // Условия доставки ($data->payment->delivery)
    $result[] = $this->prepare_counterparty_attributemetadata('1e8de326-8e48-11eb-0a80-0425000f494e', trim($data->payment->delivery));

    // Страна & Countries
    if (isset($data->Country)) {
      // Текстом
      $result[] = $this->prepare_counterparty_attributemetadata('fd668509-adf1-11e9-912f-f3d40003eaf8', $data->Country);
      // Поле выбора
      $result[] = $this->prepare_counterparty_attributemetadata('abba620d-8617-11ea-0a80-00d500053e9e', [ 'name' => $data->Country ]);
    }

    // Город
    if (isset($data->TownCity)) $result[] = $this->prepare_counterparty_attributemetadata('fd668bdd-adf1-11e9-912f-f3d40003eafa', $data->TownCity);

    // Адрес доставки
    if (isset($data->{'delivery-adress'})) $result[] = $this->prepare_counterparty_attributemetadata('fd668e02-adf1-11e9-912f-f3d40003eafb', $data->{'delivery-adress'});

    // Почтовый индекс
    if (isset($data->{'zip-code'})) $result[] = $this->prepare_counterparty_attributemetadata('fd668fcf-adf1-11e9-912f-f3d40003eafc', $data->{'zip-code'});
    
    return $result;
  }

  private function prepare_counterparty_attributemetadata($id, $value) {
    return [
      "meta" => [
        "href" => $this->curl->api_url."/counterparty/metadata/attributes/$id",
        "type" => "attributemetadata",
        "mediaType" => "application/json"
      ],
      'value' => $value,
    ];
  }

  private function prepare_entity_meta($entity, $id) {
    return [
      "meta" => [
        "href" => $this->curl->api_url."/$entity/$id",
        "type" => "$entity",
        "mediaType" => "application/json"
      ]
    ];
  }



}
