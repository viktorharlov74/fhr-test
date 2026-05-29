<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Выгрузка пользователей</title>
    <link rel="stylesheet" href="/css/export.css">
</head>
<body>

<h1>Выгрузка пользователей</h1>

<div class="card">
    <div class="card-row">
        <span class="card-label">Источник</span>
        <span class="card-value">таблица person</span>
    </div>
    <div class="card-row">
        <span class="card-label">Формат</span>
        <span class="card-value">CSV</span>
    </div>
    <div class="card-row">
        <span class="card-label">Поля</span>
        <span class="card-value fields">
            <label class="field-check"><input type="checkbox" name="fields" value="last_name"  checked> Фамилия</label>
            <label class="field-check"><input type="checkbox" name="fields" value="first_name" checked> Имя</label>
            <label class="field-check"><input type="checkbox" name="fields" value="phone"      checked> Телефон</label>
            <label class="field-check"><input type="checkbox" name="fields" value="email"      checked> E-mail</label>
        </span>
    </div>
    <div class="card-row">
        <span class="card-label">Количество</span>
        <span class="card-value">
            <input type="number" id="exportCount" value="500000" min="1" max="500000">
        </span>
    </div>
</div>

<button id="exportBtn">Выгрузить пользователей</button>

<div id="exportProgress">
    <p id="exportStatus"></p>
    <div class="progress-track">
        <div id="exportBar"></div>
    </div>
</div>

<script src="/js/export.js"></script>
</body>
</html>
