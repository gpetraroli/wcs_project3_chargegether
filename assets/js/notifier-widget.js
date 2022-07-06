setInterval(() => {
    fetch('/api/notifications/new')
        .then(data => data.json())
        .then(result => {
            if (result.length) {
                document.querySelectorAll('.notification-alert').forEach(el => {
                    el.classList.remove('d-none');
                });
            } else {
                document.querySelectorAll('.notification-alert').forEach(el => {
                    el.classList.add('d-none');
                });
            }
        });
}, 5000);
