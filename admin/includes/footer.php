<footer class="footer mt-auto text-center py-3 bg-light">
    <div class="container">
        <div class="row">
                <span class="text-muted">University Management System &copy; <?= date('Y') ?></span>
                <span class="text-muted">v1.0.0</span>
        </div>
    </div>
</footer>

<script src="/enrollment/bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
<script>
    // Enable tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    
</script>
</body>
</html>