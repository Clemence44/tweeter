<footer class="section">
    <div class="container">
        &copy;&nbsp;<?= date("Y")?>
       <!-- <p>page home view : <?php//$_SESSION["pageHomeView"]?></p>-->
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        // Check for click events on the navbar burger icon
        $(".navbar-burger").click(function() {

            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
            $(".navbar-burger").toggleClass("is-active");
            $(".navbar-menu").toggleClass("is-active");

        });
    });
</script>

</body>
</html>

