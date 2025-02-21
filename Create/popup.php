<?php if (!isset($_SESSION['user_id'])): ?>
    <script>
        window.onload = showPopup;
    </script>
<?php endif; ?>