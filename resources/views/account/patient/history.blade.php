@extends('layout.index')
@section('content')

<link rel="stylesheet" href="{{ asset('style/main.css') }}">

<div class="history-container">

    <div class="history-header">
        <h1>History</h1>
        <p>View your past appointments, lab tests and pharmacy orders.</p>
    </div>

    <div class="history-table">

        <!-- Table Header -->
        <div class="table-header">
            <div>History ID</div>
            <div>Date & Time</div>
            <div>What You Booked For</div>
            <div>Status</div>
            <div>Actions</div>
        </div>

        <!-- ================= APPOINTMENT ================= -->

        <div class="history-card">

            <div class="history-row">

                <div class="history-id">

                    <div class="icon-box">
                        <i class="ri-calendar-event-line"></i>
                    </div>

                    <span>APT-2024-00078</span>

                </div>

                <div class="history-date">
                    21 May 2024 <br>
                    10:30 AM
                </div>

                <div class="history-book">
                    Appointment with <br>
                    <strong>Dr. John Mbarga (Cardiologist)</strong>
                </div>

                <div>
                    <span class="status completed">
                        Completed
                    </span>
                </div>

                <div>

                    <button class="view-btn">

                        View More

                       

                    </button>

                </div>

            </div>


            <!-- DETAILS -->

            <div class="history-details">

                <div class="detail-title">

                    Appointment Details

                </div>

                <div class="detail-grid">

                    <div class="detail-box doctor">

                        <img src="{{ asset('image/doc.png') }}" alt="Dr. John ">

                        <div>

                            <h3>Dr. John Mbarga</h3>

                            <p>Cardiologist</p>

                            <small>+10 Years Experience</small>

                        </div>

                    </div>

                    <div class="detail-box">

                        <p><strong>Date & Time</strong></p>

                        <span>21 May 2024 10:30 AM</span>

                        <br><br>

                        <p><strong>Consultation Fee</strong></p>

                        <span>10,000 FCFA</span>

                        <br><br>

                        <p><strong>Reason</strong></p>

                        <span>Chest pain and shortness of breath</span>

                    </div>

                    <div class="detail-box">

                        <p><strong>Booking ID</strong></p>

                        <span>APT-2024-00078</span>

                        <br><br>

                        <p><strong>Payment Status</strong></p>

                        <span>Paid</span>

                        <br><br>

                        <p><strong>Total Paid</strong></p>

                        <span>10,000 FCFA</span>

                    </div>

                </div>

            </div>

        </div>

        <!-- ================= LAB TEST ================= -->

        <div class="history-card">

            <div class="history-row">

                <div class="history-id">

                    <div class="icon-box">

                        <i class="ri-flask-line"></i>

                    </div>

                    LAB-2024-00125

                </div>

                <div>

                    18 May 2024 <br>

                    09:15 AM

                </div>

                <div>

                    Quick Lab Test

                    <br>

                    <strong>(Malaria, Typhoid)</strong>

                </div>

                <div>

                    <span class="status completed">

                        Completed

                    </span>

                </div>

                <div>

                    <button class="view-btn">

                        View More

                    
                    </button>

                </div>

            </div>

            <div class="history-details">

                <div class="detail-title">

                    Lab Test Details

                </div>

                <div class="detail-grid">

                    <div class="detail-box">

                        <p><strong>Address</strong></p>

                        Quarter Mile, Buea

                    </div>

                    <div class="detail-box">

                        <p><strong>Tests Booked</strong></p>

                        Malaria Test, Typhoid Test

                        <br><br>

                        <p><strong>Visit Time</strong></p>

                        18 May 2024 09:00 AM

                    </div>

                    <div class="detail-box">

                        <p><strong>Order ID</strong></p>

                        LAB-2024-00125

                        <br><br>

                        <p><strong>Status</strong></p>

                        Paid

                        <br><br>

                        <p><strong>Total Paid</strong></p>

                        7,000 FCFA

                    </div>

                </div>

            </div>

        </div>

        <!-- ================= PHARMACY ================= -->

        <div class="history-card">

            <div class="history-row">

                <div class="history-id">

                    <div class="icon-box">

                        <i class="ri-capsule-fill"></i>

                    </div>

                    ORD-2024-00456

                </div>

                <div>

                    15 May 2024 <br>

                    02:45 PM

                </div>

                <div>

                    Pharmacy Order

                    <br>

                    <strong>(3 Medicines)</strong>

                </div>

                <div>

                    <span class="status delivered">

                        Delivered

                    </span>

                </div>

                <div>

                    <button class="view-btn">

                        View More

                        

                    </button>

                </div>

            </div>

            <div class="history-details">

                <div class="detail-title">

                    Order Details

                </div>

                <div class="detail-grid">

                    <div class="detail-box">

                        <p><strong>Delivery Address</strong></p>

                        Molyko, Buea

                    </div>

                    <div class="detail-box">

                        <p><strong>Items Ordered</strong></p>

                        3 Medicines

                        <br><br>

                        <p><strong>Delivery Date</strong></p>

                        16 May 2024

                    </div>

                    <div class="detail-box">

                        <p><strong>Payment</strong></p>

                        Paid

                        <br><br>

                        <p><strong>Total Paid</strong></p>

                        15,500 FCFA

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

const buttons=document.querySelectorAll(".view-btn");

buttons.forEach(button=>{

button.addEventListener("click",()=>{

const card=button.closest(".history-card");

const detail=card.querySelector(".history-details");

const arrow=button.querySelector(".arrow");

if(detail.classList.contains("show")){

detail.classList.remove("show");

button.childNodes[0].nodeValue="View More ";

arrow.style.transform="rotate(0deg)";

}else{

detail.classList.add("show");

button.childNodes[0].nodeValue="View Less ";

arrow.style.transform="rotate(180deg)";

}

});

});

</script>

@endsection