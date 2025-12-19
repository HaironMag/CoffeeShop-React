<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== БЫСТРОЕ ИСПРАВЛЕНИЕ COFFEE SHOP ===\n\n";

// 1. Создать таблицы если не существуют
echo "1. Создание таблиц...\n";

try {
    // Таблица size_coffees
    DB::statement("
        CREATE TABLE IF NOT EXISTS size_coffees (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            ml INT NOT NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        ) ENGINE=InnoDB
    ");
    echo "   ✓ Таблица size_coffees создана/проверена\n";
} catch (Exception $e) {
    echo "   ✗ Ошибка создания size_coffees: " . $e->getMessage() . "\n";
}

try {
    // Таблица coffees
    DB::statement("
        CREATE TABLE IF NOT EXISTS coffees (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT NULL,
            base_price DECIMAL(8,2) DEFAULT 0.00,
            size_id BIGINT UNSIGNED NOT NULL,
            image LONGTEXT NULL,
            available TINYINT(1) DEFAULT 1,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            FOREIGN KEY (size_id) REFERENCES size_coffees(id) ON DELETE CASCADE
        ) ENGINE=InnoDB
    ");
    echo "   ✓ Таблица coffees создана/проверена\n";
} catch (Exception $e) {
    echo "   ✗ Ошибка создания coffees: " . $e->getMessage() . "\n";
}

// 2. Очистить таблицы
echo "\n2. Очистка таблиц...\n";
try {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    DB::table('coffees')->truncate();
    DB::table('size_coffees')->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');
    echo "   ✓ Таблицы очищены\n";
} catch (Exception $e) {
    echo "   ℹ Ошибка очистки (возможно таблицы пусты): " . $e->getMessage() . "\n";
}

// 3. Заполнить размеры
echo "\n3. Заполнение размеров...\n";
try {
    DB::table('size_coffees')->insert([
        ['name' => 'Small', 'size' => 150],
        ['name' => 'Medium', 'size' => 250],
        ['name' => 'Large', 'size' => 500]
    ]);
    echo "   ✓ 3 размера добавлены\n";
} catch (Exception $e) {
    echo "   ✗ Ошибка добавления размеров: " . $e->getMessage() . "\n";
}

// 4. Заполнить кофе
echo "\n4. Заполнение кофе...\n";
try {
    DB::table('coffees')->insert([
        [
            'name' => 'Эспрессо',
            'description' => 'Крепкий и согревающий ваш день.',
            'base_price' => 250.00,
            'size_id' => 1,
            'image' => '',
            'available' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Латте',
            'description' => 'Молочный и мягкий, подходит для согревания души.',
            'base_price' => 500.00,
            'size_id' => 2,
            'image' => '',
            'available' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Какао с Маршмэллоу',
            'description' => 'Мягкое маршмэллоу в сливочном аромате какао',
            'base_price' => 250.00,
            'size_id' => 3,
            'image' => '',
            'available' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Americano',
            'description' => 'Espresso with hot water.',
            'base_price' => 300.00,
            'size_id' => 2,
            'image' => '',
            'available' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Mocha',
            'description' => 'Chocolate, espresso and steamed milk.',
            'base_price' => 550.00,
            'size_id' => 3,
            'image' => '',
            'available' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ],
    ]);
    echo "   ✓ 5 видов кофе добавлены\n";
} catch (Exception $e) {
    echo "   ✗ Ошибка добавления кофе: " . $e->getMessage() . "\n";
}

// 5. Проверить данные
echo "\n5. Проверка данных...\n";
$sizes = DB::table('size_coffees')->count();
$coffees = DB::table('coffees')->count();

echo "   Размеров: {$sizes}\n";
echo "   Кофе: {$coffees}\n";

if ($sizes == 3 && $coffees == 5) {
    echo "   ✓ Данные корректны\n";
} else {
    echo "   ✗ Данные неполные\n";
}

// 6. Простой тест API
echo "\n6. Тест API...\n";
try {
    $result = DB::table('coffees')
        ->join('size_coffees', 'coffees.size_id', '=', 'size_coffees.id')
        ->select('coffees.id', 'coffees.name', 'coffees.base_price', 'size_coffees.name as size')
        ->get();
    
    echo "   Получено записей: " . $result->count() . "\n";
    
    foreach ($result as $item) {
        echo "   - {$item->name} ({$item->base_price} ₸, размер: {$item->size})\n";
    }
} catch (Exception $e) {
    echo "   ✗ Ошибка теста: " . $e->getMessage() . "\n";
}

echo "\n=== ГОТОВО ===\n";
echo "\nЗапустите сервер: php artisan serve\n";
echo "Проверьте API: http://localhost:8000/api/coffee\n";