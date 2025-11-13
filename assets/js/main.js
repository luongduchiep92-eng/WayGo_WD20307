document.getElementById('toggle-btn').addEventListener('click', () => {
    const sidebar = document.getElementById('sidebar');
    const header = document.querySelector('.admin-header');
    const footer = document.querySelector('.admin-footer');

    sidebar.classList.toggle('collapsed');
    header.classList.toggle('expanded');
    footer.classList.toggle('expanded');
});
