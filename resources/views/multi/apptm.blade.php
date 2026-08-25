<link rel="stylesheet" href="{{ asset('style/mutistep.css') }}">

@extends('layout.index')
@section('content')
    <div class="booking-container">

        <!-- =========================
                 PROGRESS STEPPER
                ========================== -->

        <div class="stepper">

            <div class="step-item active" data-step="1">
                <span class="step-number">1</span>
            </div>

            <div class="step-line"></div>

            <div class="step-item" data-step="2">
                <span class="step-number">2</span>
            </div>

            <div class="step-line"></div>

            <div class="step-item" data-step="3">
                <span class="step-number">3</span>
            </div>

            <div class="step-line"></div>

            <div class="step-item" data-step="4">
                <span class="step-number">4</span>
            </div>

            <div class="step-line"></div>

            <div class="step-item" data-step="5">
                <span class="step-number">5</span>
            </div>

        </div>



        <!-- =========================
                 BOOKING FORM
            ========================== -->


        <!-- =========================
                     STEP 1
                ========================== -->

        <div class="form-step active" id="step1">

            <div class="step--card">

                <div class="date-section">

                    <h3>Select date</h3>

                    <input type="date" name="appointment_date" class="date-font" id="appointment_date" required>

                </div>


                <div class="time-section">

                    <h3>Available Time Slots</h3>

                    <div class="time-slots">

                        <button type="button" class="time-slot" data-time="08:00 AM">
                            08:00 AM
                        </button>

                        <button type="button" class="time-slot" data-time="08:30 AM">
                            08:30 AM
                        </button>

                        <button type="button" class="time-slot" data-time="09:00 AM">
                            09:00 AM
                        </button>

                        <button type="button" class="time-slot" data-time="09:30 AM">
                            09:30 AM
                        </button>

                        <button type="button" class="time-slot" data-time="10:00 AM">
                            10:00 AM
                        </button>

                    </div>

                    <input type="hidden" name="appointment_time" id="appointment_time" required>

                </div>

            </div>


            <div class="button--container">

                <button type="button" class="btn btn-primary next-btn">
                    Continue
                </button>

            </div>

        </div>


        <!-- =========================
                     STEP 2
                ========================== -->

        <div class="form-step" id="step2">

            <div class="step-card consultation-card">

                <label for="reason">
                    Please describe the reason for your consultation
                </label>

                <textarea name="reason" id="reason" placeholder="Type your reason here..." required></textarea>

            </div>


            <div class="button--container">

                <button type="button" class="btn btn-secondary prev-btn">
                    Back
                </button>

                <button type="button" class="btn btn-primary next-btn">
                    Continue
                </button>

            </div>

        </div>


        <!-- =========================
                     STEP 3
                ========================== -->

        <div class="form-step" id="step3">

            <div class="summary--payment">

                <!-- BOOKING SUMMARY -->

                <div class="booking--summary">

                    <h3>Booking Summary</h3>

                    <div class="summary--item">
                        <span>Date</span>
                        <strong id="summaryDate">
                            -
                        </strong>
                    </div>

                    <div class="summary--item">
                        <span>Time</span>
                        <strong id="summaryTime">
                            -
                        </strong>
                    </div>

                    <div class="summary--item">
                        <span>Doctor</span>
                        <strong>
                            Dr. James Bla
                        </strong>
                    </div>

                    <div class="summary--item">
                        <span>Specialty</span>
                        <strong>
                            Cardiologist
                        </strong>
                    </div>

                    <div class="summary--item">
                        <span>Consultation Fee</span>
                        <strong class="price">
                            5000 FCFA
                        </strong>
                    </div>

                </div>


                <!-- PAYMENT -->

                <div class="payment--details">

                    <h3>Payment Details</h3>

                    <p class="payment-method-title">
                        Pay Using Mobile Money
                    </p>

                    <div class="mobile-money">

                        <div class="momo-logo">
                            <img src="{{ asset('image/momo.png') }}" alt="momo">
                        </div>

                        <div class="phone-put">

                            <label for="phone" class="phone">
                                Enter your phone number
                            </label>

                            <input type="tel" name="phone" id="phone" placeholder="6XXXXXXXX" required>

                        </div>

                    </div>

                </div>

            </div>


            <div class="button--container">

                <button type="button" class="btn btn-secondary prev-btn">
                    Back
                </button>

                <button type="button" class="btn btn-primary" id="payButton">

                    Pay FCFA 5000

                </button>

            </div>

        </div>


        <!-- =========================
                     STEP 4
                ========================== -->

        <div class="form-step" id="step4">

            <div class="processing-card">

                <div class="phone-icon">
                    <img src="{{ asset('image/process.png') }}" alt="momo">
                </div>

                <h2>
                    Processing your payment...
                </h2>

                <p>
                    Please do not close this window
                    or press the back button.
                </p>

                <div class="loader"></div>

            </div>

        </div>


        <!-- =========================
                     STEP 5
                ========================== -->

        <div class="form-step" id="step5">

            <div class="success-card">

                <div class="success-icon">
                    ✓
                </div>

                <h2>
                    Payment Successful
                </h2>

                <div class="confirmation-box">

                    <div>
                        <span>Booking ID:</span>

                        <strong>
                            APT-20250815-00123
                        </strong>
                    </div>

                    <div>
                        <span>Date & Time:</span>

                        <strong id="finalDateTime">
                            -
                        </strong>
                    </div>

                    <div>
                        <span>Total Paid:</span>

                        <strong class="price">
                            5000 FCFA
                        </strong>
                    </div>

                </div>

                <p class="email-message">
                    A confirmation has been sent to your email.
                </p>

            </div>
            <div class="button--container">
                <a href="/appointmentdone">
                    <button type="submit" class="btn btn-primary">
                        Done
                    </button>
                </a>
            </div>
        </div>

        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const steps = Array.from(document.querySelectorAll('.form-step'));
            const stepItems = Array.from(document.querySelectorAll('.step-item'));
            const nextButtons = document.querySelectorAll('.next-btn');
            const prevButtons = document.querySelectorAll('.prev-btn');
            const timeSlots = document.querySelectorAll('.time-slot');
            const dateInput = document.getElementById('appointment_date');
            const timeInput = document.getElementById('appointment_time');
            const reasonInput = document.getElementById('reason');
            const summaryDate = document.getElementById('summaryDate');
            const summaryTime = document.getElementById('summaryTime');
            const finalDateTime = document.getElementById('finalDateTime');
            const payButton = document.getElementById('payButton');

            let currentStep = 1;

            function updateStepDisplay(stepNumber) {
                currentStep = stepNumber;

                steps.forEach((step, index) => {
                    const stepId = index + 1;
                    step.classList.toggle('active', stepId === stepNumber);
                });

                stepItems.forEach((item, index) => {
                    const itemStep = index + 1;
                    item.classList.toggle('active', itemStep === stepNumber);
                    item.classList.toggle('completed', itemStep < stepNumber);
                });

                updateSummary();
            }

            function updateSummary() {
                const dateValue = dateInput ? dateInput.value : '';
                const timeValue = timeInput ? timeInput.value : '';

                if (summaryDate) summaryDate.textContent = dateValue ? dateValue : '-';
                if (summaryTime) summaryTime.textContent = timeValue ? timeValue : '-';
                if (finalDateTime) {
                    finalDateTime.textContent = dateValue && timeValue ? `${dateValue} at ${timeValue}` : '-';
                }
            }

            nextButtons.forEach(button => {
                button.addEventListener('click', function () {
                    if (currentStep < steps.length) {
                        updateStepDisplay(currentStep + 1);
                    }
                });
            });

            prevButtons.forEach(button => {
                button.addEventListener('click', function () {
                    if (currentStep > 1) {
                        updateStepDisplay(currentStep - 1);
                    }
                });
            });

            timeSlots.forEach(button => {
                button.addEventListener('click', function () {
                    timeSlots.forEach(slot => slot.classList.remove('selected'));
                    this.classList.add('selected');

                    if (timeInput) {
                        timeInput.value = this.dataset.time;
                    }

                    updateSummary();
                });
            });

            [dateInput, reasonInput].forEach(input => {
                if (input) {
                    input.addEventListener('input', updateSummary);
                }
            });

            if (payButton) {
                payButton.addEventListener('click', function () {
                    updateStepDisplay(4);

                    setTimeout(function () {
                        updateStepDisplay(5);
                    }, 1200);
                });
            }

            updateStepDisplay(1);
        });
    </script>

@endsection