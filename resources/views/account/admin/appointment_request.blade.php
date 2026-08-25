@extends('admin_layout.index')
@section('content')
     <!----------Appointment header----------->
   <div class="appointment-header">
      <h1>Manage Appointment Requests</h1>
      <h2>view and  manage all pending appointment request.</h2>
   </div>

      <!-----------appointment schedular---------->

  <div class="appointment-schedular">
      <ul>
         <li>All (25)</li>
         <li class="active">Pending (12)</li>
         <li>Confirmed (8)</li>
         <li>Rescheduled (3)</li>
         <li>Cancelled (2)</li>
       </ul>
   </div>
      <!----------Search bar and Date---------->
   
   <div class="Appointment-search-bar">

         <!------------ Search ----------->
     
      <div class="search-bar">
         <input type="text" placeholder="Search by patient name, ID...">
         <i class="ri-search-line"></i>
      </div>

         <!---------- Date------------>
      <div class="calendar-bar">
         <input type="text" placeholder="Filter by date">
         <i class="ri-calendar-line"></i>
      </div>

   </div>

      <!---------- Pending Appointment table ----------->
   
   <div class="table-container">

      <table>

        <thead>
            <tr>
                <th>Patient</th>
                <th>Date &amp; Time</th>
                <th>Consultation Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            <!-- ================= PATIENT 1 ================= -->
            <tr>

                <td>
                    <div class="patient">
                        <img
                            src="images/patient.jpg"
                            alt="Patient"
                            class="patient-image"
                        >

                        <div class="patient-info">
                            <strong>Michael Tchoua</strong>
                            <span>ID: PAT-0001</span>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="date-time">
                        <span>May 15, 2026</span>
                        <span>10:00 AM</span>
                    </div>
                </td>

                <td>
                    General Checkup
                </td>

                <td>
                    <span class="status pending">
                        Pending
                    </span>
                </td>

                <td>
                    <button class="view-btn" title="View patient">
                        <i class="ri-eye-line"></i>
                    </button>
                </td>

            </tr>


            <!-- ================= PATIENT 2 ================= -->
            <tr>

                <td>
                    <div class="patient">
                        <img
                            src="images/patient.jpg"
                            alt="Patient"
                            class="patient-image"
                        >

                        <div class="patient-info">
                            <strong>Michael Tchoua</strong>
                            <span>ID: PAT-0002</span>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="date-time">
                        <span>May 15, 2026</span>
                        <span>11:00 AM</span>
                    </div>
                </td>

                <td>
                    General Checkup
                </td>

                <td>
                    <span class="status pending">
                        Pending
                    </span>
                </td>

                <td>
                    <button class="view-btn" title="View patient">
                        <i class="ri-eye-line"></i>
                    </button>
                </td>

            </tr>


            <!-- ================= PATIENT 3 ================= -->
            <tr>

                <td>
                    <div class="patient">
                        <img
                            src="images/patient.jpg"
                            alt="Patient"
                            class="patient-image"
                        >

                        <div class="patient-info">
                            <strong>Michael Tchoua</strong>
                            <span>ID: PAT-0003</span>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="date-time">
                        <span>May 16, 2026</span>
                        <span>09:00 AM</span>
                    </div>
                </td>

                <td>
                    Follow-up
                </td>

                <td>
                    <span class="status pending">
                        Pending
                    </span>
                </td>

                <td>
                    <button class="view-btn" title="View patient">
                        <i class="ri-eye-line"></i>
                    </button>
                </td>

            </tr>


            <!-- ================= PATIENT 4 ================= -->
            <tr>

                <td>
                    <div class="patient">
                        <img
                            src="images/patient.jpg"
                            alt="Patient"
                            class="patient-image"
                        >

                        <div class="patient-info">
                            <strong>Michael Tchoua</strong>
                            <span>ID: PAT-0004</span>
                        </div>
                    </div>
                </td>

                <td>
                    <div class="date-time">
                        <span>May 16, 2026</span>
                        <span>10:00 AM</span>
                    </div>
                </td>

                <td>
                    Medical Consultation
                </td>

                <td>
                    <span class="status pending">
                        Pending
                    </span>
                </td>

                <td>
                    <button class="view-btn" title="View patient">
                        <i class="ri-eye-line"></i>
                    </button>
                </td>

            </tr>


            <!-- ================= PATIENT 5 ================= -->
            <tr>

               <td>
                    <div class="patient">
                        <img
                            src="images/patient.jpg"
                            alt="Patient"
                            class="patient-image"
                        >

                        <div class="patient-info">
                            <strong>Michael Tchoua</strong>
                            <span>ID: PAT-0005</span>
                        </div>
                    </div>
               </td>

               <td>
                    <div class="date-time">
                        <span>May 17, 2026</span>
                        <span>02:00 PM</span>
                    </div>
               </td>

               <td>
                    General Checkup
               </td>

               <td>
                    <span class="status pending">
                        Pending
                    </span>
               </td>

               <td>
                    <button class="view-btn" title="View patient">
                        <i class="ri-eye-line"></i>
                    </button>
               </td>

             </tr>
            </tbody>
         </table>

         </div>

      <div class="apointment-details-container">
         <div class="appointment-details">

         <!-- Header -->
         <div class="appointment-details-header">
             <h3>Appointment Details</h3>

            <button class="close-btn" type="button">
               <i class="ri-close-line"></i>
            </button>
         </div>


            <!-- Patient Information -->
         <div class="patient-details">

        <!-- Patient Image -->
         <div class="patient-avatar">
            <img
                src="images/patient.jpg"
                alt="Michael Tchoua"
            >
        </div>


        <!-- Patient Info -->
            <div class="patient-information">

               <h4>Michael Tchoua</h4>

               <p class="patient-id">
                ID: PAT-0001
               </p>

               <p>
                  <i class="ri-phone-line"></i>
                  +237 695 12 34 56
               </p>

               <p>
                  <i class="ri-mail-line"></i>
                   michael.tchoua@gmail.com
               </p>

            </div>

         </div>

      </div> 

    <!---------- appointment-detail-table-container ---------->
   
      <div class="appointment-detail-table-container">

         <!-- Appointment ID -->
         <div class="info-row">
            <div class="info-label">
                  <i class="ri-price-tag-3-line"></i>
                  <span>Appointment ID</span>
            </div>

                  <span class="info-value">APT-000123</span>
         </div>


         <!-- Appointment Date -->
         <div class="info-row">
            <div class="info-label">
               <i class="ri-calendar-line"></i>
               <span>Appointment Date</span>
            </div>

               <span class="info-value">May 15, 2025</span>
         </div>


         <!-- Appointment Time -->
         <div class="info-row">
            <div class="info-label">
               <i class="ri-time-line"></i>
               <span>Appointment Time</span>
            </div>

               <span class="info-value">10:00 AM</span>
         </div>


            <!-- Consultation Reason -->
         <div class="info-row">
            <div class="info-label">
               <i class="ri-file-text-line"></i>
               <span>Consultation Reason</span>
            </div>

               <span class="info-value">General Checkup</span>
         </div>


            <!-- Payment Status -->
         <div class="info-row">
            <div class="info-label">
               <i class="ri-wallet-line"></i>
               <span>Payment Status</span>
         </div>

               <span class="status-badge paid">
                   Paid
               </span>
         </div>


            <!-- Appointment Status -->
         <div class="info-row">
            <div class="info-label">
               <i class="ri-loop-right-line"></i>
               <span>Appointment Status</span>
            </div>

            <span class="status-badge pending">
                  Pending
            </span>
         </div>


            <!-- Requested On -->
         <div class="info-row">
            <div class="info-label">
               <i class="ri-calendar-check-line"></i>
               <span>Requested On</span>
            </div>

            <span class="info-value">
               May 12, 2025 08:45 AM
            </span>
         </div>


            <!-- Notes -->
         <div class="notes-section">

            <h4>Notes from Patient</h4>

            <div class="patient-note">
               I would like to have a general health checkup.
            </div>

         </div> 

      </div>
      
      <!--------APPOINTMENT ACTION BUTTONS--------->

      <div class="appointment-actions">

         <!-- Confirm -->
         <button class="appointment-btn confirm-btn" type="button">
            <i class="ri-check-line"></i>
            <span>Confirm Appointment</span>
         </button>


            <!-- Reschedule -->
         <button class="appointment-btn reschedule-btn" type="button">
            <i class="ri-calendar-line"></i>
            <span>Reschedule Appointment</span>
         </button>


            <!-- Cancel -->
         <button class="appointment-btn cancel-btn" type="button">
            <i class="ri-close-line"></i>
            <span>Cancel Appointment</span>
         </button>

      </div>

   </div>

                            


@endsection