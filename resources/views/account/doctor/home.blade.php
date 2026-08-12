@extends('doctors-layout.index')
@section('content')



 {{-- ================= DOCTORS LIST CONTENT ================= --}}

<div class="doctors-main">
<div class="doctors-cards">

<div class="doc-first-card">
    <div class="doctor-card profile">
        <div class="profile_text">
    <div class="doctors-card-content">
    <div class="docprofile-image">
        <img src="image/doc.png" alt="doctor's profile" width="150px" height="140px">
    </div>
    <h3>Doctors Name</h3>
         <h4>specialty</h4>
    <p class="green"><a href="profile">edit profile</a></p>
        </div>

</div>
</div>
     
     </div>
    <div class="doctor-card">
    <div class="doctors-card-content">
    <i class="ri-calendar-check-line"></i>
    <h3>Todays Appointments</h3>
    </div>
    <h1>18</h1>
    <p class="green">+2 from yesterday</p>
   

</div>

  <div class="doctor-card">
    <div class="card-content">
    <i class="ri-time-line"></i>
    <h3>Upcoming</h3>
    </div>
    <h1 class="blue">12</h1>
    <p>Next 10:00 AM</p>

   
    <div class="card-content">

    <h3>Cancelled</h3>
    </div>
    <h1 class="red">3</h1>
    <p class="red">-1 from yesterday</p>



</div>

  

<div class="doctor-card">
    <div class="card-content">
    <i class="ri-eye-line"></i>
    <h3>Availability Today</h3>
    </div>
    <h1 class="blue">6hrs</h1>
    <p class="green">Edit your profile</p>

</div>

</div>

</div>

<div class="main1">
<div class="cards">

    <div class="card second">
    <div class="card-content">
        <i class="ri-calendar-event-line"></i>
    <h3> <a href="availability">
         Manage Requests
         </a></h3>
    </div>
    <div class="set-arrow">
    <p class="green"> <a href="availability">Vew new requests</a></p>
   <i class="ri-arrow-right-line"></i>
    </div>

</div>

<div class="card second">
     <div class="card-content">
    <i class="ri-time-line"></i>
    <h3><a href="availability">
        Update Your availability</a>
    </h3>
     </div>
    <div class="set-arrow">
    <p> <a href="availability">Set your schedule</a> </p>
    <i class="ri-arrow-right-line"></i>
    </div>

</div>

<div class="card second">
     <div class="card-content">
       <i class="ri-calendar-event-line"></i>
    <h3>
       Consultation History 
    </h3>
     </div>
    <div class="set-arrow">
    <p class="red">
        <a href="consultation">View past records</a></p>
   <i class="ri-arrow-right-line"></i>
    </div>

</div>

<div class="card second">
     <div class="card-content">
        <i class="ri-user-settings-line"></i>
    <h3>Doctors Profile</h3>
     </div>


     
    <div class="set-arrow">
    <p class="green"><a href="profile">Edit your profile?</a> </p>
    <i class="ri-arrow-right-line"></i>
    </div>
    

</div>
</div>
</div>

<div class="table">
    <h2>Todays Appointments</h2> 
    <table>
        <thead>
        
             <th> 
                 <h3>Patient</h3>   
            </th> 
             <th>
                <h3>Appointment ID</h3>
            </th>  
            <th>
                <h3>Time  </h3>  
             </th> 
            <th>
                <h3>Reason  </h3>
            </th> 
            <th>
                <h3>Payment Status </h3>
            </th> 
    </thead>
    <tbody>
        <tr>
            <td>
                Sarah Johnson
            </td>
            <td>
                APT001
            </td>
            <td>
                10AM
            </td>
            <td>
                Headache
            </td>
            <td>
                <button>Paid</button>
            </td>
            <tr>
        </tr>
        </tr>
        <tr>
            <td>
                 Thomas Will
            </td>
            <td>
                APT001
            </td>
            <td>
                10AM
            </td>
            <td>
                Headache
            </td>
             <td>
                <button>Paid</button>
            </td>
        </tr>
        <tr>
            <td>
                John Devil
            </td>
            <td>
                APT001
            </td>
            <td>
                10AM
            </td>
            <td>
                Headache
            </td>
             <td>
                <button>Paid</button>
            </td>
        </tr>
        <tr>
            <td>
                Micheal Sata
            </td>
            <td>
                APT001
            </td>
            <td>
                10AM
            </td>
            <td>
                Headache
            </td>
             <td>
                <button>Paid</button>
            </td>
        </tr>
        <tr>
            <td>
                Pumas DOrin
            </td>
            <td>
                APT001
            </td>
            <td>
                10AM
            </td>
            <td>
                Headache
            </td>
             <td>
                <button>Paid</button>
            </td>
        </tr>
    </tbody>

</table>

</div>

@endsection

