@extends('doctors-layout.index')
@section('content')
    <div class="main">

        <div class="card">

            <div class="top">
                <h2>Appointment Requests</h2>
                <div class="pending">5 Pending</div>
            </div>

            <h3>Reschedule Appointment</h3>
            <p class="subtitle">Select new date and time.</p>

            <div class="section">
                <h4>Select new date</h4>

                <div class="options">
                    <div class="option">Aug 5</div>
                    <div class="option selected">Aug 6</div>
                    <div class="option">Aug 7</div>
                    <div class="option">Aug 8</div>
                </div>
            </div>


            <div class="main">

                <div class="card">

                    <div class="header">
                        <h2>Availability</h2>
                        <p>5 Pending</p>
                    </div>

                    <div class="section">

                        <h3>Working Days</h3>

                        <div class="days">
                            <div class="day">Mon</div>
                            <div class="day">Tue</div>
                            <div class="day">Wed</div>
                            <div class="day">Thu</div>
                            <div class="day">Fri</div>
                        </div>

                    </div>

                    <div class="section">

                        <h3>Consultation Hours</h3>

                        <div class="time-inputs">
                            <input type="time" value="09:30">
                            <span>to</span>
                            <input type="time" value="10:30">

                            <select>
                                <option>30 min</option>
                                <option>45 min</option>
                                <option>60 min</option>
                            </select>

                        </div>

                    </div>

                    <div class="section">

                        <h3>Available Time Slots</h3>

                        <div class="slots">
                            <div class="slot">09:30</div>
                            <div class="slot">10:00</div>
                            <div class="slot active">11:00</div>
                            <div class="add">+ Add</div>
                        </div>

                    </div>

                    <div class="section">

                        <h3>Blocked Dates & Leave</h3>

                        <div class="leave">

                            <div class="leave-item">
                                <span>Aug 12 - Aug 14, 2026</span>
                                <span>Vacation</span>
                            </div>

                            <div class="leave-item">
                                <span>Sep 1, 2026</span>
                                <span>Personal Leave</span>
                            </div>

                        </div>

                        <button>Save Changes</button>

                    </div>

                </div>

            </div>

        </div>
    @endsection
