@extends('doctors-layout.index')
@section('content')
    <link rel="stylesheet" href="{{ asset('style/main1.css') }}">

    <div class="history-container">

        <div class="history-header">
            <h1>Appointment Requests</h1>
            <p>View appointments, and options.</p>
        </div>

        <div class="history-table">

            <!-- Table Header -->
            <div class="table-header">
                <div>Name</div>
                <div>Date & Time</div>

                <div>Status</div>
                <div>Actions</div>
            </div>

            <!-- ================= APPOINTMENT ================= -->

            <div class="history-card">
                <div class="history-row">
                    <div class="history-id">
                        <div class="icon-box">
                            <i class="ri-user-line"></i>
                        </div>
                        <span>Sarah ohansen</span>
                    </div>
                    <div class="history-date">
                        21 May 2024 <br>
                        10:30 AM
                    </div>
                    <div>
                        <span class="status completed">
                            Pending
                        </span>
                    </div>
                    <a href="#popup" class="btn">View More</a>

                    <div id="popup" class="modal">
                        <div class="modal-box">
                            <a href="#" class="close">&times;</a>
                            <div class="modal-stuffs">


                                <div class="history-details">

                                    <div class="detail-title">
                                        Appointment Details
                                    </div>

                                    <div class="detail-grid">
                                        <div class="detail-box doctor">
                                            <i class="ri-account-circle-line"></i>

                                            <div>
                                                <h3>Sarah ohansen</h3>
                                                <p>+237 000 000 000</p>
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
                                            <p><strong>Appointment ID</strong></p>
                                            <span>APC-2024-00078</span>
                                            <br><br>
                                            <p><strong>Payment Status</strong></p>
                                            <span>Paid</span>
                                            <br><br>
                                            <p><strong>Total Paid</strong></p>
                                            <span>10,000 FCFA</span>
                                        </div>

                                    </div>

                                    <!-- =================BUTTON SECTION================= -->

                                    <div class="apt-btn">
                                        <button class="confirm">Confirm Appointment</button>
                                        <button class="reschedule">Reschedule Appointment</button>
                                        <button class="cancel">Cancel Appointment</button>
                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>
                </div>


                 <!-- ================= APPOINTMENT ================= -->

            <div class="history-card">
                <div class="history-row">
                    <div class="history-id">
                        <div class="icon-box">
                            <i class="ri-user-line"></i>
                        </div>
                        <span>Sarah ohansen</span>
                    </div>
                    <div class="history-date">
                        21 May 2024 <br>
                        10:30 AM
                    </div>
                    <div>
                        <span class="status completed">
                            Pending
                        </span>
                    </div>
                    <a href="#popup" class="btn">View More</a>

                    <div id="popup" class="modal">
                        <div class="modal-box">
                            <a href="#" class="close">&times;</a>
                            <div class="modal-stuffs">


                                <div class="history-details">

                                    <div class="detail-title">
                                        Appointment Details
                                    </div>

                                    <div class="detail-grid">
                                        <div class="detail-box doctor">
                                            <i class="ri-account-circle-line"></i>

                                            <div>
                                                <h3>Sarah ohansen</h3>
                                                <p>+237 000 000 000</p>
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
                                            <p><strong>Appointment ID</strong></p>
                                            <span>APC-2024-00078</span>
                                            <br><br>
                                            <p><strong>Payment Status</strong></p>
                                            <span>Paid</span>
                                            <br><br>
                                            <p><strong>Total Paid</strong></p>
                                            <span>10,000 FCFA</span>
                                        </div>

                                    </div>

                                    <!-- =================BUTTON SECTION================= -->

                                    <div class="apt-btn">
                                        <button class="confirm">Confirm Appointment</button>
                                        <button class="reschedule">Reschedule Appointment</button>
                                        <button class="cancel">Cancel Appointment</button>
                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>
                </div>


                 <!-- ================= APPOINTMENT ================= -->

            <div class="history-card">
                <div class="history-row">
                    <div class="history-id">
                        <div class="icon-box">
                            <i class="ri-user-line"></i>
                        </div>
                        <span>Sarah ohansen</span>
                    </div>
                    <div class="history-date">
                        21 May 2024 <br>
                        10:30 AM
                    </div>
                    <div>
                        <span class="status completed">
                            Pending
                        </span>
                    </div>
                    <a href="#popup" class="btn">View More</a>

                    <div id="popup" class="modal">
                        <div class="modal-box">
                            <a href="#" class="close">&times;</a>
                            <div class="modal-stuffs">


                                <div class="history-details">

                                    <div class="detail-title">
                                        Appointment Details
                                    </div>

                                    <div class="detail-grid">
                                        <div class="detail-box doctor">
                                            <i class="ri-account-circle-line"></i>

                                            <div>
                                                <h3>Sarah ohansen</h3>
                                                <p>+237 000 000 000</p>
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
                                            <p><strong>Appointment ID</strong></p>
                                            <span>APC-2024-00078</span>
                                            <br><br>
                                            <p><strong>Payment Status</strong></p>
                                            <span>Paid</span>
                                            <br><br>
                                            <p><strong>Total Paid</strong></p>
                                            <span>10,000 FCFA</span>
                                        </div>

                                    </div>

                                    <!-- =================BUTTON SECTION================= -->

                                    <div class="apt-btn">
                                        <button class="confirm">Confirm Appointment</button>
                                        <button class="reschedule">Reschedule Appointment</button>
                                        <button class="cancel">Cancel Appointment</button>
                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>
                </div>


                 <!-- ================= APPOINTMENT ================= -->

            <div class="history-card">
                <div class="history-row">
                    <div class="history-id">
                        <div class="icon-box">
                            <i class="ri-user-line"></i>
                        </div>
                        <span>Sarah ohansen</span>
                    </div>
                    <div class="history-date">
                        21 May 2024 <br>
                        10:30 AM
                    </div>
                    <div>
                        <span class="status completed">
                            Pending
                        </span>
                    </div>
                    <a href="#popup" class="btn">View More</a>

                    <div id="popup" class="modal">
                        <div class="modal-box">
                            <a href="#" class="close">&times;</a>
                            <div class="modal-stuffs">


                                <div class="history-details">

                                    <div class="detail-title">
                                        Appointment Details
                                    </div>

                                    <div class="detail-grid">
                                        <div class="detail-box doctor">
                                            <i class="ri-account-circle-line"></i>

                                            <div>
                                                <h3>Sarah ohansen</h3>
                                                <p>+237 000 000 000</p>
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
                                            <p><strong>Appointment ID</strong></p>
                                            <span>APC-2024-00078</span>
                                            <br><br>
                                            <p><strong>Payment Status</strong></p>
                                            <span>Paid</span>
                                            <br><br>
                                            <p><strong>Total Paid</strong></p>
                                            <span>10,000 FCFA</span>
                                        </div>

                                    </div>

                                    <!-- =================BUTTON SECTION================= -->

                                    <div class="apt-btn">
                                        <button class="confirm">Confirm Appointment</button>
                                        <button class="reschedule">Reschedule Appointment</button>
                                        <button class="cancel">Cancel Appointment</button>
                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>
                </div>


                 <!-- ================= APPOINTMENT ================= -->

            <div class="history-card">
                <div class="history-row">
                    <div class="history-id">
                        <div class="icon-box">
                            <i class="ri-user-line"></i>
                        </div>
                        <span>Sarah ohansen</span>
                    </div>
                    <div class="history-date">
                        21 May 2024 <br>
                        10:30 AM
                    </div>
                    <div>
                        <span class="status completed">
                            Pending
                        </span>
                    </div>
                    <a href="#popup" class="btn">View More</a>

                    <div id="popup" class="modal">
                        <div class="modal-box">
                            <a href="#" class="close">&times;</a>
                            <div class="modal-stuffs">


                                <div class="history-details">

                                    <div class="detail-title">
                                        Appointment Details
                                    </div>

                                    <div class="detail-grid">
                                        <div class="detail-box doctor">
                                            <i class="ri-account-circle-line"></i>

                                            <div>
                                                <h3>Sarah ohansen</h3>
                                                <p>+237 000 000 000</p>
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
                                            <p><strong>Appointment ID</strong></p>
                                            <span>APC-2024-00078</span>
                                            <br><br>
                                            <p><strong>Payment Status</strong></p>
                                            <span>Paid</span>
                                            <br><br>
                                            <p><strong>Total Paid</strong></p>
                                            <span>10,000 FCFA</span>
                                        </div>

                                    </div>

                                    <!-- =================BUTTON SECTION================= -->

                                    <div class="apt-btn">
                                        <button class="confirm">Confirm Appointment</button>
                                        <button class="reschedule">Reschedule Appointment</button>
                                        <button class="cancel">Cancel Appointment</button>
                                    </div>

                                </div>

                            </div>

                        </div>


                    </div>
                </div>


@endsection
