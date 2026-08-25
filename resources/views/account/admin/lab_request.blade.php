@extends('admin_layout.index')
@section('content')
   <section class="page">
    <h1 class="page-title">Manage Lab Requests</h1>
    <p class="page-subtitle">View and manage all laboratory requests submitted by patients.</p>

    <div class="summary-row">
        <div class="card summary-card"><div class="summary-icon blue"><i class="fa-solid fa-flask"></i></div><div><div class="summary-label">Total Requests</div><div class="summary-number">45</div></div></div>
        <div class="card summary-card"><div class="summary-icon orange"><i class="fa-solid fa-briefcase-medical"></i></div><div><div class="summary-label">Pending</div><div class="summary-number">28</div></div></div>
        <div class="card summary-card"><div class="summary-icon green"><i class="fa-solid fa-circle-check"></i></div><div><div class="summary-label">Completed</div><div class="summary-number">12</div></div></div>
    </div>

    <table class="data-table lab-table">
        <thead><tr><th>Request ID</th><th>Patient Name</th><th>Test Name(s)</th><th>Address</th><th>Preferred Visit Date</th><th>Preferred Visit Time</th><th>Payment Status</th><th>Request Status</th><th>Upload</th></tr></thead>
        <tbody>
            <tr><td>LAB-0001</td><td><div class="patient-cell"><img class="avatar" src="assets/patient-1.jpg" onerror="this.style.display='none'">Michael Tchoua</div></td><td>Malaria, Typhoid</td><td>Bastos, Yaoundé</td><td>May 15, 2025</td><td>09:00 AM</td><td><span class="badge green">Paid</span></td><td><span class="badge orange">Pending</span></td><td><button class="btn upload-btn"><i class="fa-solid fa-upload"></i> Upload</button></td></tr>
            <tr><td>LAB-0002</td><td><div class="patient-cell"><img class="avatar" src="assets/patient-2.jpg" onerror="this.style.display='none'">Carine Mbassi</div></td><td>Full Blood Count</td><td>Nkolbisson, Yaoundé</td><td>May 16, 2025</td><td>10:00 AM</td><td><span class="badge green">Paid</span></td><td><span class="badge orange">Pending</span></td><td><button class="btn upload-btn"><i class="fa-solid fa-upload"></i> Upload</button></td></tr>
            <tr><td>LAB-0003</td><td><div class="patient-cell"><img class="avatar" src="assets/patient-3.jpg" onerror="this.style.display='none'">Daniel Ngono</div></td><td>Malaria</td><td>Mvog Ada, Yaoundé</td><td>May 16, 2025</td><td>02:00 PM</td><td><span class="badge green">Paid</span></td><td><span class="badge orange">Pending</span></td><td><button class="btn upload-btn"><i class="fa-solid fa-upload"></i> Upload</button></td></tr>
            <tr><td>LAB-0004</td><td><div class="patient-cell"><img class="avatar" src="assets/patient-4.jpg" onerror="this.style.display='none'">Sarah Biloa</div></td><td>Typhoid, Hepatitis B</td><td>Essos, Yaoundé</td><td>May 17, 2025</td><td>09:30 AM</td><td><span class="badge green">Paid</span></td><td><span class="badge orange">Pending</span></td><td><button class="btn upload-btn"><i class="fa-solid fa-upload"></i> Upload</button></td></tr>
            <tr><td>LAB-0005</td><td><div class="patient-cell"><img class="avatar" src="assets/patient-2.jpg" onerror="this.style.display='none'">Carine Mbassi</div></td><td>Full Blood Count</td><td>Nkolbisson, Yaoundé</td><td>May 16, 2025</td><td>10:00 AM</td><td><span class="badge green">Paid</span></td><td><span class="badge orange">Pending</span></td><td><button class="btn upload-btn"><i class="fa-solid fa-upload"></i> Upload</button></td></tr>
            <tr><td>LAB-0006</td><td><div class="patient-cell"><img class="avatar" src="assets/patient-3.jpg" onerror="this.style.display='none'">Daniel Ngono</div></td><td>Malaria</td><td>Mvog Ada, Yaoundé</td><td>May 16, 2025</td><td>02:00 PM</td><td><span class="badge green">Paid</span></td><td><span class="badge orange">Pending</span></td><td><button class="btn upload-btn"><i class="fa-solid fa-upload"></i> Upload</button></td></tr>
            <tr><td>LAB-0007</td><td><div class="patient-cell"><img class="avatar" src="assets/patient-4.jpg" onerror="this.style.display='none'">Sarah Biloa</div></td><td>Typhoid, Hepatitis B</td><td>Essos, Yaoundé</td><td>May 17, 2025</td><td>09:30 AM</td><td><span class="badge green">Paid</span></td><td><span class="badge orange">Pending</span></td><td><button class="btn upload-btn"><i class="fa-solid fa-upload"></i> Upload</button></td></tr>
        </tbody>
    </table>
</section>
        
@endsection