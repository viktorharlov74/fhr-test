<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Пузырьковая сортировка</title>
    <link rel="stylesheet" href="/css/sorting.css">
</head>
<body>

<h1>Пузырьковая сортировка</h1>

@if (session('success'))
    <p class="success">{{ session('success') }}</p>
@endif

@if (!empty($missingFile))

    <p class="error">Файл данных не найден.</p>
    <form method="POST" action="{{ route('sorting.generate') }}">
        @csrf
        <label>Сгенерировать чисел:
            <input type="number" name="count" value="200000" min="1" max="1000000">
        </label>
        <button type="submit">Сгенерировать</button>
    </form>

@else

    <section>
        <h2>Первые 20 элементов из файла <span class="filename">{{ $fileName }}</span></h2>
        <p class="numbers">{{ implode(', ', $preview) }}</p>
    </section>

    <section>
        <h2>Сортировка</h2>
        <form method="GET">
            <label>Количество элементов:
                <input type="number" name="count" value="{{ request('count', 1000) }}" min="1" max="50000">
            </label>
            <button type="submit">Сортировать</button>
        </form>
    </section>

    @isset($before)
        <section>
            <h2>До сортировки ({{ $count }} эл.)</h2>
            <div class="numbers-block">{{ implode(', ', $before) }}</div>
        </section>

        <section>
            <h2>После сортировки</h2>
            <div class="numbers-block">{{ implode(', ', $after) }}</div>
        </section>

        <section class="stats">
            <p><strong>Время:</strong> {{ $timeMs }} мс</p>
            <p><strong>Память (сортировка):</strong> {{ $memoryBytes }} байт</p>
        </section>
    @endisset

@endif

</body>
</html>