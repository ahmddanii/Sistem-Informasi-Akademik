const toggleSidebar = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    toggleSidebar.addEventListener('click', () => {
      toggleSidebar.classList.toggle('animate');
      sidebar.classList.toggle('sidebar-hidden');
    });