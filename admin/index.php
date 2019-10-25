<?php
  include 'data.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet" type="text/css">

	 <title>Avatud Valitsemise Partnerluse Tegevuskava täitmise vahehinnang - Admin</title>
  </head>

	 <body>

		 <div class="col-12 text-center">
		 	<button class="btn .btn-primary" id="refresh-button" width=300px>Värskenda andmeid</button>
			 <p class="hidden" id="refresh-message">Andmed värskendatud!</p>
		</div>

		 <div class="col-12 text-center">
			 <a  id="link-to-main" href="../index.php">Liigu koondvaatesse</a>
		 </div>

     <div class="col-12 text-center">
       <p id="last-update-time">Viimati uuendatud: <?php echo(get_timestamp()); ?></a>
     </div>



	    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   	 	<script src="../js/jquery-3.3.1.min.js"></script>

		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="../js/popper.min.js"></script>
		<script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#refresh-button").click(function(){
                $.ajax({
                    type: 'POST',
                    url: 'refresh.php',
                    success: function(data) {
                      $("#refresh-message").text(data);
                      $("#refresh-message").removeClass("hidden")
                                           .addClass("visible");
                      setTimeout(function() {
                        $("#refresh-message").removeClass("visible")
                                            .addClass("hidden");
                        }, 10000);
                    $.ajax({
                      type: 'POST',
                      url: 'datatimestamp.php',
                      success: function(data) {
                        $("#last-update-time").text("Viimati uuendatud: " + data);
                      }
                    });

                    }
                });
              });
            });

    </script>
</body>
</html>
