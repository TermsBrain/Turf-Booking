<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
  header('Location: login.php');
  exit;
}

include_once('includes/header.php');
?>
<style>
    #time-intervals {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }
</style>
<div id="page-wrapper">
  <div class="row">
    <div class="col-12">
      <h1 class="page-header">Booking Management</h1>
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <style>
        .myElement{margin-top: -80px; }
        @media (max-width: 767px) {
          .myElement {margin-top: 80px; }
        }

        /* Media query for large screens (lg) */
        @media (min-width: 1200px) {
          .myElement {margin-top: -120px; }
        }

        
    
</style>
  <!-- /.row -->
  <div class="row">
    <div class="card">
      <div class="card-body">

      <div class="calendar-body py-5">
          <div class="calendar">
            <div class="header">
              <button id="prevBtn">&lt;</button>
              <h2 id="monthYear"></h2>
              <button id="nextBtn">&gt;</button>
            </div>
            <div class="days"></div>
          </div>
          
        </div>

        <div class="page-wrapper">
            
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header text-center">Select your time slot</h1>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div id="time-intervals" class="d-flex justify-content-center align-items-center mx-auto">
                            <!-- here is the buttons -->
                        </div>
                    </div>
                </div>

            </div>

        

        <!-- Modal for the booking form -->
        <div class="modal fade" role="dialog" id="bookingModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Booking Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="selectedDate">Selected Date:</label>
                    <input type="text" class="form-control" id="selectedDate" readonly>
                  </div>
                  <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="selectedDate">Enter Name:</label>
                          <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="selectedDate">Enter Contact:</label>
                          <input type="text" class="form-control" id="contact" placeholder="Enter contact" name="contact" required>
                        </div>
                      </div>
                  </div>
                  
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label for="startTime">Start Time:</label>
                            <input type="text" class="form-control" id="startTime" readonly>
                          </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="endTime">End Time:</label>
                          <select class="form-control" id="endTime" required>

                          </select>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="advance">Enter Advance:</label>
                          <input type="text" class="form-control" id="advance" placeholder="Enter advance" name="advance" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="total">Enter Total:</label>
                          <input type="text" class="form-control" id="total" placeholder="Enter total" name="total" required>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="total">Payment Method:</label>
                            <select class="form-control" id="method" required>
                              <option value="bkash"> BKash </option>
                              <option value="nagad"> Nagad </option>
                              <option value="cash"> Cash </option>
                              
                            </select>
                        </div>
                      </div>
                  </div>
                 
                  <button type="button" class="btn btn-success" onclick="submitBookingForm()">Book</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php
            include 'connection.php';
            $sql = "SELECT * FROM slot_management WHERE status=1";
            $result = mysqli_query($conn, $sql);
            
            echo "<script> var periods = [];";
            $row = mysqli_fetch_array($result);
            echo "var admin = '".$_SESSION['id']."';";
            echo "periods.push('".$row['start_time']."');"."periods.push('".$row['end_time']."');";
            while($r = mysqli_fetch_array($result)){
              echo "periods.push('".$r['end_time']."');";
            }

            // echo "console.log(periods);</script>";
            echo "</script>";
        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>


          document.addEventListener('DOMContentLoaded', function() {
            const daysContainer = document.querySelector('.days');
            const monthYearElement = document.getElementById('monthYear');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            let flag = true;
            let currentDate = new Date();
            let currentMonth = currentDate.getMonth();
            let currentYear = currentDate.getFullYear();

            if (flag) {
              renderCalendar(currentMonth, currentYear);
              flag = false;
            }

            function renderCalendar(month, year) {

              daysContainer.innerHTML = '';
              const firstDay = new Date(year, month, 1);
              const lastDay = new Date(year, month + 1, 0);
              const totalDays = lastDay.getDate();

              monthYearElement.textContent = `${getMonthName(month)} ${year}`;

              for (let i = 1; i <= totalDays; i++) {
                const day = document.createElement('div');

                day.classList.add('day');
                day.textContent = i;
                day.addEventListener('click', () => selectDate(i));
                daysContainer.appendChild(day);
                day.classList.remove('today');
                const currentDate = new Date();
                if (i == currentDate.getDate() && month == currentDate.getMonth() && year == currentDate.getFullYear()) {
                  selectDate(i);
                  day.classList.add('today');
                  var temp = document.getElementById('selectedDate');
                  temp.value = currentDate.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                  });
                }

              }

              const todayIndex = new Date().getDate() - 1;

            }

            function getMonthName(month) {
              const months = [
                'January', 'February', 'March', 'April',
                'May', 'June', 'July', 'August',
                'September', 'October', 'November', 'December'
              ];
              return months[month];
            }

            function selectDate(day) {
              const selectedDay = new Date(currentYear, currentMonth, day);
              var inputDate = new Date(selectedDay);
              var month = String(inputDate.getMonth() + 1).padStart(2, '0');
              var mysqlDate = inputDate.getFullYear() + '-' + month + '-' + inputDate.getDate();

              var live_slots = [];
              var slotsArray = [];
              $.ajax({
                url: 'api/get_slot_status.php',
                type: 'POST',
                dataType: 'json',
                data: {
                  date: mysqlDate,
                },
                success: function(response) {
                  slotsArray = response;

                  const today = new Date();
                  var dateWithoutTime = new Date(today.getFullYear(), today.getMonth(), today.getDate());

                  var fg = true;
                  if (selectedDay < dateWithoutTime) {
                   
                    fg = false;
                  }

                  const selectedElement = document.querySelector('.selected');
                  if (selectedElement) {
                    selectedElement.classList.remove('selected');
                  }

                  const clickedDayElement = daysContainer.children[day - 1];
                  clickedDayElement.classList.add('selected');

                  const selectedDateStr = selectedDay.toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                  });

                  var temp = document.getElementById('selectedDate');
                  temp.value = selectedDateStr;
                  var time_interval = document.getElementById('time-intervals');
                  time_interval.innerHTML = "";
                  
                  for (let i=0; i<periods.length-1; i++){
                    var startTime = periods[i];
                    
                    var endTime = periods[i+1];

                    if (fg) {
                      var isBooked = false;
                      for (let j=0; j<slotsArray.length; j++){
                        if(periods[i]==slotsArray[j].start){
                          isBooked = true;
                          while(slotsArray[j].end!=periods[i]){
                            i++;
                          }
                          var span = `<span class="btn btn-danger m-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 text-center" style= "padding: 10px; margin: 5px; " >${slotsArray[j].start} - ${periods[i]} booked by <br> ${slotsArray[j].name}</span>`;
                          i--;
                          break;
                        }
                      }
                      if(isBooked === false){
                        var span = `<span class="btn btn-primary m-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 text-center" style= "padding: 10px; margin: 5px; " onclick="openBookingForm('${mysqlDate}' ,'${periods[i]}', '${periods[i+1]}')">${periods[i]} - ${periods[i+1]} <br> --- </span>`;
                      }
                    } 
                    else {
                      var isBooked = false;
                      if(slotsArray.length == 0){
                        var span = `<span class="btn btn-warning m-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 text-center" style= "padding: 10px; margin: 5px; " > No Booking </span>`;
                        time_interval.innerHTML += span;
                        break;
                      }
                      for (let j=0; j<slotsArray.length; j++){
                        if(periods[i]==slotsArray[j].start){
                          isBooked = true;
                          while(slotsArray[j].end!=periods[i]){
                            i++;
                          }
                          var span = `<span class="btn btn-danger m-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 text-center" style= "padding: 10px; margin: 5px; " >${slotsArray[j].start} - ${periods[i]} booked by <br> ${slotsArray[j].name}</span>`;
                          i--;
                          break;
                        }
                      }
                      if(isBooked === false){
                        var span = `<span class="btn btn-primary m-2 col-lg-3 col-md-4 col-sm-6 col-xs-6 text-center" style= "padding: 10px; margin: 5px; " >${periods[i]} - ${periods[i+1]} <br> --- </span>`;
                      }
                    }
                    time_interval.innerHTML += span;
                  }
                },
                
              });
            }

            prevBtn.addEventListener('click', () => {
              currentMonth--;
              if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
              }
              renderCalendar(currentMonth, currentYear);
            });

            nextBtn.addEventListener('click', () => {
              currentMonth++;
              if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
              }
              renderCalendar(currentMonth, currentYear);
            });
          });

          function openBookingForm(chosenDate, startTime, endTime) {
            document.getElementById('startTime').value = startTime;
            populateEndTimeDropdown(chosenDate, startTime);
            $('#bookingModal').modal('show');
          }

          function populateEndTimeDropdown(chosenDate, startTime) {
            var endTimeDropdown = document.getElementById('endTime');
            endTimeDropdown.innerHTML = '';
            var x=periods.length+1;
            let flag_end_time = false;
            $.ajax({
                url: 'api/get_end_time.php',
                type: 'GET',
                dataType: 'json',
                data: {
                  date: chosenDate,
                },
                success: function(response) {
                  for (let i=0; i<periods.length; i++){
                    if(periods[i]==startTime){
                      x=i;
                    }
                    if(x<i){
                      for (let j=0; j<response.length; j++){
                        if (periods[i] === response[j]){
                          // console.log("DEBUG: "+periods[i]+" == "+response[j]);
                          flag_end_time = true;
                          break;
                        }
                      }
                      if (flag_end_time){
                          break;
                      }
                      var option = document.createElement('option');
                      option.value = periods[i];
                      option.text = periods[i];
                      endTimeDropdown.add(option);
                    }   
                  }
                }
            });
          }

          function submitBookingForm() {
            
            let date = document.getElementById('selectedDate').value;
            let startTime = document.getElementById('startTime').value;
            let endTime = document.getElementById('endTime').value;
            let name = document.getElementById('name').value;
            let contact = document.getElementById('contact').value;
            let advance = document.getElementById('advance').value;
            let total = document.getElementById('total').value;
            let method = document.getElementById('method').value;

            var inputDate = new Date(date);

            var month = String(inputDate.getMonth() + 1).padStart(2, '0');

            var mysqlDate = inputDate.getFullYear() + '-' + month + '-' + inputDate.getDate();


            if (name === "") {
              alert("Please enter a valid Name");
            } else if (contact === "") {
              alert("Please provide a Contact Number");
            } else if(advance===""){
              alert("Please provide a advance");
            }else if(total===""){
              alert("Please provide a Total");
            }else {
              $.ajax({
                url: 'api/submit_booking.php',
                type: 'POST',
                data: {
                  date: mysqlDate,
                  startTime: startTime,
                  endTime: endTime,
                  name: name,
                  contact: contact,
                  ref_id: admin,
                  advance: advance,
                  total: total,
                  method: method
                },
                success: function(response) {
                  if (response==='1'){
                    alert("Booked successfully");
                    $('#bookingModal').modal('hide');
                    window.location.replace('bookingManagement.php');
                  }
                  else {
                      alert('An error occurred. Please try again later.');
                  }
                },
               
              });
            }
          }
        </script>

        </section>
      </div>
    </div>

  </div>
</div>
<!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php include_once('includes/footer.php'); ?>