<?php
session_start();
error_reporting(0);
include ('../DBcon/db_config.php');
include ('../utility/notify.php');



$G = $_SESSION['ErrMsg'];
$B = $_SESSION['ErrMsgB'];

$StaffID = $_SESSION['uid'];

if($StaffID == "")
{
  echo "Kindly logout and login";
  header("Location: ../login");
  exit;
}



$resultLeave = mysql_query("SELECT * FROM empleave WHERE uid = '".$StaffID."' AND isActive='1'");
//check if user exist
 $NoRow = mysql_num_rows($resultLeave);


if ($NoRow > 0) 
{
	//fetch tha data from the database
	while ($row = mysql_fetch_array($resultLeave)) {
	   //echo "ID:".$row{'id'}."</br> Name:".$row{'username'};
     $reqid = $row['id'];
	   $leaveType = $row['leaveType'];
     $StartDay = $row['StartDate'];
     $EndDay = $row['EndDate'];
     $NoOfDays = $row['NumberofDays'];
     $Note = $row['Note'];
     $CreatedOn = $row['CreatedOn'];
     $ApprovedBy = $row['UHApprovedBy'];
     $ApprovedOn = $row['UHApprovedOn'];
     $Approved = $row['Status'];
      if ($Approved == 0) { //href="sendforapproval?id='.$reqid.'"
        $Approved = '<a onclick="sendforapproval(\'Requester\', \''.$reqid.'\')" ><button title="submit leave request" class="btn btn-success"><i class="fa fa-send"></i> Submit</button></a> 
        <br/> <br/> <a href="editleave?rNo='.$reqid.'" target="_blank"><button title="Edit leave request" class="btn btn-info"><i class="fa fa-edit"></i></button></a>
        <br/> <br/> <a href="del?id='.$reqid.'"><button title="delete leave request" class="btn btn-danger"><i class="fa fa-trash"></i></button></a>';
      }
      else if ($Approved == 1)
      {
        $Approved = "Pending with Head of Dept";
      }
      else if ($Approved == 2)
      {
        $Approved = "Pending with Head of Division";
      }
      else if ($Approved == 3)
      {
        $Approved = "Pending with GM of Division";
      }
      else if ($Approved == 4)
      {
        $Approved = "Pending with GM of CS";
      }
      else if ($Approved == 5)
      {
        $Approved = "Pending with HR";
      }
      else if ($Approved == 6)
      {
        $Approved = "Pending in MD's Office";
      }
      else if($Approved == 7)
      {
        $Approved = "Approved";
      }
      else if($Approved == 8)
      {
        $Approved = "Cancelled";
      }
        else if($Approved == 9)
      {
        $Approved = "<b style='color:orange'>Pending with COO</b>";
      }

 
	  
	    $Record .='
					 <tr>
            <td>'.$CreatedOn.'</td>
					  <td>'.$leaveType.'</td>
						<td>'.$Note.'</td>
            <td>'.$StartDay.'</td>
						<td>'.$EndDay.'</td>
            <td>'.$NoOfDays.'</td>
            <td>'.$Approved.'</td>
            <td><a target="_blank" href="leaveview?rNo='.$reqid.'" ><i class="fa fa-eye"></i></a></td>
           
					 </tr>
					 
					 
					 ';
						
     }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo $_SESSION['CompanyAbbr']; ?> ERP | My Leave Mgt.</title>
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
    <!-- Theme style -->
    <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- DatePicker -->
  
     <link href="../mBOOT/jquery-ui.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
    function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
    </script>
	
  </head>
  <body class="skin-blue sidebar-mini">
  
        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
         
<?php if ($G == "")
           {} else {
echo

'<br><br><div class="alert alert-danger alert-dismissable">' .
                                       '<i class="fa fa-ban"></i>' .
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                        '<b></b>  '.  $G.
                                    '</div>' ; 
									$_SESSION['ErrMsg'] = "";}
?>
<?php if ($B == "")
           {} else {
echo

'<br><br><div class="alert alert-info alert-dismissable">' .
                                       '<i class="fa fa-ban"></i>' .
                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' .
                                        '<b></b>  '.  $B.
                                    '</div>' ; 
									$_SESSION['ErrMsgB'] = "";}
?>


				  

        <div class="row">
            <div class="col-md-12">
              <div class="box collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">My Leave &nbsp;&nbsp; <i class="fa fa-plane"></i></h3>
                  <div class="box-tools pull-right">
                    <!-- <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                     <a onclick="window.close();"><button class="btn btn-box-tool"  ><i class="fa fa-times"></i></button></a>-->
                  </div>
                </div><!-- /.box-header -->
            
               
                <div class="box-body">
                  <!--<div class="col-md-12" id="AllDays"></div>-->
                </div><!-- /.box-body -->
             
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->

          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Apply For Leave</h3>
                  <div class="box-tools pull-right">
                    <!-- <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                     <a href="./"><button class="btn btn-box-tool"  ><i class="fa fa-times"></i></button></a>-->
                  </div>
                </div><!-- /.box-header -->
            
               
                <div class="box-body">
                  <div class="col-md-12">
                    <form enctype="multipart/form-data" action="addleave" method="post" style="font-size:13px;">
                   
                      <div class="form-group has-feedback col-md-3">
                      <label>Leave Type <span style="color:red">*<span></label>
                      <select class="form-control" id="LeaveType" name="LeaveType" required >
                        <option value=""> -- </option>
                        <option value="Annual Leave">Annual Leave</option>
                        <option value="Compassionate Leave">Compassionate Leave</option>
                        <option value="Maternity Leave">Maternity Leave</option>
                        <option value="Sick Leave">Sick Leave</option>
                        <option value="Study Leave">Study Leave</option>

                      </select>
                      </div>

                      <div class="form-group has-feedback col-md-2">
                      <label>Start Date <span style="color:red">*<span></label>
                      <!--<button type="button" class="form-control" id="LeaveDays" class="btn btn-primary">Select Leave Days</button>-->
                      <input type="text" class="form-control" id="StartDay" name="StartDay" placeholder="yy-mm-dd" readonly required />
                      <!--<input type="text" class="form-control" id="LeaveDays" name="LeaveDays" readonly required />-->
                      </div>

                      <div class="form-group has-feedback col-md-2">
                      <label>End Date <span style="color:red">*<span></label>
                      <!--<button type="button" class="form-control" id="LeaveDays" class="btn btn-primary">Select Leave Days</button>-->
                      <input type="text" class="form-control" id="EndDay" name="EndDay" placeholder="yy-mm-dd" readonly required />
                      <!--<input type="text" class="form-control" id="LeaveDays" name="LeaveDays" readonly required />-->
                      </div>

                    

                      <div class="form-group col-md-5">
                      <label>Detailed Purpose</label>
                      <input type="text" class="form-control" id="LeavePurpose" name="LeavePurpose" placeholder="Reason for leave" required />
                      </div>

                      

                      <div class="form-group col-md-3 pull-right" style="padding-top:20px;">
                      <button type="submit" name="leaveapply" value="<?php echo $StaffID; ?>" class="btn btn-primary">Apply</button>
                      </div>
                     </form>
                  </div>
                </div><!-- /.box-body -->
             
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
	
	<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">My leave requests on ERP</h3>
                  <div class="box-tools pull-right">
                  </div>
                </div><!-- /.box-header -->
              <div class="box">
                <div class="box-header">
                 
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="userTab" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Applied on</th>
                        <th>Leave Type</th>
                        <th>Purpose</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>No. of Days</th>
                        <th>Status</th>
                         <th>&nbsp;</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                    <?php echo $Record; ?>
                    </tbody>
                   
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
             </div><!-- /.box -->
           </div><!-- /.col -->
        </div><!-- /.row -->
     
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

    

      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
       <div class="row">

              <div class="box box-primary">
                
                
                <!-- Modal form-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                      </div>
                      <div class="modal-body" id="modal-bodyku">
                      </div>
                      <div class="modal-footer" id="modal-footerq">
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end of modal ------------------------------>
                    </div>
    </div>

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='../plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="../plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="../plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
   
	<!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>

    <script src="../mBOOT/jquery-ui.js"></script>
    <script src="../mBOOT/jquery-ui.multidatespicker.js"></script>
     <script type="text/javascript">
      function setModalBox(title,content,footer,$size)
        {
            document.getElementById('modal-bodyku').innerHTML=content;
            document.getElementById('myModalLabel').innerHTML=title;
            document.getElementById('modal-footerq').innerHTML=footer;
           
            
                $('#myModal').attr('class', 'modal fade')
                             .attr('aria-labelledby','myModalLabel');
                $('.modal-dialog').attr('class','modal-dialog');
           
        }

    </script>
     <script type="text/javascript">
      
      function sendforapproval(actor, leaveID)
      {
        
          var size='standart';
                  var content = '<form role="form" action="sendforapproval" method="POST" ><div class="form-group">' +
                   '<input type="hidden" class="form-control"  name="ReqCode" value="'+ leaveID +'">' +
                    '<input type="hidden" name="actor" value="'+actor+'" />'+
                    '<div class="form-group" style="width:100%; display: inline-block; margin: 6px"><label>Message for Approval: </label><input type="text" class="form-control" id="eaccCode" name="ReqMSG" placeholder=""  value="Kindly help expedite. Thanks" required ></div>' +

                   '<button type="submit" class="btn btn-success pull-right">Send</button><br/></form>';
                  var title = 'Send Leave Request';
                  var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';

                  setModalBox(title,content,footer,size);
                  $('#myModal').modal('show');

              
      }
    </script>
	
    <script type="text/javascript">
	 
      $(function () {
	         
         $('#AllDays').multiDatesPicker({
        //disabled: true,
        beforeShowDay: $.datepicker.noWeekends,
        addDates: ['03/14/2017', '03/19/2017', '03/14/2017', '03/16/2017'],
        //addDisabledDates: ['10/14/2017', '02/19/2017', '01/14/2017', '11/16/2017'],
        numberOfMonths: [2,6],
        defaultDate: '1/1/2017'
      });

         //LeaveDays
         $('#StartDay').datepicker({
          minDate: 0,
          beforeShowDay: $.datepicker.noWeekends,
          inline: true,
          dateFormat: 'yy-mm-dd',
          onSelect: function(dateText) {
                 $("#EndDay").datepicker('option', 'minDate', dateText);
            }
         });

         var StartDay = $('#StartDay').val();
         $('#EndDay').datepicker({
          beforeShowDay: $.datepicker.noWeekends,
          inline: true,
          dateFormat: 'yy-mm-dd'

         });


         $('#LeaveDays').multiDatesPicker({
        inline: true,
        //altField: '#LeaveDays1',
        //showOn: 'button',
        beforeShowDay: $.datepicker.noWeekends,
        //addDates: ['10/14/2017', '02/19/2017', '01/14/2017', '11/16/2017'],
        //addDisabledDates: ['03/14/2017', '03/19/2017', '03/14/2017', '03/16/2017'],
        numberOfMonths: [2,6],
        //defaultDate: '1/1/2017'
      });
        //$("#userTab").dataTable();
        //$('#userTab').dataTable({
          /*"bPaginate": true,
          "bLengthChange": false,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false*/
        //});
      });
    </script>

  </body>
</html>