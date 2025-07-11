<!-- filepath: /c:/xampp/htdocs/Robocart/includes/footer.php -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <p>&copy; 2025 Robocart. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/interface.js"></script>
<!--Switcher-->
<script src="assets/switcher/js/switcher.js"></script>
<!--bootstrap-slider-JS-->
<script src="assets/js/bootstrap-slider.min.js"></script>
<!--Slider-JS-->
<script src="assets/js/slick.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
<script>
    function initMap() {
        var location = {lat: -25.344, lng: 131.036};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 4,
            center: location
        });
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
    }
    google.maps.event.addDomListener(window, 'load', initMap);
</script>
</body>
</html>