<?php
if (isset($_SESSION['alert'])) {
    $bgColor = $_SESSION['alert']['type'] === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
    echo '<div class="' . $bgColor . ' border-l-4 p-4 mb-4 relative" role="alert">';
    echo '<p>' . htmlspecialchars($_SESSION['alert']['message']) . '</p>';
    echo '<button onclick="this.parentElement.remove()" class="absolute top-0 right-0 px-2 py-1 text-sm">×</button>';
    echo '</div>';
}
?>