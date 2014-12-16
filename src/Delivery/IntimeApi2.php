<?php
namespace LisDev\Delivery;
/**
 * Класс для работы с API 2.0 службы доставки Интайм (Украина)
 * 
 * @author lis-dev
 * @link http://www.intime.ua/API2.0/API_2_0.pdf
 * @link https://github.com/lis-dev/intime2
 */
class IntimeApi2 {
	// Идентефикатор пользователя
	public $id,
	// Ключ пользователя
	$key,
	// Область отправителя
	$senderRegion = '',
	// Город отправителя
	$senderCity = '',
	// Код населённого пункта отправителя, если в нем нет представительства
	$senderSettlementCode = '',
	// Адрес склада отправителя
	$senderAddress = '',
	// Телефон отправителя
	$senderPhone = '',
	// Код склада отправителя
	$senderWarehouseCode = '',
	// Название компании отправителя
	$senderCompany = '',
	// Область получателя
	$receiverRegion = '',
	// Город получателя
	$receiverCity = '',
	// Код населённого пункта получателя, если в нем нет представительства
	$receiverSettlementCode = '',
	// Адрес склада получателя
	$receiverAddress = '',
	// Телефон получателя
	$receiverPhone = '',
	// Получатель (ФИО)
	$receiverClient = '',
	// Код склада получателя
	$receiverWarehouseCode = '',
	
	// Тип оплаты отправителя ('OTP' - Отправитель, 'PNP' - Оплата 50 50, 'PRV' - Произвольно, 'OTL' - Оплата третьим лицом, 'POL' - Получатель)
	$paymentType = 'POL',
	
	// Тип оплаты пост-сервиса ('OTP' - Отправитель, 'POL' - Получатель)
	$podPaymentType = '',
	
	// Сумма пост-сервиса
	$podAmount = 0,
	
	// Дата отправки. Формат "2014-09-29+03:00"
	$dispatchDate = '',
	
	// Ценность (стоимость заказа)
	$insuranceCost = 200,
	
	// Код вида перевозки (01 - Дверь - Дверь, 02 - Дверь - Область, 03 - Дверь - Склад, 04 - Область - Дверь,
	// 05 - Область - Область, 06 - Область - Склад, 07 - Склад - Дверь, 08 - Склад - Область, 09 - Склад - Склад)
	$transportationType = '09',
	
	// Код метода оплаты (t|cash)
	$paymentMethod = 'cash',
	
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
	$packagesTypeCode = '00005',
	
	// Количество упаковок
	$packageQuantity = 0,

	// Кол-во мест
	$quantity = 0,
	// Вес, кг
	$weight = 0,
	// Объем, м3
	$volume = 0,
	// Тип груза 00131 - вещи, 00101 - быттехника, 00748 - спутниковое оборудование, 00788 - ТВ оборудование, 00811 - техника
	$cargoType = '00131',
	// Описание груза
	$cargoDescription = '',
	// Номер ТТН накладной
	$ttnNumber = '';
	
