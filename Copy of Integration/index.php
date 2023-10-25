<?php
include_once('settings.php');

$file_name = date('Y-m-d__H-i-s').'__'.($_GET['site'] ?? '');

$data = json_decode(file_get_contents('php://input'));
file_put_contents('./logs/'.$file_name.'.input.order', print_r($data, true));

if (
    isset($_GET[$settings['key']]) &&
    isset($_GET['site']) &&
    in_array($_GET['site'], array_keys($settings['organization']))
  ) {

  include_once('api.php');
  include_once('curl.php');

  $curl = new curl($settings['token'], $settings['api_url']);
  $api = new api($settings['organization'], $_GET['site'], $curl);


  // 1. Получаем ID организации
  $organization_id = $api->get_organization_id();

  // 2. Получаем ID назначенного сотрудника
  $employee_id = $api->get_employee_id();

  // 3. Получаем ID отдела
  $group_id = $api->get_group_id();
  $sklad_id = $api->get_sklad_id();

  // 4. Получаем ID контрагента (существующего или создаем нового)
  $counterparty_id = $api->get_counterparty_id($data);
  if (!$counterparty_id) $counterparty_id = $api->create_counterparty($data);

  // 5. Обновляем данные по контрагенту
  $counterparty_id = $api->update_counterparty($counterparty_id, $data);

  // 6. Добавляем позиции в заказ контрагенту
  $order_id = $api->order($organization_id, $counterparty_id, $employee_id, $group_id, $sklad_id, $data);

}

echo 'Ok';
