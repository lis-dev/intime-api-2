<?
// Сервер интайма работает медленно для некоторых функций, потому есть необходимость выставить time limit > 60
set_time_limit(90);
require_once './src/IntimeApi.php';
// В конструктор передаются id и ключ, полученние после регистрации на сайте http://www.intime.ua/register/
$intime = new IntimeApi('', '');
// Область отправителя
$intime->senderRegion = 'Донецкая область';
// Город отправителя
$intime->senderCity = 'Донецк';
// Адрес склада отправителя
$intime->senderAddress = 'ул. Сеченова, 31';
// Телефон отправителя
$intime->senderPhone = '+380970000000';
// Область получателя
$intime->receiverRegion = 'Киевская область';
// Город получателя
$intime->receiverCity = 'Киев';
// Адрес склада получателя
$intime->receiverAddress = 'пер. Моторный, 9';
// Телефон получателя
$intime->receiverPhone = '+380630000000';
// ФИО получателя
$intime->receiverClient = 'Тестовый получатель';
// Описание посылки
$intime->cargoDescription = 'Куча личных вещей';
// Кол-во мест посылки
$intime->quantity = 3;
// Вес посылки
$intime->weight = 32;
// Объём посылки
$intime->volume = 0.17;
// Спунтиковое оборудование
$intime->cargoType = '00101';
// Заявленная стоимость посылки
$intime->insuranceCost = 200;
// Сумма для наложенного платежа, если необходимо (если указана, то поле insurance_cost игнорируется)
// $intime->podAmount = 200;
if ($intime->podAmount) {
	// Кто оплачивает наложенный платеж
	$intime->podPaymentType = 'POL';
}
// Получение кода склада (отделения) по городу и адресу
$result = $intime->getDepartmentCode('Ивано-Франковск', 'ул. Шопена, 9/2');
// Получение кода населенного пункта по его названию и области
// $result = $intime->getSettlementCode('Раздольное', 'АР Крым');
// Получение стоимости доставки
// $result = $intime->calculateTtn();
// Получение справочника списка населённых пунктов (List of settlements)
// $result = $intime->getCatalog('List of settlements');
// Получение справочника TTN
// $result = $intime->getCatalog('TTN');
// Получение срока доставки
// $intime->dispatchDate = date('Y-m-d+03:00');
// $result = $intime->deliveryDay();
// Резервирование номера(-ов) ТТН
// $result = $intime->reserveNumbers(2);
// Генерирование новой ТТН
// $intime->dispatchDate = date('Y-m-d', time());
// $result = $intime->addTTN();
// Проверка информации о номере ТТН
// $intime->ttnNumber = '0531002118';
// $result = $intime->infoTTN();
// Удаление ТТН (или заявки на ТТН)
// $intime->ttnNumber = '8999999941';
// $result = $intime->deleteTtn();
// Получение ссылки на pdf
// $intime->ttnNumber = '8999999939';
// $result = $intime->printTtnExt();
var_export($result);
