@extends('admin_layout.index')
@section('content')
  <div class="app">

  
    
<main class="main">


<section class="page">
    <h1 class="page-title">Manage Doctor Accounts</h1>
    <p class="page-subtitle">Create, update, activate, deactivate or delete doctor accounts.</p>

    <!-- 1. The Trigger Button -->
<button popovertarget="my-modal" class="open-btn">Create Doctors</button>

<!-- 2. The Modal Element -->
<div id="my-modal" popover class="modal-box">
  <div class="modal-content">
    <div class="doctor-form">
            <div class="form-title">Create New Doctor Account</div>
            <div class="form-grid">
                <div class="field full"><label>Doctor Name *</label><input placeholder="Enter full name"></div>
                <div class="field"><label>Specialty *</label><select>
                  <option>Cardiologist</option>
                   <option>Neurosergent </option>
                   <option>Phamacist</option>
                   <option>Lab Technician </option></select></div>
                <div class="field"><label>Qualification *</label><input placeholder="Enter qualification"></div>
                <div class="field"><label>Years of Experience *</label><input placeholder="Enter years of experience"></div>
                <div class="field"><label>Consultation Fee (XAF) *</label><input placeholder="Enter consultation fee"></div>
                <div class="field full"><label>Username *</label><input placeholder="Enter username"></div>
                <div class="field full"><label>Status *</label><select><option>Select status</option></select></div>
            </div>
            <div class="save-row"><button class="btn btn-primary save-btn"><i class="fa-regular fa-floppy-disk"></i> Save Doctor</button></div>
            <div class="required-note"><i class="fa-solid fa-circle-info"></i> All fields marked with * are required.</div>
        </div>

    
    <!-- 3. The Close Button -->
    <button popovertarget="my-modal" popovertargetaction="hide" class="close-btn">
      Close
    </button>
  </div>
</div>

    <div class="doctors-layout">
        <div>
            
            <table class="data-table">
                <thead><tr><th></th><th>Doctor Name</th><th>Specialty</th><th>Experience</th><th>Fee (XAF)</th><th>Actions</th></tr></thead>
                <tbody>
                    <tr><td>1</td><td>Dr. John Ngoumtsia</td><td>Cardiology</td><td>10 years</td><td>15,000</td><td class="actions-cell"><span class="badge green">Active</span><button class="icon-btn red"><i class="fa-solid fa-pause"></i></button><button class="icon-btn red"><i class="fa-solid fa-trash"></i></button><button class="icon-btn orange"><i class="fa-solid fa-pen"></i></button><button class="icon-btn red"><i class="fa-solid fa-pause"></i></button></td></tr>
                    <tr><td>2</td><td>Dr. Aline Mbarga</td><td>Pediatrics</td><td>7 years</td><td>12,000</td><td class="actions-cell"><span class="badge green">Active</span><button class="icon-btn red"><i class="fa-solid fa-pause"></i></button><button class="icon-btn red"><i class="fa-solid fa-trash"></i></button><button class="icon-btn orange"><i class="fa-solid fa-pen"></i></button><button class="icon-btn red"><i class="fa-solid fa-pause"></i></button></td></tr>
                    <tr><td>3</td><td>Dr. Samuel Takam</td><td>Orthopedics</td><td>8 years</td><td>15,000</td><td class="actions-cell"><span class="badge red">Inactive</span><button class="icon-btn red"><i class="fa-solid fa-pause"></i></button><button class="icon-btn red"><i class="fa-solid fa-trash"></i></button><button class="icon-btn orange"><i class="fa-solid fa-pen"></i></button><button class="icon-btn red"><i class="fa-solid fa-pause"></i></button></td></tr>
                    <tr><td>4</td><td>Dr. Emilie Meka</td><td>Gynecology</td><td>12 years</td><td>18,000</td><td class="actions-cell"><span class="badge green">Active</span><button class="icon-btn red"><i class="fa-solid fa-pause"></i></button><button class="icon-btn red"><i class="fa-solid fa-trash"></i></button><button class="icon-btn orange"><i class="fa-solid fa-pen"></i></button><button class="icon-btn red"><i class="fa-solid fa-pause"></i></button></td></tr>
                    <tr><td>5</td><td>Dr. Christian L.</td><td>Neurology</td><td>6 years</td><td>20,000</td><td class="actions-cell"><span class="badge red">Inactive</span><button class="icon-btn red"><i class="fa-solid fa-pause"></i></button><button class="icon-btn red"><i class="fa-solid fa-trash"></i></button><button class="icon-btn orange"><i class="fa-solid fa-pen"></i></button><button class="icon-btn red"><i class="fa-solid fa-pause"></i></button></td></tr>
                </tbody>
            </table>
            <div class="pagination"><span style="margin-right:8px;color:#66728a">Showing 1 to 5 of 25 doctors</span><button class="page-btn">‹</button><button class="page-btn active">1</button><button class="page-btn">2</button><button class="page-btn">3</button><span>...</span><button class="page-btn">5</button></div>

            <div class="action-guide">
                <div class="guide-title">Actions Guide</div>
                <div class="guide-grid">
                    <div class="guide-item"><div class="guide-icon blue"><i class="fa-solid fa-pen"></i></div>
                    <div><strong>Edit / Update</strong><span>Update doctor information</span></div></div>
                    <div class="guide-item"><div class="guide-icon red"><i class="fa-solid fa-pause"></i></div>
                    <div><strong>Deactivate / Activate</strong><span>Toggle account status</span></div></div>
                    <div class="guide-item"><div class="guide-icon red"><i class="fa-solid fa-trash"></i></div>
                    <div><strong>Delete</strong><span>Permanently delete account</span></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

</main>
</div>

@endsection