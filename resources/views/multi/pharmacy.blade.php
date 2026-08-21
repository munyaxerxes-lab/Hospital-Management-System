@extends('layout.index')
@section('content')


    <link rel="stylesheet" href="{{ asset('style/mutistep.css') }}">



    <div class="cart-multistep">

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

        </div>




        {{-- =========================================================
        MAIN FORM
        ========================================================== --}}

        <form id="cartCheckoutForm" method="POST" action="{{ url('/cart/checkout') }}">

            @csrf



            {{-- =====================================================
            STEP 1
            ====================================================== --}}

            <section class="cart-step-content cart-step-visible" id="cartStep1">


                <div class="cart-step-one-container">


                    {{-- CUSTOMER INFORMATION --}}

                    <div class="cart-customer-information">

                        <h3 class="cart-section-title">
                            Costumer information
                        </h3>


                        {{-- Full Name --}}

                        <div class="cart-form-group">

                            <label for="cartFullName">
                                Full name
                            </label>

                            <input type="text" id="cartFullName" name="full_name" autocomplete="name">

                            <small class="cart-error-message" id="cartFullNameError">
                            </small>

                        </div>


                        {{-- Email --}}

                        <div class="cart-form-group">

                            <label for="cartEmail">
                                Email
                            </label>

                            <input type="email" id="cartEmail" name="email" autocomplete="email">

                            <small class="cart-error-message" id="cartEmailError">
                            </small>

                        </div>


                        {{-- Phone --}}

                        <div class="cart-form-group">

                            <label for="cartPhone">
                                Phone number
                            </label>

                            <input type="tel" id="cartPhone" name="phone" autocomplete="tel">

                            <small class="cart-error-message" id="cartPhoneError">
                            </small>

                        </div>

                    </div>



                    {{-- ADDRESS --}}

                    <div class="cart-address-section">

                        <h3 class="cart-section-title">
                            Enter You address
                        </h3>


                        <textarea id="cartAddress" name="address" placeholder="Type your address"></textarea>


                        <small class="cart-error-message" id="cartAddressError">
                        </small>

                    </div>



                    {{-- MAP --}}

                    <div class="cart-map-section">

                        <h3 class="cart-section-title">
                            Or select on map
                        </h3>


                        <div class="cart-map-container" id="cartMapContainer">


                            {{-- Fake map background --}}
                            <div class="cart-map-background">

                                <div class="cart-map-road cart-map-road-one"></div>

                                <div class="cart-map-road cart-map-road-two"></div>

                                <div class="cart-map-road cart-map-road-three"></div>

                                <div class="cart-map-road cart-map-road-four"></div>


                                <span class="cart-map-label cart-map-label-one">
                                    Mbalmayo
                                </span>

                                <span class="cart-map-label cart-map-label-two">
                                    Yaoundé
                                </span>

                                <span class="cart-map-label cart-map-label-three">
                                    Central
                                </span>

                                <span class="cart-map-label cart-map-label-four">
                                    Cameroon
                                </span>

                            </div>


                            {{-- Map marker --}}
                            <div class="cart-map-marker">
                                <span>●</span>
                            </div>


                            {{-- Map zoom controls --}}
                            <div class="cart-map-zoom">

                                <button type="button" id="cartMapZoomIn" aria-label="Zoom in">

                                    +

                                </button>

                                <button type="button" id="cartMapZoomOut" aria-label="Zoom out">

                                    −

                                </button>

                            </div>

                        </div>


                        {{-- Map buttons --}}

                        <div class="cart-map-actions">

                            <button type="button" id="cartShareLocation">

                                <span>⌖</span>
                                Share Location

                            </button>


                            <button type="button" id="cartPinLocation">

                                <span>📍</span>
                                Pin Location

                            </button>

                        </div>

                    </div>

                </div>



                {{-- Continue --}}

                <div class="cart-button-container">

                    <button type="button" class="cart-button cart-primary-button" id="cartContinueStep1">

                        Continue

                    </button>

                </div>

            </section>



            {{-- =====================================================
            STEP 2
            ====================================================== --}}

            <section class="cart-step-content" id="cartStep2">


                <div class="cart-order-payment-card">


                    {{-- ORDER SUMMARY --}}

                    <div class="cart-order-summary">

                        <h3 class="cart-card-title">
                            Order summary
                        </h3>


                        {{-- Header --}}

                        <div class="cart-order-header">

                            <span>Product</span>

                            <span>Qty</span>

                            <span>Price</span>

                            <span>Total</span>

                        </div>


                        {{-- Product 1 --}}

                        <div class="cart-order-item">

                            <span>
                                Paracetamol 500mg Tablet
                            </span>

                            <span>
                                *2
                            </span>

                            <span>
                                FCFA 500
                            </span>

                            <span>
                                FCFA 1,000
                            </span>

                        </div>


                        {{-- Product 2 --}}

                        <div class="cart-order-item">

                            <span>
                                Paracetamol 500mg Tablet
                            </span>

                            <span>
                                *1
                            </span>

                            <span>
                                FCFA 1,200
                            </span>

                            <span>
                                FCFA 1,200
                            </span>

                        </div>


                        {{-- Product 3 --}}

                        <div class="cart-order-item">

                            <span>
                                Paracetamol 500mg Tablet
                            </span>

                            <span>
                                *1
                            </span>

                            <span>
                                FCFA 1,000
                            </span>

                            <span>
                                FCFA 1,000
                            </span>

                        </div>


                        {{-- Delivery --}}

                        <div class="cart-delivery-item">

                            <span>
                                Delivery Fee
                            </span>

                            <span></span>

                            <span></span>

                            <span>
                                FCFA 500
                            </span>

                        </div>


                        {{-- Total --}}

                        <div class="cart-order-total">

                            <strong>
                                Total
                            </strong>

                            <strong>
                                FCFA 3700
                            </strong>

                        </div>

                    </div>



                    {{-- PAYMENT --}}

                    <div class="cart-payment-section">

                        <h3 class="cart-card-title">
                            Payment Details
                        </h3>


                        <p class="cart-payment-description">
                            Pay Using Mobile Money
                        </p>


                        {{-- Mobile Money logo --}}

                        <div class="cart-momo-logo">

                            <img src="{{ asset('image/momo.png') }}" alt="MTN Mobile Money Logo">

                        </div>


                        <label class="cart-payment-phone-label" for="cartPaymentPhone">

                            Enter your phone number

                        </label>


                        <input type="tel" id="cartPaymentPhone" name="payment_phone" class="cart-payment-phone"
                            placeholder="">


                        <small class="cart-error-message" id="cartPaymentPhoneError">
                        </small>

                    </div>

                </div>



                {{-- Buttons --}}

                <div class="cart-button-container">

                    <button type="button" class="cart-button cart-back-button" id="cartBackStep2">

                        Back

                    </button>


                    <button type="button" class="cart-button cart-primary-button" id="cartPayButton">

                        Pay FCFA 3700

                    </button>

                </div>

            </section>



            {{-- =====================================================
            STEP 3
            ====================================================== --}}

            <section class="cart-step-content" id="cartStep3">

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

            </section>



            {{-- =====================================================
            STEP 4
            ====================================================== --}}

            <section class="cart-step-content" id="cartStep4">


                <div class="cart-success-container">


                    {{-- Success icon --}}

                    <div class="cart-success-icon">
                        ✓
                    </div>


                    <h2 class="cart-success-title">
                        Payment Successful!
                    </h2>


                    <p class="cart-success-message">
                        Your medicine has been booked successfully
                    </p>



                    {{-- Confirmation card --}}

                    <div class="cart-confirmation-card">


                        <div class="cart-confirmation-row">

                            <span>
                                Order ID:
                            </span>

                            <strong id="cartOrderId">
                                #ORD-2024-000123
                            </strong>

                        </div>


                        <div class="cart-confirmation-row">

                            <span>
                                Date & Time:
                            </span>

                            <strong id="cartOrderDate">
                                20 May 2024, 10:45 PM
                            </strong>

                        </div>


                        <div class="cart-confirmation-row">

                            <span>
                                Payment Method:
                            </span>

                            <strong>
                                MTN Mobile Money
                            </strong>

                        </div>


                        <div class="cart-confirmation-row">

                            <span>
                                Total Paid:
                            </span>

                            <strong class="cart-success-price">
                                FCFA 8,000
                            </strong>

                        </div>

                    </div>



                    {{-- Delivery information --}}

                    <div class="cart-delivery-information">


                        <div class="cart-delivery-icon">

                            <span class="cart-truck-body"></span>

                            <span class="cart-truck-wheel cart-truck-wheel-one"></span>

                            <span class="cart-truck-wheel cart-truck-wheel-two"></span>

                        </div>


                        <div class="cart-delivery-text">

                            <h3>
                                Your medicine will be delivered to:
                            </h3>


                            <p id="cartConfirmationAddress">

                                Bonamoussadi, Rue des palmiers,
                                Douala Cameroon

                            </p>

                        </div>

                    </div>



                    {{-- Done --}}
                    <a href="/pharmacy">
                        <button type="submit" class="cart-button cart-primary-button cart-done-button" id="cartDoneButton">

                            Done

                        </button>
                    </a>
                </div>

            </section>

        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const steps = Array.from(document.querySelectorAll('.cart-step-content'));
            const stepItems = Array.from(document.querySelectorAll('.step-item'));
            const stepLines = Array.from(document.querySelectorAll('.step-line'));
            const nextButtons = document.querySelectorAll('#cartContinueStep1, #cartPayButton');
            const prevButtons = document.querySelectorAll('#cartBackStep2');
            const addressInput = document.getElementById('cartAddress');

            let currentStep = 1;

            function updateStepDisplay(stepNumber) {
                currentStep = stepNumber;

                // Update step content visibility
                steps.forEach((step, index) => {
                    const stepId = index + 1;
                    step.classList.toggle('cart-step-visible', stepId === stepNumber);
                });

                // Update step items styling
                stepItems.forEach((item, index) => {
                    const itemStep = index + 1;
                    item.classList.toggle('active', itemStep === stepNumber);
                    item.classList.toggle('completed', itemStep < stepNumber);
                });

                // Update step lines styling
                stepLines.forEach((line, index) => {
                    // Line connects step (index + 1) to step (index + 2)
                    const lineConnectsTo = index + 2;
                    line.classList.toggle('completed', lineConnectsTo <= currentStep);
                });
            }

            nextButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (currentStep < steps.length) {
                        // Payment processing for step 2
                        if (currentStep === 2) {
                            updateStepDisplay(3);
                            setTimeout(() => {
                                const now = new Date();
                                document.getElementById('cartOrderId').textContent = '#ORD-' + now.getFullYear() + '-' + Math.floor(Math.random() * 1000000).toString().padStart(6, '0');
                                document.getElementById('cartOrderDate').textContent = now.toLocaleDateString() + ', ' + now.toLocaleTimeString();
                                document.getElementById('cartConfirmationAddress').textContent = addressInput.value;
                                updateStepDisplay(4);
                            }, 1200);
                        } else {
                            updateStepDisplay(currentStep + 1);
                        }
                    }
                });
            });

            prevButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (currentStep > 1) {
                        updateStepDisplay(currentStep - 1);
                    }
                });
            });

            document.getElementById('cartDoneButton')?.addEventListener('click', function (e) {
                e.preventDefault();
                document.getElementById('cartCheckoutForm').submit();
            });

            updateStepDisplay(1);
        });
    </script>
@endsection