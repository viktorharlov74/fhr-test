document.getElementById('exportBtn').addEventListener('click', async function () {
    const btn = this;
    const status = document.getElementById('exportStatus');
    const progress = document.getElementById('exportProgress');
    const bar = document.getElementById('exportBar');

    btn.disabled = true;
    status.textContent = 'Инициализация...';
    progress.style.display = 'block';

    const count = document.getElementById('exportCount').value;
    const fields = Array.from(document.querySelectorAll('input[name="fields"]:checked')).map(el => el.value);

    if (fields.length === 0) {
        status.textContent = 'Выберите хотя бы одно поле.';
        btn.disabled = false;
        return;
    }

    const startRes = await fetch('/export/start', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({count, fields: fields.join(',')}),
    });
    const {export_id, total, fields: exportFields} = await startRes.json();

    let lastId = 0;
    let remaining = total;
    let processed = 0;

    while (remaining > 0) {
        const res = await fetch('/export/chunk', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({export_id, last_id: lastId, remaining, fields: exportFields}),
        });

        const data = await res.json();

        lastId = data.last_id;
        remaining = data.remaining;
        processed += data.processed;

        const percent = Math.round((processed / total) * 100);
        bar.style.width = percent + '%';
        status.textContent = `Обработано: ${processed} из ${total}`;
    }

    status.textContent = 'Готово! Скачивание...';
    window.location.href = `/export/download/${export_id}`;
    btn.disabled = false;
});
