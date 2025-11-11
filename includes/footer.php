  </main>
  <footer class="bg-light py-3 mt-4">
    <div class="container text-center small text-muted">&copy; <?php echo date('Y'); ?> Grade Management</div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-" crossorigin="anonymous"></script>
  <script src="/grade-management-system/js/common.js"></script>
  <script>
    // Mobile Sidebar Toggle Function
    function toggleMobileSidebar() {
      const sidebarCol = document.getElementById('sidebarCol');
      const overlay = document.getElementById('sidebarOverlay');
      const menuToggle = document.getElementById('mobileMenuToggle');
      
      if (sidebarCol && overlay) {
        sidebarCol.classList.toggle('show');
        overlay.classList.toggle('show');
        
        // Change icon
        if (menuToggle) {
          const icon = menuToggle.querySelector('i');
          if (icon) {
            if (sidebarCol.classList.contains('show')) {
              icon.className = 'bi bi-x-lg';
            } else {
              icon.className = 'bi bi-list';
            }
          }
        }
      }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
      const sidebarLinks = document.querySelectorAll('.sidebar-nav .nav-link');
      sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
          if (window.innerWidth <= 991) {
            toggleMobileSidebar();
          }
        });
      });
    });
  </script>
</body>
</html>
