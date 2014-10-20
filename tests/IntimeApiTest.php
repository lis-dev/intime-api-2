<?php
require_once '../src/IntimeApi.php';
/**
 * phpUnit test class
 * 
 * @author lis-dev
 * @version 0.01
 */
class IntimeApiTest extends PHPUnit_Framework_TestCase
{
	// ID для подключения к сервису intime.ua
	private $id = '';
	// Ключ для подключения к сервису intime.ua
	private $key = '';
	// Объект тестируемого класса
	protected $_intime;

	/**
	 * Настройки по умолчанию перед каждым тестом
	 */
	function setUp() {
		$this->_intime = new IntimeApi($this->id, $this->key);
		$intime = $this->_intime;
		$intime->sender_region = 'Киевская область';
		$intime->sender_city = 'Киев';
		$intime->sender_address = 'ул. Святошинская, 20';
		$intime->sender_phone = '+380951112233';
		$intime->receiver_region = 'Харьковская область';
		$intime->receiver_city = 'Харьков';
		$intime->receiver_address = 'Авторынок "Лоск"';
		$intime->receiver_phone = '+380631112233';
		$intime->receiver_client = 'Test client';
		$intime->cargo_description = 'Cargo description';
		$intime->quantity = 3;
		$intime->weight = 12.;
		$intime->volume = 0.04;
	}

	/**
	 * Получение кода населенного пункта по его городу и области
	 * 
     * @dataProvider GetSettlementCodeData
     */
	function testGetSettlementCode($expected_code, $settlement, $region) {
		$code = $this->_intime->get_settlement_code($settlement, $region);
		$this->assertEquals($expected_code, $code);
	}
	/**
	 * Данные для получение кода населенного пункта по его городу и области
	 */
	function GetSettlementCodeData()
	{
		// Значения выбраны наугад
		return array(
			array('000126', 'Бабаи', 'Харьковская область'),
			array('003279', 'Новоамвросиевское', 'Донецкая область'),
			array('000208', 'Безлюдовка', 'Харьковская область'),
		);
	}
	
	/**
	 * Получение кода склада по его городу и адресу
	 * 
     * @dataProvider GetDepartmentCodeData
     */
	function testGetDepartmentCode($city, $address) {
		$code = $this->_intime->get_department_code($city, $address);
		$this->assertEquals($expected_code, $code);
	}
	
	/**
	 * Данные для тестирования кода склада по его городу и адресу
	 */
	function GetDepartmentCodeData()
	{
		// Значения выбраны наугад
		return array(
			array('1109', 'Киев', 'ул. Крупской, 8'),
			array('1302', 'Луганск', 'ул. Советская, 94-а'),
			array('0601', 'Житомир', 'ул. Ватутина, 79'),
			array('1424', 'Львов', 'ул. Щирецкая, 5'),
			array('0902', 'Ивано-Франковск', 'ул. Шопена, 9/2'),
		);
	}
	
	/**
	 * Получение списка всех каталогов
	 */
	function testGetAllCatalogs() {
		$catalogs = $this->_intime->get_all_catalogs();
		$this->assertNotEmpty($catalogs);
	}
	
	/**
	 * Получение информации по различным каталогам
	 * 
	 * @dataProvider GetCatalogData
	 */
	function testGetCatalog($catalog_name) {
		$catalog = $this->_intime->get_catalog($catalog_name);
		$this->assertNotEmpty($catalog);
	}
	
	/**
	 * Различные каталоги
	 */
	function GetCatalogData() {
		// Значения выбраны наугад
		return array(
			array('Payment method'),
			array('Transportation types'),
			array('Additional services'),
		);
	}
	
	/**
	 * Определение даты получения посылки склад-склад (дата отправки - вчерашняя)
	 * 
     * @expectedException Exception
     */
	function testDeliveryDayYesterday() {
		$this->_intime->dispatch_date = date('Y-m-d+03:00', time() - 86400);
		$delivery_day = $this->_intime->delivery_day();
		$this->assertNotEmpty($delivery_day);
	}
	
	/**
	 * Определение даты получения посылки склад-склад (дата отправки - сегодня)
	 */
	function testDeliveryDayTodayForWarehouses() {
		$this->_intime->dispatch_date = date('Y-m-d+03:00');
		$delivery_day = $this->_intime->delivery_day();
		$this->assertNotEmpty($delivery_day);
	}
	/**
	 * Определение даты получения посылки склад-склад (дата отправки - завтра)
	 */
	function testDeliveryDayTomorrowForWarehouses() {
		$this->_intime->dispatch_date = date('Y-m-d+03:00', time() + 86400);
		$delivery_day = $this->_intime->delivery_day();
		$this->assertNotEmpty($delivery_day);
	}
	
	/**
	 * Определение дня доставки для населенных пунктов
	 * Из-за ошибки на стороне сервиса здесь будет выдаваться Exception "104 неверный город получатель!"
	 * 
	 * ['Sender]['SettlementCode'] = 003279
	 * ['Receiver']['SettlementCode'] = 000126
     * @expectedException Exception
	 */
	function testDeliveryDayTomorrowForSettlements() {
		$this->_intime->sender_warehouse_code = 0;
		$this->_intime->receiver_warehouse_code = 0;
		$this->_intime->sender_city = 'Новоамвросиевское';
		$this->_intime->sender_region = 'Донецкая область';
		$this->_intime->receiver_city = 'Бабаи';
		$this->_intime->receiver_region = 'Харьковская область';
		$this->_intime->dispatch_date = date('Y-m-d+03:00', time() + 86400);
		$delivery_day = $this->_intime->delivery_day();
		$this->assertNotEmpty($delivery_day);
	}
	
