<?php
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');

$phone = isset($_POST['phone']) ? trim($_POST['phone']) : null;

if (!$phone) {
    echo json_encode(['success' => false, 'error' => 'Нет данных']);
    exit;
}

$prefixes = [
    '+373' => ['country' => 'Молдова / Приднестровье', 'length' => 12],
    '+7'   => ['country' => 'Россия / Казахстан', 'length' => 12],
    '+380' => ['country' => 'Украина', 'length' => 13],
    '+1'   => ['country' => 'США/Канада', 'length' => 13],
    '+44'  => ['country' => 'Великобритания', 'length' => 14],
    '+49'  => ['country' => 'Германия', 'length' => 14],
    '+40'  => ['country' => 'Румыния', 'length' => 13]
];

$country = 'Неизвестная страна';
$validLength = null;

foreach ($prefixes as $code => $info) {
    if (strpos($phone, $code) === 0) {
        $country = $info['country'];
        $validLength = $info['length'];
        break;
    }
}

if ($country === 'Неизвестная страна') {
    echo json_encode(['success' => false, 'error' => 'Неизвестный код страны']);
    exit;
}


if (strlen($phone) !== $validLength) {
    echo json_encode(['success' => false, 'error' => "Неверное количество цифр для $country"]);
    exit;
}

if (!preg_match('/^\+\d+$/', $phone)) {
    echo json_encode(['success' => false, 'error' => 'Номер содержит недопустимые символы']);
    exit;
}

echo json_encode(['success' => true, 'country' => $country]);
