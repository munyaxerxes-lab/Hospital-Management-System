@extends('layout.index')
@section('content')


    <link rel="stylesheet" href="{{ asset('style/mutistep.css') }}">


    <div class="booking-container">

        {{-- =====================================================
        LAB MULTISTEP PROGRESS BAR
        ====================================================== --}}

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



        {{-- =====================================================
        LAB MULTISTEP FORM
        ====================================================== --}}

        <form id="labRequestForm" method="POST">

            @csrf

            {{-- =================================================
            LAB STEP 1
            ================================================== --}}

            <div class="lab-form-step active" id="step1">

                <div class="lab-step-card lab-step-one-card">

                    {{-- ADDRESS --}}
                    <div class="lab-address-area">

                        <h3>
                            Enter Your Address
                        </h3>

                        <textarea name="address" id="address" placeholder="Type your address here..." required></textarea>

                    </div>


                    {{-- MAP --}}
                    <div class="lab-map-area">

                        <h3>
                            Or select on map
                        </h3>

                        <div class="lab-map-box">

                            <div class="lab-map-background">

                                <div class="lab-map-pin">
                                    📍
                                </div>

                                <div class="lab-zoom-controls">

                                    <button type="button">
                                        +
                                    </button>

                                    <button type="button">
                                        −
                                    </button>

                                </div>

                            </div>

                        </div>


                        <div class="lab-map-actions">

                            <button type="button" id="locationBtn">
                                📍 Share Location
                            </button>

                            <button type="button" id="pinBtn">
                                📌 Pin Location
                            </button>

                        </div>

                    </div>

                </div>


                <div class="lab-button-wrapper">

                    <button type="button" class="lab-btn lab-btn-primary lab-next-btn">
                        Continue
                    </button>

                </div>

            </div>


            {{-- =================================================
            LAB STEP 2
            ================================================== --}}

            <div class="lab-form-step" id="step2">

                <div class="lab-step-card lab-step-two-card">

                    {{-- DATE --}}
                    <div class="lab-date-area">

                        <h3>
                            Select preferred visit date
                        </h3>

                        <div class="lab-selected-date">

                            <span id="dateText">
                                Select Date
                            </span>

                        </div>

                        <input type="date" name="visit_date" id="visit_date" required>

                    </div>


                    {{-- TIME --}}
                    <div class="lab-time-area">

                        <h3>
                            Select visit time
                        </h3>

                        <select name="visit_time" id="visit_time" required>

                            <option value="">
                                Select time
                            </option>

                            <option value="08:00 AM">
                                08:00 AM
                            </option>

                            <option value="09:00 AM">
                                09:00 AM
                            </option>

                            <option value="10:00 AM">
                                10:00 AM
                            </option>

                            <option value="11:00 AM">
                                11:00 AM
                            </option>

                            <option value="02:00 PM">
                                02:00 PM
                            </option>

                            <option value="03:00 PM">
                                03:00 PM
                            </option>

                        </select>

                    </div>

                </div>


                <div class="lab-button-wrapper">

                    <button type="button" class="lab-btn lab-btn-back lab-prev-btn">
                        Back
                    </button>

                    <button type="button" class="lab-btn lab-btn-primary lab-next-btn">
                        Continue
                    </button>

                </div>

            </div>


            {{-- =================================================
            LAB STEP 3
            ================================================== --}}

            <div class="lab-form-step" id="step3">

                <div class="lab-step-card lab-step-three-card">

                    {{-- ORDER SUMMARY --}}
                    <div class="lab-order-summary">

                        <h3>
                            Order Summary
                        </h3>

                        <div class="lab-summary-item">

                            <span>
                                Malaria Test
                            </span>

                            <strong>
                                FCFA 2,000
                            </strong>

                        </div>


                        <div class="lab-summary-item">

                            <span>
                                Typhoid Test
                            </span>

                            <strong>
                                FCFA 3,000
                            </strong>

                        </div>


                        <div class="lab-summary-item">

                            <span>
                                Blood Pressure
                            </span>

                            <strong>
                                FCFA 1,000
                            </strong>

                        </div>


                        <div class="lab-summary-item">

                            <span>
                                Visit Fee
                            </span>

                            <strong>
                                FCFA 2,000
                            </strong>

                        </div>


                        <div class="lab-total-item">

                            <span>
                                Total Amount
                            </span>

                            <strong>
                                FCFA 8,000
                            </strong>

                        </div>

                    </div>


                    {{-- PAYMENT --}}
                    <div class="lab-payment-area">

                        <h3>
                            Payment Details
                        </h3>

                        <p>
                            Pay Using Mobile Money
                        </p>


                        <div class="lab-momo">

                            <img src="{{ asset('image/momo.png') }}" alt="Mobile Money">

                        </div>


                        <label for="phone">
                            Enter your phone number
                        </label>

                        <input type="tel" name="phone" id="phone" placeholder="6XXXXXXXX" required>

                    </div>

                </div>


                <div class="lab-button-wrapper">

                    <button type="button" class="lab-btn lab-btn-back lab-prev-btn">
                        Back
                    </button>

                    <button type="button" class="lab-btn lab-btn-primary" id="payButton">
                        Pay FCFA 8,000
                    </button>

                </div>

            </div>


            {{-- =================================================
            LAB STEP 4
            ================================================== --}}

            <div class="lab-form-step" id="step4">

                <div class="lab-processing-container">

                    <div class="lab-payment-image">

                        <img src="{{ asset('image/process.png') }}" alt="Processing payment">

                    </div>


                    <h2>
                        Processing your payment...
                    </h2>

                    <p>
                        Please do not close this window or press the back button.
                    </p>


                    <div class="lab-spinner"></div>

                </div>

            </div>


            {{-- =================================================
            LAB STEP 5
            ================================================== --}}

            <div class="lab-form-step" id="step5">

                <div class="lab-success-container">

                    <div class="lab-success-circle">
                        ✓
                    </div>


                    <h2>
                        Payment Successful!
                    </h2>


                    <p class="lab-success-text">
                        Your Lab Test has been
                        booked successfully.
                    </p>


                    <div class="lab-confirmation-card">

                        <div class="lab-confirmation-row">

                            <span>
                                Order ID:
                            </span>

                            <strong>
                                QLT-2025-0518-0002
                            </strong>

                        </div>


                        <div class="lab-confirmation-row">

                            <span>
                                Date &amp; Time:
                            </span>

                            <strong id="finalDateTime">
                                -
                            </strong>

                        </div>


                        <div class="lab-confirmation-row">

                            <span>
                                Address:
                            </span>

                            <strong id="finalAddress">
                                -
                            </strong>

                        </div>


                        <div class="lab-confirmation-row">

                            <span>
                                Total Paid:
                            </span>

                            <strong class="lab-green">
                                FCFA 8,000
                            </strong>

                        </div>

                    </div>


                </div>

                <div class="button--container">
                    <a href="/backtolab" class="lab-done-link">

                        <button type="button" class="lab-btn lab-btn-primary lab-done-button">
                            Done
                        </button>

                    </a>
                </div>

            </div>

        </form>
    </div>

    {{-- =====================================================
    LAB MULTISTEP JAVASCRIPT
    ====================================================== --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const steps = Array.from(
                document.querySelectorAll('.lab-form-step')
            );

            const progressSteps = Array.from(
                document.querySelectorAll('.step-item')
            );

            const nextButtons = document.querySelectorAll(
                '.lab-next-btn'
            );

            const prevButtons = document.querySelectorAll(
                '.lab-prev-btn'
            );

            const progressFill =
                document.getElementById('progressFill');

            const addressInput =
                document.getElementById('address');

            const dateInput =
                document.getElementById('visit_date');

            const timeInput =
                document.getElementById('visit_time');

            const phoneInput =
                document.getElementById('phone');

            const dateText =
                document.getElementById('dateText');

            const finalDateTime =
                document.getElementById('finalDateTime');

            const finalAddress =
                document.getElementById('finalAddress');

            const payButton =
                document.getElementById('payButton');


            let currentStep = 1;


            function showStep(stepNumber) {

                currentStep = stepNumber;


                steps.forEach((step, index) => {

                    step.classList.toggle(
                        'active',
                        index + 1 === stepNumber
                    );

                });


                progressSteps.forEach((stepItem, index) => {

                    const stepValue = index + 1;

                    stepItem.classList.toggle(
                        'active',
                        stepValue === stepNumber
                    );

                    stepItem.classList.toggle(
                        'completed',
                        stepValue < stepNumber
                    );

                });


                if (progressFill) {

                    const totalSteps =
                        progressSteps.length || 1;

                    const percent =
                        ((stepNumber - 1) /
                            (totalSteps - 1)) * 100;

                    progressFill.style.width =
                        `${Number.isFinite(percent) ? percent : 0}%`;

                }


                updateSummary();

            }


            function updateSummary() {

                if (dateText && dateInput) {

                    dateText.textContent =
                        dateInput.value
                            ? dateInput.value
                            : 'Select Date';

                }


                if (finalDateTime) {

                    const dateValue =
                        dateInput ? dateInput.value : '';

                    const timeValue =
                        timeInput ? timeInput.value : '';

                    finalDateTime.textContent =
                        dateValue && timeValue
                            ? `${dateValue} at ${timeValue}`
                            : '-';

                }


                if (finalAddress) {

                    finalAddress.textContent =
                        addressInput &&
                            addressInput.value
                            ? addressInput.value
                            : '-';

                }

            }


            nextButtons.forEach(button => {

                button.addEventListener('click', function () {

                    if (currentStep < steps.length) {

                        showStep(currentStep + 1);

                    }

                });

            });


            prevButtons.forEach(button => {

                button.addEventListener('click', function () {

                    if (currentStep > 1) {

                        showStep(currentStep - 1);

                    }

                });

            });


            [
                addressInput,
                dateInput,
                timeInput,
                phoneInput
            ].forEach(input => {

                if (input) {

                    input.addEventListener(
                        'input',
                        updateSummary
                    );

                    input.addEventListener(
                        'change',
                        updateSummary
                    );

                }

            });


            if (payButton) {

                payButton.addEventListener(
                    'click',
                    function () {

                        showStep(4);

                        setTimeout(function () {

                            showStep(5);

                        }, 1200);

                    }
                );

            }


            showStep(1);

        });

    </script>


@endsection