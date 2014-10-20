<?php
/**
 * Класс для работы с API службы доставки Интайм (Украина)
 * 
 * @author lis-dev
 * @link http://www.intime.ua/API2.0/API_2_0.pdf
 * @version 0.01
 */
class IntimeApi {
	// Идентефикатор пользователя
	public $id,
	// Ключ пользователя
	$key,
	// Область отправителя
	$sender_region = '',
	// Город отправителя
	$sender_city = '',
	// Код населённого пункта отправителя, если в нем нет представительства
	$sender_settlement_code = '',
	// Адрес склада отправителя
	$sender_address = '',
	// Телефон отправителя
	$sender_phone = '',
	// Код склада отправителя
	$sender_warehouse_code = '',
	// Название компании отправителя
	$sender_company = '',
	// Область получателя
	$receiver_region = '',
	// Город получателя
	$receiver_city = '',
	// Код населённого пункта получателя, если в нем нет представительства
	$receiver_settlement_code = '',
	// Адрес склада получателя
	$receiver_address = '',
	// Телефон получателя
	$receiver_phone = '',
	// Получатель (ФИО)
	$receiver_client = '',
	// Код склада получателя
	$receiver_warehouse_code = '',
	
	// Тип оплаты отправителя ('OTP' - Отправитель, 'PNP' - Оплата 50 50, 'PRV' - Произвольно, 'OTL' - Оплата третьим лицом, 'POL' - Получатель)
	$payment_type = 'POL',
	
	// Тип оплаты пост-сервиса ('OTP' - Отправитель, 'POL' - Получатель)
	$pod_payment_type = '',
	
	// Сумма пост-сервиса
	$pod_amount = 0,
	
	// Дата отправки. Формат "2014-09-29+03:00"
	$dispatch_date = '',
	
	// Ценность (стоимость заказа)
	$insurance_cost = 200,
	
	// Код вида перевозки (01 - Дверь - Дверь, 02 - Дверь - Область, 03 - Дверь - Склад, 04 - Область - Дверь,
	// 05 - Область - Область, 06 - Область - Склад, 07 - Склад - Дверь, 08 - Склад - Область, 09 - Склад - Склад)
	$transportation_type = '09',
	
	// Код метода оплаты (t|cash)
	$payment_method = 'cash',
	
