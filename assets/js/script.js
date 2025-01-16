/* script.js */
document.addEventListener('DOMContentLoaded', function() {
    if (document.cookie.indexOf('age_verified=true') === -1) {
        const overlay = document.getElementById('age-verification-overlay');
        const confirmBtn = document.getElementById('confirm-age');
        const denyBtn = document.getElementById('deny-age');
        const popupContent = document.getElementById('age-popup-content');

        // Lock scroll when the popup is shown
        document.body.style.overflow = 'hidden';

        confirmBtn.addEventListener('click', function() {
            document.cookie = "age_verified=true; path=/; max-age=" + (60*60*24*30); // 30 days
            overlay.style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scroll when confirmed
        });

        denyBtn.addEventListener('click', function() {
            const denyTitle = popupContent.getAttribute('data-deny-title');
            const denyMessage = popupContent.getAttribute('data-deny-message');

            document.getElementById('age-popup-content').innerHTML = `
                <h2>${denyTitle}</h2>
                <p>${denyMessage}</p>
            `;
        });
    }
});
