  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | Dashboard</title>
	<link rel="icon" href="../mBOOT/plant.png" type="image/png" sizes="10x10">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="../mBOOT/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../mBOOT/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css" rel="stylesheet" type="text/css" />


    <!-- Theme style -->
    <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
      <link href="../mBOOT/searchstyle.css" rel="stylesheet" type="text/css" />

  <!-- DatePicker -->
  <link href="../mBOOT/jquery-ui.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  
<script type="text/javascript" src="../bootstrap/js/jquery-1.10.2.min.js"></script>
 <!-- Custom scroll Bar -->
    <link href="../mBOOT/prettify.css" type="text/css" rel="stylesheet" />
	<script type="text/javascript" src="../mBOOT/prettify.js"></script>
	<script type="text/javascript" src="../mBOOT/jquery.slimscroll.js"></script>
<!--Multiple Select TOKIN -->
  <script src="../mBOOT/jquery-3.1.1.min.js"></script>
     <link href="../mBOOT/tokenize2.css" rel="stylesheet" type="text/css" />
    <script src="../mBOOT/tokenize2.js" type="text/javascript"></script>
    <!-- Select 2 -->
     <script src="../mBOOT/select2.js"></script>
     <link href="../mBOOT/select2.css" rel="stylesheet" type="text/css" />
  
   <!--Gant Chart-->
     <!-- jsGanttImproved App -->
      <link href="../mBOOT/jsgantt.css" rel="stylesheet" type="text/css"/>
      <script src="../mBOOT/jsgantt.js" type="text/javascript"></script>
      
<script type="text/javascript">
	$(document).ready(function(){
		//loadMsg();
	var preLoadTimer;
	var interchk = <?php echo $_SESSION['LockDownTime']; ?>;
	$(this).mousemove(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).keypress(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).scroll(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	
	$(this).mousedown(function(e) {
	//clear prior timeout,if any
	preLoadTimer = 0;
	});
	//checktime
	setInterval(function()
	{
	preLoadTimer++;
	if (preLoadTimer > 10)
	{
	window.location.href="../lockscreen";
	}
	}, interchk )//30 Secs

	//Notification Reload
	setInterval(function()
	{
		//loadMsg();

	}, 100000 )//30 Secs

});

  function loadMsg()
	{
		//return false;
	 //Ajax to Get All Messages now
	    $.ajax({
	          type: "POST",
	          url: "../utility/getMsg",
	          //data: dataString,
	          cache: false,
	          success: function(html)
	          {
	                var obj = JSON.parse(html);
	                
	                $('#msgBoard').html(obj['msg']);
	                $('#msgNum').html(obj['msgNum']);

	                $('#notifBoard').html(obj['notif']);
	                $('#notifNum').html(obj['notifNum']);

	                $('#taskBoard').html(obj['task']);
	                $('#taskNum').html(obj['taskNum']);

	                $('.slimscroll').slimscroll({
					  height: '140px',
					  size: '10px'
					});

					$('.dropdown-menu').on({
					    "click":function(e){
					      e.stopPropagation();
					    }
					});
	          }
	          
	      });

	}

  function delMSG(elem)
  {
  		$(elem).hide();
  		var msgID = $(elem).attr("msgid");
  		
  		var dataString = 'msgID='+ msgID;
  		//ajax to remove user from seeing msg
  		    $.ajax({
	          type: "POST",
	          url: "../utility/removeMsg",
	          data: dataString,
	          cache: false,
	          success: function(html)
	          {

	          }
	          
	      });
  

  }

   function gotoAction(elem)
  {
  	var hlink = $(elem).attr("hlink");
  	window.location.href=hlink;
  }

</script>
  </head>