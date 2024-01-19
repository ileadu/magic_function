<?php
require 'Address.php';

/**
 *  PHP Magic
 *
 * 了解 PHP 魔術方法的實際範例
 * @see https://medium.com/@erlandmuchasaj/php-magic-0ae9e9b5442c
 */

// 步驟 1: 創建 Address 類的新實例
$address = new Address('內湖區瑞光路', '台北市', '台灣', 114);

var_dump($address);
// 步驟 2: 使用魔術方法 __toString 將完整地址以字串形式輸出
echo "Full address as string: {$address}" . PHP_EOL;
echo PHP_EOL;
// 步驟 3: 使用魔術方法 __set 更新街道屬性
// No magic method called.
$address->street = '三重區集美街';

// 步驟 4: 使用魔術方法 __set 更新城市屬性
// Access properties using __set since is protected
$address->city = '新北市';

// 步驟 5: 使用魔術方法 __get 輸出城市屬性
// Access properties using __get
echo "City: {$address->city} " . PHP_EOL;
echo PHP_EOL;

// 步驟 6: 使用魔術方法 __isset 檢查郵遞區號屬性是否設定
// Check if a property is set using __isset
echo 'check Zip if set: ' . (isset($address->zip) ? 'Y' : 'N') . PHP_EOL;
echo PHP_EOL;

// 步驟 7: 使用魔術方法 __toString 將完整地址以字串形式輸出
// Convert the object to a string using __toString
echo "Full address as string: {$address}" . PHP_EOL;
echo PHP_EOL;

// 步驟 8: 使用魔術方法 __unset 解除設定郵遞區號屬性
// Unset a property using __unset
unset($address->zip);
echo 'check Zip if set: ' . (isset($address->zip) ? 'Y' : 'N') . PHP_EOL;
echo PHP_EOL;

// 步驟 9: 使用魔術方法 __sleep 對物件進行序列化
// Set object properties using __sleep
$serialized = serialize($address);
echo "Object address serialized: $serialized" . PHP_EOL;
echo PHP_EOL;

# 步驟 9b: 反序列化物件
$address = unserialize($serialized);
echo "Serialized address unserialized: $address" . PHP_EOL;
echo PHP_EOL;

// 步驟 10: 使用魔術方法 __call 呼叫 format 方法
// Call a method using __call
echo "Formatted address:" . $address->format() . PHP_EOL;
echo PHP_EOL;

// 步驟 11: 使用魔術方法 __callStatic 呼叫 getDefaultAddress 靜態方法
// Call a static method using __callStatic
$defaultAddress = Address::getDefaultAddress(1);
echo "Default Address: {$defaultAddress}" . PHP_EOL;
echo PHP_EOL;

// 步驟 12: 使用魔術方法 __clone 複製物件
// Call __clone method of object.
$newAddress = clone $address;
echo "Full newAddress after clone as string: {$newAddress}" . PHP_EOL;
echo PHP_EOL;

var_dump($address);
var_dump($newAddress);
// 步驟 13: 使用魔術方法 __invoke 呼叫物件本身作為函式
$newAddress();
echo PHP_EOL;

// 步驟 14: 使用魔術方法 __set 更新街道屬性
// No magic method called.
$newAddress->street = '神岡區中山路';

// 步驟 15: 使用魔術方法 __set 更新城市屬性
// Access properties using __set since is protected
$newAddress->city = '台中市';

var_dump($newAddress);
echo "Full newAddress after reset as string: {$newAddress}" . PHP_EOL;
echo PHP_EOL;

//最後三個 __destruct 是因為 new 一次，clone 一次，又new 一次（在__callStatic裡面）