<?php
session_start();

if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
  header('Location: login.php');
  exit;
}

include_once('includes/header.php');
?>
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

        <section class="calendar-body">
          <div class="calendar">
            <div class="header">
              <button id="prevBtn">&lt;</button>
              <h2 id="monthYear"></h2>
              <button id="nextBtn">&gt;</button>
            </div>
            <div class="days"></div>
          </div>
          
        </section>

        <section>
          <div class="section-title">
            <h3 class="text-center" ><span><b>SELECT YOUR TIME SLOT</b></span></h3>
            <p></p>
          </div>
          <div class="row mx-auto calendar-body myElement"  >
            <div class="row" id="time-intervals" >
              
            </div>
            
        </div>
          
        </section>

        

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

            echo "console.log(periods);</script>";
        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
          //console.log(periods);

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
              console.log(totalDays);
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
                  console.log(month + " " + year);
                  console.log(currentDate.getMonth() + " " + currentDate.getFullYear());
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
              //daysContainer.children[todayIndex].classList.add('today');
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

              const today = new Date();
              var dateWithoutTime = new Date(today.getFullYear(), today.getMonth(), today.getDate());
              //console.log(selectedDay);
              //console.log(dateWithoutTime);

              var fg = true;
              if (selectedDay < dateWithoutTime) {
                //alert('Please select a future date. ' + today);
                fg = false;
              }
              console.log(fg);

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
              //alert(`You have selected: ${selectedDateStr}`);
              //console.log(selectedDateStr);
              var temp = document.getElementById('selectedDate');
              temp.value = selectedDateStr;

              var time_interval = document.getElementById('time-intervals');
              time_interval.innerHTML = "";
              /*var intervals = ['12:00 PM', '12:30 PM', '1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM', '3:00 PM', '3:30 PM', '4:00 PM', '4:30 PM', '5:00 PM', '5:30 PM', '6:00 PM', '6:30 PM', '7:00 PM', '7:30 PM', '8:00 PM', '8:30 PM', '9:00 PM', '9:30 PM', '10:00 PM', '10:30 PM', '11:00 PM', '11:30 PM', '12:00 AM'];

              console.log("here");

              for (let i = 0; i < intervals.length - 1; i++) {
                if (fg) {
                  var span = `<span class="btn btn-primary time-slot-btn" onclick="openBookingForm('${intervals[i]}', '${intervals[i+1]}')">${intervals[i]}-${intervals[i+1]}</span>`;
                } else {
                  var span = `<span class="btn btn-primary time-slot-btn">${intervals[i]}-${intervals[i+1]}</span>`;
                }

                time_interval.innerHTML += span;
              }*/

              for (let i=0; i<periods.length-1; i++){
                var startTime = periods[i];
                
                var endTime = periods[i+1];

                
                if (fg) {
                  var span = `<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 text-center"><span class="btn btn-success btn-lg  time-slot-btn" onclick="openBookingForm('${startTime}', '${endTime}')">${startTime}-${endTime}</span></div>`;
                } else {
                  var span = `<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 text-center"><span class="btn btn-primary time-slot-btn">${startTime}-${endTime}</span></div>`;
                }
                time_interval.innerHTML += span;
              }
              


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



          function openBookingForm(startTime, endTime) {
            document.getElementById('startTime').value = startTime;
            populateEndTimeDropdown(startTime);
            $('#bookingModal').modal('show');
          }

          function populateEndTimeDropdown(startTime) {
            var endTimeDropdown = document.getElementById('endTime');
            endTimeDropdown.innerHTML = '';
            var x=periods.length+1;
            for (let i=0; i<periods.length; i++){
              if(x<i){
                var option = document.createElement('option');
                option.value = periods[i];
                option.text = periods[i];
                endTimeDropdown.add(option);
              }   
              if(periods[i]==startTime){
                x=i;
              }
            }
            
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
            var mysqlDate = new Date(date).toISOString().split('T')[0];

            console.log(mysqlDate);

            //console.log(date);
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
                  // console.log('debug: ' + response);
                  if (response==='1'){
                    alert("Booked successfully");
                    $('#bookingModal').modal('hide');
                    window.location.replace('bookingManagement.php');
                  }
                  else {
                      alert('An error occurred. Please try again later.');
                      //console.error('Error submitting booking: ' + response.err);
                  }
                },
                // error: function(error) {
                //   console.error('Error submitting booking: ' + JSON.stringify(error));
                // }
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