	// Код упаковки отправителя
	// 00001 - 1. СБОРНАЯ; 00002 - 2. БЕЗ УПАКОВКИ; 00003 - 3. БЕЗ ДОУПАКОВКИ; 00004 - 4. НЕ СООТВЕТСТВУЕТ УПАКОВКЕ; 00005 - 5. ОТКАЗ КЛИЕНТА ОТ УПАКОВКИ; 
	// 00006 - 6. СОРТИРОВКА (услуга); 00007 - бирка + хомут пластиковые; 00008 - Бирка пластиковая, шт; 00009 - Бланк для лазерной печати, шт; 00010 - Бумага А4, ящик; 
	// 00011 - Ведомость на выдачу груза; 00012 - Воздушно-пузырьковая пленка, 0,5 м; 00013 - Воздушно-пузырьковая пленка, 1 м; 00014 - Воздушно-пузырьковая пленка, упаковка; 00015 - Гофрокороб 220 x 120 x 80, шт; 
	// 00016 - Гофрокороб 347 x 274 x 190, шт; 00017 - Гофрокороб 469 x 279 x 190, шт; 00018 - Гофрокороб 500 х 400 х 300, шт; 00019 - Гофрокороб 700 х 500 х 500, шт; 00020 - Декларации на забор груза, шт; 
	// 00021 - Декларации ручные, шт; 00022 - Декларации, ящик; 00023 - Картонный лист, шт; 00024 - Квитанционные книжки, шт; 00025 - Конверты для ПС, шт; 
	// 00026 - Контейнер на колесах; 00027 - Контейнер почтовый ТИП 1 (оборотная тара); 00028 - Контейнер почтовый ТИП 2 (оборотная тара); 00029 - Контейнер почтовый ТИП 3 (оборотная тара); 00030 - Контейнер почтовый ТИП 4 (оборотная тара);
	// 00031 - Контейнер почтовый ТИП 5 (оборотная тара); 00032 - короб для бампера 2200 х 800 х 600; 00033 - Лента для паллетирования, метры; 00034 - Мешок 1200*1000, шт; 00035 - Мешок для краски, шт; 
	// 00036 - Мешок для мелких грузов, шт; 00037 - Обрешетка деревянная - 0,25 м3; 00038 - Обрешетка деревянная - 1,00 м3; 00039 - Оценочный талон; 00040 - Пакеты для Резины СС; 
	// 00041 - Паллета; 00042 - Паллета для дверей (оборотная тара); 00043 - Паллета для дверей (Продажа); 00044 - Паллета малая (Продажа); 00045 - Пенопласт, м2;
	// 00046 - Пломба автомобильная, шт; 00047 - Пломба на мешки, шт; 00048 - Пломба на продажу, шт; 00049 - Профиль до 5 м, шт; 00050 - Профиль от 5 до 7 м, шт;
	// 00051 - Профиль свыше 7 м, шт; 00052 - Секьюрпак; 00053 - Сетка москитная (норма 2,5 м); 00054 - Сетчатое ограждение для паллет КСП-001 (Об.тара); 00055 - Сетчатое ограждение для паллет КСП-002 (Об.тара);
	// 00056 - Скоба проволочная 16 мм, шт; 00057 - Скотч красный; 00058 - Скотч прозрачный; 00059 - Скотч фирменный; 00060 - Стикер, шт;
	// 00061 - Стрейч пленка, 1/2 нормы расхода (5 м); 00062 - Стрейч пленка, норма расхода (10 м); 00063 - Стрейчпленка , шт; 00064 - Уголок гофрокартонный, шт; 00065 - Уголок для мебели, шт;
	// 00066 - Факсбумага, шт; 00067 - Фирменный конверт бумажный А-4; 00068 - Фирменный пакет пластиковый А-2 большой; 00069 - Фирменный пакет пластиковый А-3; 00070 - Хомут пластиковый, шт;
	// 00071 - Ящик для автостекла 0,51 - 1,00 м3 (Оборот. тара); 00072 - Ящик для автостекла 1,01 - 1,50 м3 (Оборот. тара); 00073 - Ящик для автостекла 1,51 - 2,00 м3 (Оборот. тара); 00074 - Ящик для автостекла до 0,5 м3 (Оборотная тара); 00075 - Ящик для велотехники (Оборотная тара);
	// 00076 - Ящик для мебели объем  до 1,00 м3 (Оборот. тара); 00077 - Ящик для мебели объем 1,01 - 1,5м3 (Оборот. тара); 00078 - Ящик для мебели объем 1,51-2,0м3 (Оборот. тара); 00079 - Ящик для мототехники (Оборотная тара); 00080 - Ящик для санфанфаянсовых и керамических изделий;
	// 00081 - Ящик многоцелевого назначения (Оборотная тара); 00082 - Ящик посылочка Запорожье; 00083 - Ящик почтовый 1200x800x800 (Оборотная тара);
	$packages_type_code = '00005',
	
	// Количество упаковок
	$package_quantity = 0,

	// Кол-во мест
	$quantity = 0,
	// Вес, кг
	$weight = 0,
	// Объем, м3
	$volume = 0,
	// Тип груза 00131 - вещи, 00101 - быттехника, 00748 - спутниковое оборудование, 00788 - ТВ оборудование, 00811 - техника
	$cargo_type = '00131',
	// Описание груза
	$cargo_description = '',
	// Номер ТТН накладной
	$ttn_number = '';
	
	// Список населенных пунктов, в которых нет представительства
	private static $_list_of_settlements = array(),
	// Список представительств
	$_departments = array();
	
	/**
	 *  Конструктор по умолчанию
	 * 
	 * @param string $id Идентефикатор пользователя
	 * @param string $key Ключ пользователя
	 * @return Intime
	 */
	function __construct($id, $key) {
		// ini_set("soap.wsdl_cache_enabled", "0");
		$this->id = $id;
		$this->key = $key;
		$this->dispatch_date = date("Y-m-d+03:00");
		return $this;
	}
	
	/**
	 * Рекурсивное преобразование объекта в массив
	 * 
	 * @param mixed $var Массив, объект или строка
	 * @param string $in_charset 
	 * @return mixed
	 */
	private function _to_array($var) {
		is_object($var) AND $var = (array) $var;
		if (is_array($var)) {
			foreach ($var as $key => $value) {
				is_object($value) AND $value = (array) $value;
				$var[$key] = $this->_to_array($value);
			}
		}
		return $var;
	}
	
