<div style="height: 20px;"></div>

<div class="bottom-nav">
    <a href="index.php?action=dashboard" class="nav-item-link <?= (!isset($_GET['action']) || $_GET['action'] == 'dashboard') ? 'active' : '' ?>">
        <i class="fa-solid fa-house"></i> Lịch làm việc
    </a>
    <a href="index.php?action=my_tours" class="nav-item-link <?= (isset($_GET['action']) && $_GET['action'] == 'my_tours') ? 'active' : '' ?>">
        <i class="fa-solid fa-list-check"></i> Tổng Tour đã đi
    </a>
    <a href="index.php?action=logout" class="nav-item-link text-danger" onclick="return confirm('Đăng xuất?')">
        <i class="fa-solid fa-right-from-bracket"></i> Đăng xuất
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>