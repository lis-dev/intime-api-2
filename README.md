# Описание
PHP класс для работы с API украинской службы доставки Интайм через SOAP протокол

# Необходимые требования
На сервере должен быть установелен PHP версии не ниже 5.2.6, расширение для работы SOAP и openssl (т.к. запросы будут идти через защещенный протокол)

# Реализованные функции API
* AllCatalog
* CatalogList
* DeliveryDay
* CalculateTTN
* ReserveNumbers
* AddTTN
* PrintLabel
* PrintTTN
* PrintTTNExt
* InfoTTN
* DeleteTTN