	/**
	 * Выполнение SOAP запроса к серверу intime.ua
	 * 
	 * @param string $method Название метода
	 * @param array $params Массив необхоодимых параметров
	 * @return object Объект результата SOAP запроса 
	 */
	public function intime_request($method, $params) {
		$client = new \SoapClient("https://ws.intime.ua/API/ws/API20/?wsdl");
		// $response = $client->$method($params)->return;
		$response = $client->__soapCall($method, $params)->return;
		// $client->$function($data)->return;
		// Это не магия, здесь ok (eng) и ок (рус)
		if ( ! in_array($response->InterfaceState, array('OK', 'ОК', iconv('utf-8', 'cp1251', 'ОК'))))
			throw new Exception($response->InterfaceState);
		$response = $this->_to_array($response);
		return $response;
	}
	
	/**
	 * Проверка и подготовка данных перед запросом
	 * 
	 * @param array $required_fileds Массив обязательных полей
	 * @return bool
	 */
	private function _prepare_data($required_fileds) {
		// Попытка получить код склада отправителя 
		if (in_array('sender_warehouse_code', $required_fileds) AND ! $this->sender_warehouse_code) {
			$this->sender_warehouse_code = $this->get_department_code( (string) $this->sender_city, (string) $this->sender_address);
			// Если нет склада отправителя, то попытка получить код населенного пункта
			if ( ! $this->sender_warehouse_code) {
				$this->sender_settlement_code = $this->get_settlement_code( (string) $this->sender_city, (string) $this->sender_region);
				if ( ! $this->sender_settlement_code) {
					throw new Exception("Не удалось определить ни код склада, ни код города отправителя");
				}
			}
		}
		// Попытка получить код склада получателя 
		if (in_array('receiver_warehouse_code', $required_fileds) AND  ! $this->receiver_warehouse_code) {
			$this->receiver_warehouse_code = $this->get_department_code( (string) $this->receiver_city, (string) $this->receiver_address);
			if ( ! $this->receiver_warehouse_code) {
				$this->receiver_settlement_code = $this->get_settlement_code( (string) $this->receiver_city, (string) $this->receiver_region);
				if ( ! $this->receiver_settlement_code) {
					throw new Exception("Не удалось определить ни код склада, ни код города получателя");
				}
			}
		}
		if (in_array('quantity', $required_fileds) AND  ! $this->quantity) {
			throw new Exception("Не указано кол-во мест для груза");
		}
		
		if (in_array('weight', $required_fileds) AND  ! $this->weight) {
			throw new Exception("Не указан вес груза");
		}
		
		if (in_array('volume', $required_fileds) AND  ! $this->volume) {
			throw new Exception("Не указан объём груза");
		}
		
		return TRUE;
	}

	/**
	 * Получение кода населенного пункта по его названию и области (району) - для пгт, сел, посёлков и т.п.
	 * 
	 * @param string $settlement Название населенного пункта
	 * @param string $region Область
	 * @return string Код города
	 */
	public function get_settlement_code($settlement, $region) {
		// Есть необходимость записать результат, т.к. размер передаваемого файла > 3M
		if ( ! self::$_list_of_settlements) {
			self::$_list_of_settlements = $this->get_catalog('List of settlements');
		}
		// Поиск города и адреса
		foreach (self::$_list_of_settlements['ListCatalog']['Catalog'] as $settlement_current) {
			if (mb_stripos($settlement_current['Name'], $settlement) !== FALSE 
			AND (mb_stripos($settlement_current['AppendField'][0]['AppendFieldValue'], $region) !== FALSE 
			OR mb_stripos($settlement_current['AppendField'][1]['AppendFieldValue'], $region) !== FALSE)) {
				$settlement_code = $settlement_current['Code'];
				break;
			}
		}
		return $settlement_code;
	}
	
	/**
	 * Определение кода склада (отделения) по названию города и адресу отделения
	 * 
	 * @param string $city
	 * @param string $address
	 * @return string Code
	 */
	public function get_department_code($city, $address) {
		// Есть необходимость записать результат, т.к. размер передаваемого файла > 500K
		( ! self::$_departments) AND self::$_departments = $this->get_catalog('Departments');
		// Поиск города и адреса
		foreach (self::$_departments['ListCatalog']['Catalog'] as $department) {
			if (mb_stripos($department['Name'], $city) !== FALSE AND mb_stripos($department['AppendField'][0]['AppendFieldValue'], $address) !== FALSE) {
				$warehouse_code = $department['Code'];
				break;
			}
		}
		return $warehouse_code;
	}

