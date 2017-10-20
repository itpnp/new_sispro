
<div class="clearfix"></div>

	<footer class = "footer">

		<p>
			<span style="text-align:left;float:left">&copy; 2017 <a href="http://jiji262.github.io/Bootstrap_Metro_Dashboard/" alt="Bootstrap_Metro_Dashboard">PT. PURA NUSAPERSADA</a> <?php
$ip = $_SERVER['REMOTE_ADDR'];
echo" || Anda berkunjung dengan IP Address $ip";
?></span>

		</p>

	</footer>

	<!-- jQuery -->

    <script src="<?php echo base_url(); ?>assets/js/jquery1.9.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <!-- Morris Charts JavaScript -->
    <script src="<?php echo base_url(); ?>assets/js/raphael.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
    <script src="<?php echo base_url(); ?>assets/js/metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/metisMenu.min.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url(); ?>assets/js/sb-admin-2.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.id.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/timepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dataTables.bootstrap.js"></script>
    
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    $(document).ready(function(){
      var date_input=$('input[name="tanggalBon"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        language: 'id',
        format: 'dd MM yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
    $(document).ready(function(){
      var date_input=$('input[name="tanggalMutasi"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        language: 'id',
        format: 'dd MM yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
    $(document).ready(function(){
      var date_input=$('input[name="tanggalProduksiEdit"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        language: 'id',
        format: 'dd MM yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
    $(document).ready(function(){
      var date_input=$('input[name="startDate"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        language: 'id',
        format: 'dd MM yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
    $(document).ready(function(){
      var date_input=$('input[name="endDate"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        language: 'id',
        format: 'dd MM yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
      };
      date_input.datepicker(options);
    })
    </script>
    <script>
      function myFunction() {
          window.print();
      }
    </script>
</body>
</html>
