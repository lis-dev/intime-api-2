<?
// Сервер интайма работает медленно для некоторых функций, потому есть необходимость выставить time limit > 60
set_time_limit(90);
require_once './src/IntimeApi.php';
// В конструктор передаются id и ключ, полученние после регистрации на сайте http://www.intime.ua/register/
$intime = new IntimeApi('', '');
// Область отправителя
$intime->sender_region = 'Донецкая область';
// Город отправителя
$intime->sender_city = 'Донецк';
// Адрес склада отправителя
$intime->sender_address = 'ул. Сеченова, 31';
// Телефон отправителя
$intime->sender_phone = '+380970000000';
// Область получателя
$intime->receiver_region = 'Киевская область';
// Город получателя
$intime->receiver_city = 'Киев';
// Адрес склада получателя
$intime->receiver_address = 'пер. Моторный, 9';
// Телефон получателя
$intime->receiver_phone = '+380630000000';
// ФИО получателя
$intime->receiver_client = 'Тестовый получатель';
// Описание посылки
$intime->cargo_description = 'Куча личных вещей';
// Кол-во мест посылки
$intime->quantity = 3;
// Вес посылки
$intime->weight = 32;
// Объём посылки
$intime->volume = 0.17;
// Спунтиковое оборудование
$intime->cargo_type = '00101';
// Заявленная стоимость посылки
$intime->insurance_cost = 200;
// Сумма для наложенного платежа, если необходимо (если указана, то поле insurance_cost игнорируется)
// $intime->pod_amount = 200;
if ($intime->pod_amount) {
	// Кто оплачивает наложенный платеж
	$intime->pod_payment_type = 'POL';
}
// Получение кода склада (отделения) по городу и адресу
$result = $intime->get_department_code('Ивано-Франковск', 'ул. Шопена, 9/2');
// Получение кода населенного пункта по его названию и области
// $result = $intime->get_settlement_code('Раздольное', 'АР Крым');
// Получение стоимости доставки
// $result = $intime->calculate_ttn();
// Получение справочника списка населённых пунктов (List of settlements)
// $result = $intime->get_catalog('List of settlements');
// Получение справочника TTN
// $result = $intime->get_catalog('TTN');
// Получение срока доставки
// $intime->dispatch_date = date('Y-m-d+03:00');
// $result = $intime->delivery_day();
// Резервирование номера(-ов) ТТН
// $result = $intime->reserve_numbers(2);
// Генерирование новой ТТН
// $intime->dispatch_date = date('Y-m-d', time());
// $result = $intime->add_ttn();
// Проверка информации о номере ТТН
// $intime->ttn_number = '0531002118';
// $result = $intime->info_ttn();
// Удаление ТТН (или заявки на ТТН)
// $intime->ttn_number = '8999999941';
// $result = $intime->delete_ttn();
// Получение ссылки на pdf
// $intime->ttn_number = '8999999939';
// $result = $intime->print_ttn_ext();
var_export($result);