	/**
	 * Получение всеx названий справочников
	 * 
	 * @return array
	 */
	function get_all_catalogs() {
		$data['AllCatalog']['AllСatalogRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$result = $this->intime_request("AllCatalog", $data);
		return $result;
	}
	
	/**
	 * Получение каталога (справочника)
	 * 
	 * @param string $catalog Название каталога
	 * @return array Массив каталогов
	 */
	function get_catalog($catalog) {
		$data['CatalogList']['CatalogListRequest']['AuthData'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['CatalogList']['CatalogListRequest']['CatalogNameEng'] = $catalog;
		$result = $this->intime_request("CatalogList", $data);
		return $result;
	}
	
	/**
	 * Метод предназначен для расчета сроков доставки
	 * 
	 * @return string
	 */
	function delivery_day() {
		// Проверка необходимых полей и попытка получить значения пустых полей
		$this->_prepare_data(array('sender_warehouse_code', 'receiver_warehouse_code'));
		$data = array(
			'DeliveryDay' =>  array(
				'DayOfDeliveryRequest' => array(
					'AuthData' => array(
						'ID' => $this->id,
						'KEY' => $this->key,
					),
					'WarehouseSender' => $this->sender_warehouse_code,
					'WarehouseReceiver' => $this->receiver_warehouse_code,
					'SettlementCodeSender' => $this->sender_settlement_code,
					'SettlementCodeReceiver' => $this->receiver_settlement_code,
					// Дата отправки
					'Data' => $this->dispatch_date,
					'TransportationType' => $this->transportation_type,
				),
			)
		);
		$result = $this->intime_request("DeliveryDay", $data);
		return $result['DayOfDelivery'];
	}
	
	/**
	 * Получение стоимости товара
	 * 
	 * @return float Стоимость доставки
	 */
	public function calculate_ttn() {
		// Проверка необходимых полей и попытка получить значения пустых полей
		$this->_prepare_data(array('sender_warehouse_code', 'receiver_warehouse_code', 'quantity', 'weight', 'volume'));
		// Подготовка параметров для запроса
		$data = array();
		// Попытка получить стоимость товара
		$data['CalculateTTN']['CalculateRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['CalculateTTN']['CalculateRequest']['CalculateTTN'] = array(
			'Sender' => array(
				'WarehouseSenderCode' => $this->sender_warehouse_code,
				'SettlementCode' => $this->sender_settlement_code,
				'PhoneSender' => $this->sender_phone,
			),
			'Receiver' => array(
				'ReceiverClient' => $this->receiver_client,
				'WarehouseReceiverCode' => $this->receiver_warehouse_code,
				'PhoneReceiver' => $this->receiver_phone,
				'SettlementCode' => $this->receiver_settlement_code,
			),
			'PaymentType' => $this->payment_type,
			'DispatchDate' => $this->dispatch_date,
			'POD' => array(
				'PodAmount' => $this->pod_amount,
			),
			'InsuranceCost' => $this->insurance_cost,
			'TransportationType' => $this->transportation_type,
			'PaymentMethod' => $this->payment_method,
			'PackagesTypeCode' => $this->packages_type_code,
			'PackageQuantity' => $this->package_quantity,
			'Cargo' => array(
				'CargoType' => $this->cargo_type,
				'CargoDescription' => $this->cargo_description,
			),
			'CargoParams' => array(
				'Quantity' => $this->quantity,
				'Weight' => $this->weight,
				'Volume' => $this->volume,
			),
		);
		$result = $this->intime_request("CalculateTTN", $data);
		return $result['Amount'];
	}

	/**
	 * Генерирование новых номеров ТТН
	 * 
	 * @param int $count Кол-во сгенерированных номеров для генерирования накладных, максимум 10 за 1 запрос
	 * @return array Массив сгенерированных номеров
	 */
	function reserve_numbers($count = 1) {
		$data['ReserveNumbers']['ReserveNumbersRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['ReserveNumbers']['ReserveNumbersRequest']['Quantity'] = (int) $count;
		$result = $this->intime_request("ReserveNumbers", $data);
		// $result['Number'] может быть как массив, так и string
		return (array) $result['Number'];
	}
	
	/**
	 * Создание заявки ТТН
	 * 
	 * @return string Состояние создания заявки
	 */
	public function add_ttn() {
		// Проверка необходимых полей и попытка получить значения пустых полей
		$this->_prepare_data(array('sender_warehouse_code', 'receiver_warehouse_code', 'quantity', 'weight', 'volume'));
		// Если нет номера накладной, то делается запрос на его генерацию 
		if ( ! $this->ttn_number) {
			$reserved_numbers = $this->reserve_numbers();
			if ( ! $reserved_numbers)
				throw new Exception('Не удалось сгенерировать номер накладной');
			$this->ttn_number = $reserved_numbers[0];
		}
		// Подготовка параметров для запроса
		$data = array();
		// Попытка получить номер ТТН
		$data['AddTTN']['AddRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['AddTTN']['AddRequest']['TTN'] = array(
			'Sender' => array(
				'WarehouseSenderCode' => $this->sender_warehouse_code,
				'SettlementCode' => $this->sender_settlement_code,
				'SenderAddress' => '',
				'PhoneSender' => $this->sender_phone,
			),
			'Receiver' => array(
				'ReceiverClient' => $this->receiver_client,
				'WarehouseReceiverCode' => $this->receiver_warehouse_code,
				'SettlementCode' => $this->receiver_settlement_code,
				'ReceiverAddress' => '',
				'PhoneReceiver' => $this->receiver_phone,
			),
			'Number' => $this->ttn_number,
			'PaymentType' => $this->payment_type,
			'DispatchDate' => $this->dispatch_date,
			'POD' => array(
				'PodPays' => $this->pod_payment_type,
				'PodAmount' => $this->pod_amount,
				/*
				'ReceiverPODThird' => array(
					'ReceiverPODThird' => '',
					'WarehouseReceiverPODThird' => '',
					'PhoneReceiverPODThird' => '',
				),
				*/
			),
			'ContractorPaysThird' => array(
				'ContractorPaysThird' => '',
				'WarehousePaysThird' => '',
				'PhonePaysThird' => '',
			),
			'InsuranceCost' => $this->insurance_cost,
			'TransportationType' => $this->transportation_type,
			'PaymentMethod' => $this->payment_method,
			'Packages' => array(
				'PackagesTypeCode' => $this->packages_type_code,
				'PackageQuantity' => 0,
			),
			'AdditionalServices' => array(
				'AdditionalServicesCode' =>  '',
				'AdditionalServicesParametr' => '',
			),
			'Cargo' => array(
				'CargoType' =>  $this->cargo_type,
				'CargoDescription' => $this->cargo_description,
			),
			'CargoParams' => array(
				'Quantity' => $this->quantity,
				'Weight' => $this->weight,
				'Volume' => $this->volume,
			),
			'CargoItems' => array(
				'CargoItemsCode' => '',
				'CargoItemsQuantity' => 0,
			),
			/*
			'ReservedField' => array(
				'ReservedFieldName' => '',
				'ReservedFieldVolume' => '',
			),
			*/
			'PAS' => '',
			'ReceiverCompany' => '',
			'SenderCompany' => $this->sender_company,
		);
		$result = $this->intime_request("AddTTN", $data);
		return $result;
	}

	/**
	 * Получение ссылки для печати этикеток
	 * 
	 * @return string URL файла этикеток для печати
	 */
	public function print_label() {
		// Подготовка параметров для запроса
		$data['PrintLabel']['GenerateLabelsRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['PrintLabel']['GenerateLabelsRequest']['Number'] = $this->ttn_number;
		$result = $this->intime_request("PrintLabel", $data);
		return $result['URL'];
	}
	
	/**
	 * Получение ссылки для печати заявки на ТТН
	 * 
	 * @return string URL
	 */
	public function print_ttn() {
		// Подготовка параметров для запроса
		$data['PrintTTN']['PrintTTNRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['PrintTTN']['PrintTTNRequest']['Number'] = $this->ttn_number;
		// Функция должна возвращать URL, но из-за ошибки на стороне сервиса возвращается
		try {
			$result = $this->intime_request("PrintTTN", $data);
		} catch (Exception $e) {
			$result['URL'] = $e->getMessage();
		}
		return $result['URL'];
	}
	
	/**
	 * Метод предназначен для печати заявки на ТТН в XML-формате (для формирования печатного документа).
	 * 
	 * @return string XML
	 */
	public function print_ttn_ext() {
		// Подготовка параметров для запроса
		$data['PrintTTNExt']['PrintTTNExtRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['PrintTTNExt']['PrintTTNExtRequest']['Number'] = $this->ttn_number;
		$result = $this->intime_request("PrintTTNExt", $data);
		return $result;
	}
	
}
?>