	// Список населенных пунктов, в которых нет представительства
	private static $_listOfSettlements = array(),
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
		$this->dispatchDate = date("Y-m-d+03:00");
		return $this;
	}
	
	/**
	 * Рекурсивное преобразование объекта в массив
	 * 
	 * @param mixed $var Массив, объект или строка
	 * @return mixed
	 */
	private function _toArray($var) {
		is_object($var) AND $var = (array) $var;
		if (is_array($var)) {
			foreach ($var as $key => $value) {
				is_object($value) AND $value = (array) $value;
				$var[$key] = $this->_toArray($value);
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
	public function request($method, $params) {
		$client = new \SoapClient("https://ws.intime.ua/API/ws/API20/?wsdl");
		// $response = $client->$method($params)->return;
		$response = $client->__soapCall($method, $params)->return;
		// $client->$function($data)->return;
		// Это не магия, здесь ok (eng) и ок (рус)
		if ( ! in_array($response->InterfaceState, array('OK', 'ОК', iconv('utf-8', 'cp1251', 'ОК'))))
			throw new \Exception($response->InterfaceState);
		$response = $this->_toArray($response);
		return $response;
	}
	
	/**
	 * Проверка и подготовка данных перед запросом
	 * 
	 * @param array $requiredFileds Массив обязательных полей
	 * @return bool
	 */
	private function _prepareData($requiredFileds) {
		// Попытка получить код склада отправителя 
		if (in_array('senderWarehouseCode', $requiredFileds) AND ! $this->senderWarehouseCode) {
			$this->senderWarehouseCode = $this->getDepartmentCode( (string) $this->senderCity, (string) $this->senderAddress);
			// Если нет склада отправителя, то попытка получить код населенного пункта
			if ( ! $this->senderWarehouseCode) {
				$this->senderSettlementCode = $this->getSettlementCode( (string) $this->senderCity, (string) $this->senderRegion);
				if ( ! $this->senderSettlementCode) {
					throw new \Exception("Не удалось определить ни код склада, ни код города отправителя");
				}
			}
		}
		// Попытка получить код склада получателя 
		if (in_array('receiverWarehouseCode', $requiredFileds) AND  ! $this->receiverWarehouseCode) {
			$this->receiverWarehouseCode = $this->getDepartmentCode( (string) $this->receiverCity, (string) $this->receiverAddress);
			if ( ! $this->receiverWarehouseCode) {
				$this->receiverSettlementCode = $this->getSettlementCode( (string) $this->receiverCity, (string) $this->receiverRegion);
				if ( ! $this->receiverSettlementCode) {
					throw new \Exception("Не удалось определить ни код склада, ни код города получателя");
				}
			}
		}
		if (in_array('quantity', $requiredFileds) AND  ! $this->quantity) {
			throw new \Exception("Не указано кол-во мест для груза");
		}
		
		if (in_array('weight', $requiredFileds) AND  ! $this->weight) {
			throw new \Exception("Не указан вес груза");
		}
		
		if (in_array('volume', $requiredFileds) AND  ! $this->volume) {
			throw new \Exception("Не указан объём груза");
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
	public function getSettlementCode($settlement, $region) {
		if ($settlement AND $region) {
			// Есть необходимость записать результат, т.к. размер передаваемого файла > 3M
			if ( ! self::$_listOfSettlements) {
				self::$_listOfSettlements = $this->catalogList('List of settlements');
			}
			// Поиск города и адреса
			foreach (self::$_listOfSettlements['ListCatalog']['Catalog'] as $settlementCurrent) {
				if (mb_stripos($settlementCurrent['Name'], $settlement) !== FALSE 
				AND (mb_stripos($settlementCurrent['AppendField'][0]['AppendFieldValue'], $region) !== FALSE 
				OR mb_stripos($settlementCurrent['AppendField'][1]['AppendFieldValue'], $region) !== FALSE)) {
					$settlementCode = $settlementCurrent['Code'];
					break;
				}
			}
		}
		return (string) $settlementCode;
	}
	
	/**
	 * Определение кода склада (отделения) по названию города и адресу отделения
	 * 
	 * @param string $city
	 * @param string $address
	 * @return string Code
	 */
	public function getDepartmentCode($city, $address) {
		if ($city AND $address) {
			// Есть необходимость записать результат, т.к. размер передаваемого файла > 500K
			( ! self::$_departments) AND self::$_departments = $this->catalogList('Departments');
			// Т.к. в адресах складов в некоторых случаях встречаются адреса без знаков препинания, то учитывается и этот вариант
			$addressShort = str_ireplace(array(' ', '.', ',', '-'), '', $address);
			// Поиск города и адреса
			foreach (self::$_departments['ListCatalog']['Catalog'] as $department) {
				$departmentAddress = $department['AppendField'][0]['AppendFieldValue'];
				$departmentAddressShort = str_ireplace(array(' ', '.', ',', '-'), '', $departmentAddress);
				if (mb_stripos($department['Name'], $city) !== FALSE AND (mb_stripos($departmentAddress, $address) !== FALSE OR mb_stripos($departmentAddressShort, $addressShort) !== FALSE)) {
					$warehouseCode = $department['Code'];
					break;
				}
			}
		}
		return (string) $warehouseCode;
	}

	/**
	 * Получение всеx названий справочников
	 * 
	 * @return array
	 */
	function allCatalog() {
		$data['AllCatalog']['AllСatalogRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$result = $this->request("AllCatalog", $data);
		return $result;
	}
	
	/**
	 * Получение каталога (справочника)
	 * 
	 * @param string $catalog Название каталога
	 * @return array Массив каталогов
	 */
	function catalogList($catalog) {
		$data['CatalogList']['CatalogListRequest']['AuthData'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['CatalogList']['CatalogListRequest']['CatalogNameEng'] = $catalog;
		$result = $this->request("CatalogList", $data);
		return $result;
	}
	
	/**
	 * Метод предназначен для расчета сроков доставки
	 * 
	 * @return string
	 */
	function deliveryDay() {
		// Проверка необходимых полей и попытка получить значения пустых полей
		$this->_prepareData(array('senderWarehouseCode', 'receiverWarehouseCode'));
		$data = array(
			'DeliveryDay' =>  array(
				'DayOfDeliveryRequest' => array(
					'AuthData' => array(
						'ID' => $this->id,
						'KEY' => $this->key,
					),
					'WarehouseSender' => $this->senderWarehouseCode,
					'WarehouseReceiver' => $this->receiverWarehouseCode,
					'SettlementCodeSender' => $this->senderSettlementCode,
					'SettlementCodeReceiver' => $this->receiverSettlementCode,
					// Дата отправки
					'Data' => $this->dispatchDate,
					'TransportationType' => $this->transportationType,
				),
			)
		);
		$result = $this->request("DeliveryDay", $data);
		return $result['DayOfDelivery'];
	}
	
	/**
	 * Получение стоимости товара
	 * 
	 * @return float Стоимость доставки
	 */
	public function calculateTTN() {
		// Проверка необходимых полей и попытка получить значения пустых полей
		$this->_prepareData(array('senderWarehouseCode', 'receiverWarehouseCode', 'quantity', 'weight', 'volume'));
		// Подготовка параметров для запроса
		$data = array();
		// Попытка получить стоимость товара
		$data['CalculateTTN']['CalculateRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['CalculateTTN']['CalculateRequest']['CalculateTTN'] = array(
			'Sender' => array(
				'WarehouseSenderCode' => $this->senderWarehouseCode,
				'SettlementCode' => $this->senderSettlementCode,
				'PhoneSender' => $this->senderPhone,
			),
			'Receiver' => array(
				'ReceiverClient' => $this->receiverClient,
				'WarehouseReceiverCode' => $this->receiverWarehouseCode,
				'PhoneReceiver' => $this->receiverPhone,
				'SettlementCode' => $this->receiverSettlementCode,
			),
			'PaymentType' => $this->paymentType,
			'DispatchDate' => $this->dispatchDate,
			'POD' => array(
				'PodAmount' => $this->podAmount,
			),
			'InsuranceCost' => $this->insuranceCost,
			'TransportationType' => $this->transportationType,
			'PaymentMethod' => $this->paymentMethod,
			'PackagesTypeCode' => $this->packagesTypeCode,
			'PackageQuantity' => $this->packageQuantity,
			'Cargo' => array(
				'CargoType' => $this->cargoType,
				'CargoDescription' => $this->cargoDescription,
			),
			'CargoParams' => array(
				'Quantity' => $this->quantity,
				'Weight' => $this->weight,
				'Volume' => $this->volume,
			),
		);
		$result = $this->request("CalculateTTN", $data);
		return $result['Amount'];
	}

	/**
	 * Генерирование новых номеров ТТН
	 * 
	 * @param int $count Кол-во сгенерированных номеров для генерирования накладных, максимум 10 за 1 запрос
	 * @return array Массив сгенерированных номеров
	 */
	function reserveNumbers($count = 1) {
		$data['ReserveNumbers']['ReserveNumbersRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['ReserveNumbers']['ReserveNumbersRequest']['Quantity'] = (int) $count;
		$result = $this->request("ReserveNumbers", $data);
		// $result['Number'] может быть как массив, так и string
		return (array) $result['Number'];
	}
	
	/**
	 * Создание заявки ТТН
	 * 
	 * @return string Состояние создания заявки
	 */
	public function addTTN() {
		// Проверка необходимых полей и попытка получить значения пустых полей
		$this->_prepareData(array('senderWarehouseCode', 'receiverWarehouseCode', 'quantity', 'weight', 'volume'));
		// Если нет номера накладной, то делается запрос на его генерацию 
		if ( ! $this->ttnNumber) {
			$reservedNumbers = $this->reserveNumbers();
			if ( ! $reservedNumbers)
				throw new \Exception('Не удалось сгенерировать номер накладной');
			$this->ttnNumber = $reservedNumbers[0];
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
				'WarehouseSenderCode' => $this->senderWarehouseCode,
				'SettlementCode' => $this->senderSettlementCode,
				'SenderAddress' => '',
				'PhoneSender' => $this->senderPhone,
			),
			'Receiver' => array(
				'ReceiverClient' => $this->receiverClient,
				'WarehouseReceiverCode' => $this->receiverWarehouseCode,
				'SettlementCode' => $this->receiverSettlementCode,
				'ReceiverAddress' => '',
				'PhoneReceiver' => $this->receiverPhone,
			),
			'Number' => $this->ttnNumber,
			'PaymentType' => $this->paymentType,
			'DispatchDate' => $this->dispatchDate,
			'POD' => array(
				'PodPays' => $this->podPaymentType,
				'PodAmount' => $this->podAmount,
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
			'InsuranceCost' => $this->insuranceCost,
			'TransportationType' => $this->transportationType,
			'PaymentMethod' => $this->paymentMethod,
			'Packages' => array(
				'PackagesTypeCode' => $this->packagesTypeCode,
				'PackageQuantity' => 0,
			),
			'AdditionalServices' => array(
				'AdditionalServicesCode' =>  '',
				'AdditionalServicesParametr' => '',
			),
			'Cargo' => array(
				'CargoType' =>  $this->cargoType,
				'CargoDescription' => $this->cargoDescription,
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
			'SenderCompany' => $this->senderCompany,
		);
		$result = $this->request("AddTTN", $data);
		return $result;
	}

	/**
	 * Получение ссылки для печати этикеток
	 * 
	 * @return string URL файла этикеток для печати
	 */
	public function printLabel() {
		// Подготовка параметров для запроса
		$data['PrintLabel']['GenerateLabelsRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['PrintLabel']['GenerateLabelsRequest']['Number'] = $this->ttnNumber;
		$result = $this->request("PrintLabel", $data);
		return $result['URL'];
	}
	
	/**
	 * Получение ссылки для печати заявки на ТТН
	 * 
	 * @return string URL
	 */
	public function printTTN() {
		// Подготовка параметров для запроса
		$data['PrintTTN']['PrintTTNRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['PrintTTN']['PrintTTNRequest']['Number'] = $this->ttnNumber;
		// Функция должна возвращать URL, но из-за ошибки на стороне сервиса возвращается
		try {
			$result = $this->request("PrintTTN", $data);
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
	public function printTTNExt() {
		// Подготовка параметров для запроса
		$data['PrintTTNExt']['PrintTTNExtRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['PrintTTNExt']['PrintTTNExtRequest']['Number'] = $this->ttnNumber;
		$result = $this->request("PrintTTNExt", $data);
		return $result;
	}
	
	/**
	 * Получение информации о конкретной ТТН
	 * 
	 * @return array
	 */
	public function infoTTN() {
		// Подготовка параметров для запроса
		$data['InfoTTN']['InfoTTNRequest']['Auth'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['InfoTTN']['InfoTTNRequest']['Number'] = $this->ttnNumber;
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'Ves');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'VidPerevozki');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'PlatelchikObratnoyPS');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'GorodOtpravitel');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'GorodPoluchatel');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'Data');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'Obem');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'OpisanieGruza');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'Oplachivaet');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'Otpravitel');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'PlatelchikTreteeLico');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'Poluchatel');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'Summa');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'Viezd');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'GorodPoluchatelPSTretelico');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'Dostavka');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'KolvoMest');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'OpisanieGruza');
		$data['InfoTTN']['InfoTTNRequest']['InformationField'][] = array('InformationName' => 'PostService');
		$result = $this->request("InfoTTN", $data);
		return $result;
	}

	/**
	 * Удаление ТТН
	 * 
	 * @return array
	 */
	public function deleteTTN() {
		if ( ! $this->ttnNumber) 
			throw new \Exception("Не указан номер ТТН");
		// Подготовка параметров для запроса
		$data['DeleteTTN']['DeleteRequest']['AuthData'] = array(
			'ID' => $this->id,
			'KEY' => $this->key,
		);
		$data['DeleteTTN']['DeleteRequest']['NumberTTN'] = $this->ttnNumber;
		$result = $this->request("DeleteTTN", $data);
		return $result;
	}
}
?>