@extends('doctors-layout.index')
@section('content')



 {{-- ================= DOCTORS LIST CONTENT ================= --}}

<div class="main">
<div class="cards">

    <div class="card">
    <div class="card-content">
    <i class="ri-calendar-check-line"></i>
    <h3>Today's Appointments</h3>
    </div>
    <h1>18</h1>
    <p class="green">+2 from yesterday</p>
   

</div>

<div class="card">
    <div class="card-content">
    <i class="ri-time-line"></i>
    <h3>Upcoming</h3>
    </div>
    <h1 class="blue">12</h1>
    <p>Next 10:00 AM</p>
  

</div>

<div class="card">
    <div class="card-content">
    <i class="ri-close-circle-fill"></i>
    <h3>Cancelled</h3>
    </div>
    <h1 class="red">3</h1>
    <p class="red">-1 from yesterday</p>

</div>

<div class="card">
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
    <h3>Manage Requests</h3>
    </div>
    <div class="set-arrow">
    <p class="green">Vew new requests</p>
   <i class="ri-arrow-right-line"></i>
    </div>

</div>

<div class="card second">
     <div class="card-content">
    <i class="ri-time-line"></i>
    <h3>Update Your availability</h3>
     </div>
    <div class="set-arrow">
    <p>Set your schedule</p>
    <i class="ri-arrow-right-line"></i>
    </div>

</div>

<div class="card second">
     <div class="card-content">
       <i class="ri-calendar-event-line"></i>
    <h3>Consultation History</h3>
     </div>
    <div class="set-arrow">
    <p class="red">View past records</p>
   <i class="ri-arrow-right-line"></i>
    </div>

</div>

<div class="card second">
     <div class="card-content">
        <i class="ri-user-settings-line"></i>
    <h3>Doctor's Profile</h3>
     </div>
    <div class="set-arrow">
    <p class="green">Edit your profile?</p>
    <i class="ri-arrow-right-line"></i>
    </div>
    

</div>
</div>
</div>

<div class="table">
    <h2>Today's Appointments</h2> 
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

