<?php
header('Content-Type: application/json; charset=utf-8');

if (!isset($_POST['phone'])) {
    echo json_encode(['success' => false, 'error' => 'Нет данных']);
    exit;
}

$phone = trim($_POST['phone']);

if (!preg_match('/^\+\d{11,18}$/', $phone)) {
    echo json_encode(['success' => false, 'error' => 'Неверный формат номера']);
    exit;
}

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