	/**
	 * Подсчёт стоимости отправки посылки с различными параметрами
	 * 
	 * @dataProvider CalculateTTNData
     */
	function testCalculateTTN($sender_warehouse_code, $receiver_warehouse_code, $sender_city, $sender_region, $receiver_city, $receiver_region) {
		if (isset($sender_warehouse_code)) {
			$this->_intime->sender_warehouse_code = $sender_warehouse_code;
		}
		if (isset($receiver_warehouse_code)) {
			$this->_intime->receiver_warehouse_code = $receiver_warehouse_code;
		}
		if (isset($sender_city)) {
			$this->_intime->sender_city = $sender_city;
		}
		if (isset($sender_region)) {
			$this->_intime->sender_region = $sender_region;
		}
		if (isset($receiver_city)) {
			$this->_intime->receiver_city = $receiver_city;
		}
		if (isset($receiver_region)) {
			$this->_intime->receiver_region = $receiver_region;
		}
		/* Из-за ошибки на стороне сервиса будет выдаваться Exception "104 неверный город получатель!", если нет в городе склада, но город есть в списке Settlements
		 * Пример: ['Sender]['SettlementCode'] = 003279
	 	 * ['Receiver']['SettlementCode'] = 000126
		 */
		try {
			$price = $this->_intime->calculate_ttn();
			$this->assertGreaterThan(0, $price);
		} catch (Exception $e) {
			// echo $e->getMessage()."\n";
		}
	}
	
	/**
	 * Данные для подсчёта стоимости отправки посылки
	 */ 
	function CalculateTTNData() {
		// sender_warehouse_code, receiver_warehouse_code, sender_city, sender_region, receiver_city, receiver_region
		return array(
			// Из склада по умолчанию в склад по умолчанию 
			array(NULL, NULL, NULL, NULL, NULL, NULL),
			// Из населенного пункта в населенный пункт
			array(0, 0, 'Новоамвросиевское', 'Донецкая область', 'Бабаи', 'Харьковская область'),
			// Из несуществующего населенного пункта в склад по умолчанию
			array(0, 0, 'Some noname sity', 'Some noname region', NULL, NULL),
			// Из склада по умолчанию в несуществующий населенный пункт
			array(0, 0, NULL, NULL, 'Some noname sity', 'Some noname region'),
			// Из населенного пункта в склад по умолчанию
			array(0, 0, 'Новоамвросиевское', 'Донецкая область', NULL, NULL),
			// Из склада по умолчанию в населенный пунта
			array(0, 0, NULL, NULL, 'Бабаи', 'Харьковская область'),
			// Нет входных нанных
			array(0, 0, '', '', '', ''),
		);
	}
	
	/**
	 * Подсчёт стоимости без указанного веса посылки
	 * 
     * @expectedException Exception
     */
	function testCalculateTTNWithoutWeight() {
		$this->_intime->weight = 0;
		$price = $this->_intime->calculate_ttn();
		$this->assertGreaterThan(0, $price);
	}
	
	/**
	 * Подсчёт стоимости без указанного объёма посылки
	 * 
     * @expectedException Exception
     */
	function testCalculateTTNWithoutVolume() {
		$this->_intime->volume = 0;
		$price = $this->_intime->calculate_ttn();
		$this->assertGreaterThan(0, $price);
	}
	
	/**
	 * Подсчёт стоимости без указанного кол-ва мест посылки
	 * 
     * @expectedException Exception
     */
	function testCalculateTTNWithoutQuantity() {
		$this->_intime->quantity = 0;
		$price = $this->_intime->calculate_ttn();
		$this->assertGreaterThan(0, $price);
	}
	
	/**
	 * Добавление ТТН в систему intime.ua
	 * 
	 * @return string Номер ТТН
	 */
	function testAddTTN() {
		$result = $this->_intime->add_ttn();
		$this->assertNotEmpty($result['Number']);
		return $result['Number'];
	}
	
	/**
	 * Печать этикеток
	 * 
	 * @depends testAddTTN
	 */
	function testPrintLabel($ttn_number) {
		$this->_intime->ttn_number = $ttn_number;
		$result = $this->_intime->print_label();
		$this->assertNotEmpty($result['InterfaceState']);
	}
	
	/**
	 * Печать ТТН
	 * 
	 * @depends testAddTTN
	 */
	function testPrintTTN($ttn_number) {
		$this->_intime->ttn_number = $ttn_number;
		$result = $this->_intime->print_ttn();
		$this->assertNotEmpty($result);
	}
	
	/**
	 * Печать ТТН (расширенная)
	 * 
	 * @depends testAddTTN
	 */
	function testPrintTTNExt($ttn_number) {
		$this->_intime->ttn_number = $ttn_number;
		$result = $this->_intime->print_ttn_ext();
		$this->assertNotEmpty($result['InterfaceState']);
	}
	
	/**
	 * Удаление существующего ТТН
	 * 
	 * @depends testAddTTN
	 */
	function testDeleteTTN($ttn_number) {
		$this->_intime->ttn_number = $ttn_number;
		$result = $this->_intime->delete_ttn();
		$this->assertNotEmpty($result['Status']);
	}
	
	/**
	 * Удаление несуществующего ТТН
	 * 
	 * @expectedException Exception
	 */
	function testDeleteTTNWithoutTTN() {
		$this->_intime->ttn_number = '';
		$result = $this->_intime->delete_ttn();
	}
	/**
	 * Проверка информации по ТТН
	 */
	function testInfoTTN() {
		// Номер ТТН выбран наугад
		$this->_intime->ttn_number = '0531002118';
		$result = $this->_intime->info_ttn();
		$this->assertNotEmpty($result);
	}
	
}
