<?php
header('Content-Type: application/json; charset=utf-8');

if (!isset($_POST['phone'])) {
    echo json_encode(['success' => false, 'error' => 'Нет данных']);
    exit;
}

$phone = trim($_POST['phone']);

// Простая проверка — номер должен начинаться с "+" и содержать 8–15 цифр
if (!preg_match('/^\+\d{8,15}$/', $phone)) {
    echo json_encode(['success' => false, 'error' => 'Неверный формат номера']);
    exit;
}

// Определение страны по коду (можно расширять)
$prefixes = [
    '+373' => 'Молдова',
    '+7'   => 'Россия/Казахстан',
    '+380' => 'Украина',
    '+1'   => 'США/Канада',
    '+44'  => 'Великобритания',
    '+49'  => 'Германия',
    '+40'  => 'Румыния'
];

$country = 'Неизвестная страна';
foreach ($prefixes as $code => $name) {
    if (strpos($phone, $code) === 0) {
        $country = $name;
        break;
    }
}

echo json_encode(['success' => true, 'country' => $country]);