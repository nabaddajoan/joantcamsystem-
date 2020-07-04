<?php include 'includes/session.php'; ?>
<?php 
  include '../timezone.php'; 
  $today = date('Y-m-d');
  $year = date('Y');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        General Attendance Report
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Attendance</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">

      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Date</th>
                  <th>Teacher ID</th>
                  <th>Name</th>
                 
                  <th>Scheduled Time In</th>
                  <th>Scheduled Time Out</th>
                  
                </thead>
                <tbody>
                  <?php
$sql = "SELECT el.teacher_id, el.firstname,el.lastname, d.date from (select distinct date from attendance) d cross join teachers el left join attendance ai on ai.date = d.date and ai.Teacher_id = el.id where ai.Teacher_id is null order by d.date asc";
                    $query = $conn->query($sql);
                    while($row = $query->fetch_assoc()){
                      
                      echo "
                        <tr>
                          <td class='hidden'></td>
                          <td>".date('M d, Y', strtotime($row['date']))."</td>
                          <td>".$row['teacher_id']."</td>
                           <td>".$row['firstname'].' '.$row['lastname']."</td>
                                             
                          
                        </tr>
                      ";
                    }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
    
  <?php include 'includes/footer.php'; ?>
  
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $('.edit').click(function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $('.delete').click(function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
});

function getRow(id){
  $.ajax({
    type: 'POST',
    
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#datepicker_edit').val(response.date);
      $('#attendance_date').html(response.date);
      $('#edit_time_in').val(response.time_in);
      $('#edit_time_out').val(response.time_out);
      $('#attid').val(response.attid);
      $('#employee_name').html(response.firstname+' '+response.lastname);
       $('#schedule_time_in').val(response.Expected_time_in);
      $('#del_attid').val(response.attid);
      $('#del_employee_name').html(response.firstname+' '+response.lastname);
    }
  });
}

</script>
<!-- perfectly SELECT d.fulldate, t.teacher_id,t.firstname, t.lastname,t.time_in as Expected_time_in, ai.time_in as attended_time_in, (case when t.time_in = ai.time_in THEN 'yes'else 'no'end) as status, (case when ai.Teacher_id is null then 'No' else 'Yes' END) as Attended FROM (SELECT fulldate from dates) d cross join teacherschedules t left join attendance ai on ai.Teacher_id = t.id and ai.date = d.fulldate order by fulldate asc super p SELECT d.fulldate, t.teacher_id,t.firstname, t.lastname,t.time_in as Expected_time_in, ai.time_in as attended_time_in, (case when t.time_in = ai.time_in THEN 'ontime' when ai.Teacher_id is null then 'missed' else 'Late'end) as status FROM (SELECT fulldate from dates) d cross join teacherschedules t left join attendance ai on ai.Teacher_id = t.id and ai.date = d.fulldate order by fulldate asc
ppft SELECT d.fulldate, t.teacher_id,t.firstname, t.lastname,t.time_in as Expected_time_in, ai.time_in as attended_time_in, (case when t.time_in = ai.time_in THEN 'ontime' when ai.Teacher_id is null then 'missed' else 'Late'end) as status FROM dates d cross join teacherschedules t left join attendance ai on ai.Teacher_id = t.id and ai.date = d.fulldate order by fulldate asc// l, Query took 0.0756 seconds.)
SELECT * FROM dates d cross join teachers t left join attendance ai on ai.Teacher_id = t.id and ai.date = d.fulldate where month = 6 and weekend = 0 and ai.Teacher_id is null
select attended.date, teacherschedules.teacher_id, teacherschedules.firstname, teacherschedules.lastname, attended.time_in, attended.time_out FROM teacherschedules left join attended on teacherschedules.id = attended.Teacher_id where attended.time_in < teacherschedules.time_in and teacherschedules.time_out < attended.time_out OR teacherschedules.time_in <= attended.time_in <= teacherschedules.time_out OR teacherschedules.time_in <= attended.time_out <= teacherschedules.time_out ORDER by attended.date DESC, attended.time_in DESC
//SELECT dates.fulldate , attended.Teacher_id, teacherschedules.teacher_id, teacherschedules.time_in, teacherschedules.time_out from dates LEFT join attended on dates.fulldate = attended.date left JOIN teacherschedules on attended.Teacher_id = teacherschedules.id where attended.date is not null and dates.weekend = 0 order by dates.fulldate ASC
//SELECT * FROM teacherschedules s WHERE s.teacher_id not in (SELECT attendance.Teacher_id from attendance a where(SELECT teacherschedules.* from teacherschedules join attendance a on s.id = attendance.Teacher_id where(teacherschedules.time_in <= attendance.time_in <= teacherschedules.time_out or teacherschedules.time_in<attendance.time_out<=teacherschedules.time_out or attendance.time_in < teacherschedules.time_out and teacherschedules.time_out < attendance.time_out and attendance.date = date)))
//non attended
select dates.fulldate from dates left join attendance on dates.fulldate = attendance.date where attendance.date is null-->
</body>
</html>
