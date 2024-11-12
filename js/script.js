// created by Simon MELIK-KAZARYAN

// Перевірка форми перед її відправленням
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const name = document.getElementById('name').value;
            const phone = document.getElementById('phone').value;
            if (name.trim() === '' || phone.trim() === '') {
                alert('Будь ласка, заповніть всі поля!');
                e.preventDefault();
            }
        });
    }
});
