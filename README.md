# Hunting Bookings Module for BookingCore

## Описание
Модуль добавляет функциональность бронирования охотничьих туров с выбором гида. Включает миграции, модели, контроллеры, API-эндпоинты и бизнес-валидацию.

---

## Интеграция в BookingCore

### 1. Размещение кода
Поместите модуль в каталог проекта BookingCore, например:
```bash
modules/
  HuntingBookings/
    Http/
      Controllers/
      Requests/
      Resources/
    Models/
    Database/
      migrations/
```

---

### 2. Подключение маршрутов
Внутри `routes/api.php`:
```php
use App\Http\Controllers\Api\GuideController;
use App\Http\Controllers\Api\BookingController;

Route::get('guides', [GuideController::class, 'index']);
Route::post('bookings', [BookingController::class, 'store']);
```

---

### 3. Авторизация и middleware
При необходимости ограничьте доступ к API:
```php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('guides', [GuideController::class, 'index']);
    Route::post('bookings', [BookingController::class, 'store']);
});
```

---

### 4. Миграции и деплой
После интеграции выполните:
```bash
php artisan migrate
```
Добавьте миграции модуля в CI/CD pipeline BookingCore.

---

### 5. Мониторинг и масштабирование
- Подключите логирование и метрики (например, через OpenTelemetry или Laravel Telescope).
- Для предотвращения гонок при параллельных бронированиях используется уникальный индекс `(guide_id, date)` и транзакции.

---

## Примеры API
- **GET** `/api/guides?min_experience=3` — список активных гидов.
- **POST** `/api/bookings` — создание нового бронирования.

Пример тела запроса:
```json
{
  "tour_name": "Лосиный заказник",
  "hunter_name": "Иван",
  "guide_id": 1,
  "date": "2025-12-01",
  "participants_count": 5
}
```

---

## Коды ответов
| Код | Описание |
|------|-----------|
| 200 | Успешный запрос |
| 201 | Бронирование создано |
| 409 | Гид уже занят на эту дату |
| 422 | Ошибка валидации |

---

## Тестирование и CI/CD
Для запуска тестов модуля в контексте BookingCore:
```bash
php artisan test --filter=BookingTest
```
Добавьте этот шаг в ваш `.gitlab-ci.yml` или GitHub Actions workflow, чтобы тесты модуля прогонялись вместе с основными.

---

### DDD-интеграция модуля Hunting Bookings
Архитектурные принципы (Ветка BC-1)
- Домен = контракты + сервисы + события + (по желанию) DTO.
- Инфраструктура = Eloquent‑реализации репозиториев, модели, миграции.
- Application (use‑cases) = Actions, которые оркестрируют вызовы доменных сервисов (и транзакции).
- Interfaces = HTTP‑слой (контроллеры, FormRequest, Resources).
- Поток создания бронирования: Controller → Action → Domain Service → Repository → Eloquent.

---

## Итого
Модуль интегрируется в BookingCore как самостоятельный пакет с собственными миграциями и маршрутами. Полностью совместим с **Laravel 11**, поддерживает расширение и авторизацию через существующую инфраструктуру BookingCore.
