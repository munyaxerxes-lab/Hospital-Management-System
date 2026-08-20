@extends('admin_layout.index')
@section('content')

<section class="page">
    <h1 class="page-title">Manage Medicine Orders</h1>
    <p class="page-subtitle">View and manage all medicine orders placed by patients.</p>

    <div class="content-with-panel">
        <div class="table-card">
            <table class="data-table">
                <thead><tr><th>Order ID</th><th>Customer Name</th><th>Order Date</th><th>Payment Status</th><th>Action</th></tr></thead>
                <tbody>
                    <tr><td>ORD-0001</td><td>Michael Tchoua</td><td>May 15, 2025<br>09:20 AM</td><td><span class="badge green">Paid</span></td><td><button class="btn btn-sm"><i class="fa-regular fa-eye"></i> View Details</button></td></tr>
                    <tr><td>ORD-0002</td><td>Carine Mbassi</td><td>May 15, 2025<br>11:45 AM</td><td><span class="badge green">Paid</span></td><td><button class="btn btn-sm"><i class="fa-regular fa-eye"></i> View Details</button></td></tr>
                    <tr><td>ORD-0003</td><td>Daniel Ngono</td><td>May 16, 2025<br>08:30 AM</td><td><span class="badge green">Paid</span></td><td><button class="btn btn-sm"><i class="fa-regular fa-eye"></i> View Details</button></td></tr>
                    <tr><td>ORD-0004</td><td>Sarah Biloa</td><td>May 16, 2025<br>03:35 PM</td><td><span class="badge green">Paid</span></td><td><button class="btn btn-sm"><i class="fa-regular fa-eye"></i> View Details</button></td></tr>
                    <tr><td>ORD-0005</td><td>Joseph Fouda</td><td>May 16, 2025<br>03:35 PM</td><td><span class="badge green">Paid</span></td><td><button class="btn btn-sm"><i class="fa-regular fa-eye"></i> View Details</button></td></tr>
                    <tr><td>ORD-0006</td><td>Brenda Nguea</td><td>May 17, 2025<br>09:15 AM</td><td><span class="badge green">Paid</span></td><td><button class="btn btn-sm"><i class="fa-regular fa-eye"></i> View Details</button></td></tr>
                    <tr><td>ORD-0007</td><td>Albert Massi</td><td>May 17, 2025<br>10:30 AM</td><td><span class="badge green">Paid</span></td><td><button class="btn btn-sm"><i class="fa-regular fa-eye"></i> View Details</button></td></tr>
                    <tr><td>ORD-0008</td><td>Laura Ndifor</td><td>May 17, 2025<br>02:25 PM</td><td><span class="badge green">Paid</span></td><td><button class="btn btn-sm"><i class="fa-regular fa-eye"></i> View Details</button></td></tr>
                </tbody>
            </table>
        </div>


        <button popovertarget="my-modal" class="open-btn">view more</button>

<!-- 2. The Modal Element -->
<div id="my-modal" popover class="modal-box">
  <div class="modal-content">
    <div class="doctor-form">
           <aside class="side-panel">
            <div class="panel-title">Order Details <span style="color:#9ba4b4">×</span></div>
            <div class="panel-section-title">Order Information</div>
            <div class="detail-grid">
                <div><div class="detail-label">Order ID</div><div class="detail-value">ORD-0001</div></div>
                <div><div class="detail-label">Patient Name</div><div class="detail-value">Michael Tchoua</div></div>
                <div><div class="detail-label">Phone Number</div><div class="detail-value">—</div></div>
                <div><div class="detail-label">Email</div><div class="detail-value">michael.tchoua@email.com</div></div>
                <div style="grid-column:1/-1"><div class="detail-label">Delivery Address</div><div class="detail-value">Bastos, Yaoundé, Cameroon</div></div>
                <div style="grid-column:1/-1"><div class="detail-label">GPS Location</div><div class="detail-value">3.8480° N, 11.5021° E <i class="fa-solid fa-location-dot" style="color:#2a66db"></i></div></div>
            </div>
            <div class="panel-section-title">Ordered Medicines</div>
            <table class="mini-table"><thead><tr><th>Medicine</th><th>Quantity</th><th>Price (FCFA)</th><th>Total (FCFA)</th></tr></thead>
            <tbody><tr><td>Amoxicillin 500mg</td><td>2</td><td>1,500</td><td>3,000</td></tr><tr><td>Paracetamol 500mg</td><td>1</td><td>800</td><td>800</td></tr><tr><td>Vitamin C 1000mg</td><td>2</td><td>1,200</td><td>2,400</td></tr></tbody></table>
            <div class="detail-grid" style="margin-top:10px">
                <div style="grid-column:1/-1"><div class="detail-label">Delivery Fee</div><div class="detail-value" style="text-align:right">1,000</div></div>
                <div style="grid-column:1/-1"><div class="detail-label">Total Amount Paid</div><div class="detail-value" style="text-align:right;font-weight:700">6,000 FCFA</div></div>
                <div><div class="detail-label">Payment Status</div><div class="detail-value"><span class="badge green">Paid</span></div></div>
                <div><div class="detail-label">Order Status</div><div class="detail-value"><span class="badge orange">Pending</span></div></div>
            </div>
            <div class="panel-actions"><button class="btn btn-primary"><i class="fa-solid fa-briefcase-medical"></i> Prepare Order</button><button class="btn btn-danger">×&nbsp; Cancel Order</button></div>
            <div class="cancel-box">
                <div class="panel-title" style="margin-bottom:4px">Cancel Order <span>×</span></div>
                <div class="cancel-copy">Please provide a reason for cancelling this order.</div>
                <div class="panel-section-title" style="margin-top:0">Cancellation Reason</div>
                <select class="cancel-select"><option>Enter reason...</option></select>
                <div class="cancel-actions"><button class="btn">Close</button><button class="btn btn-danger">Submit Cancellation</button></div>
            </div>

    
    <!-- 3. The Close Button -->
    <button popovertarget="my-modal" popovertargetaction="hide" class="close-btn">
      Close
    </button>

        
@endsection