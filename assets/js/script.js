document.getElementById('confirm-age').addEventListener('click', function() {
    document.cookie = "age_verified=true; path=/; max-age=" + (60*60*24*30); // 30 days
    document.getElementById('age-verification-overlay').style.display = 'none';
});
document.getElementById('deny-age').addEventListener('click', function() {
    window.location.href = "<?php echo esc_url($redirect_url); ?>";
});