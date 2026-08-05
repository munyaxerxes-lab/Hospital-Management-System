<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Doctor Profile | MediLink</title>

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Doctor Profile CSS --}}
    <link rel="stylesheet" href="{{ asset('style/pofile.css') }}">
</head>

<body>

    {{-- =========================================
    PAGE
    ========================================== --}}
    <div class="doctor-profile-page">


        {{-- =========================================
        MEDILINK LOGO
        ========================================== --}}
        <div class="medilink-logo">
            <img src="{{ asset('image/lo.png') }}" alt="MediLink Logo">
        </div>


        {{-- =========================================
        DOCTOR HEADER
        ========================================== --}}
        <div class="doctor-header">

            {{-- Doctor Image --}}
            <div class="doctor-image">

                <img src="{{ asset('image/download.jpg') }}" alt="Dr. jane smaith">

            </div>


            {{-- Doctor Information --}}
            <div class="doctor-info">

                <h1>
                    Dr. Michael Brown
                </h1>

                <p>
                    Neurologist
                </p>

            </div>

        </div>


        {{-- =========================================
        MAIN CONTENT
        ========================================== --}}
        <div class="profile-container">


            {{-- =====================================
            LEFT SIDE
            ====================================== --}}
            <div class="profile-details">


                {{-- About --}}
                <div class="about-title">

                    <i class="fa-solid fa-circle-info"></i>

                    <h2>
                        About
                    </h2>

                </div>


                {{-- Spoken Language --}}
                <div class="profile-section language-section">

                    <h2>
                        <i class="fa-solid fa-language"></i>
                        Spoken language
                    </h2>

                    <div class="language">

                        <span>
                            French
                        </span>

                    </div>

                </div>


                {{-- Experience --}}
                <div class="profile-section">

                    <h2>
                        Experience:
                    </h2>

                    <p>
                        3+ Year in Neurologist
                        <br>

                        <br>

                    </p>

                </div>


                {{-- About Doctor --}}
                <div class="profile-section">

                    <h2>
                        About Doctor:
                    </h2>

                    <p>
                        specialize in Diagnosing and treating issues related
                        <br>
                        to the Brain and Nervous system and more.
                    </p>

                </div>


                {{-- Address --}}
                <div class="profile-section address-section">

                    <h2>
                        Address:
                    </h2>

                    <p>
                        <strong>
                            General Hospital:
                        </strong>

                        Beedi Douala, Cameroon
                    </p>

                </div>

            </div>


            {{-- =====================================
            RIGHT SIDE
            ====================================== --}}
            <div class="booking-area">


                {{-- Pricing Card --}}
                <div class="pricing-card">

                    <h2>
                        Pricing
                    </h2>


                    <p class="price">

                        Neurologist
                        <strong>
                            5,000 XAF
                        </strong>

                    </p>


                    <p class="price-note">

                        These amount are subjected to tax
                        <br>
                        and non-refundable

                    </p>


                    {{-- Book Appointment --}}
                    <a href="/book">
                        <button type="button" class="book-appointment-btn" onclick="bookAppointment()">
                            Book appointment
                        </button>
                    </a>

                </div>


                {{-- Back Button --}}

                <a href="/back" class="btnline">
                    <button type="button" class="back-btn" onclick="window.history.back()">
                        Back
                    </button>
                </a>
            </div>

        </div>

    </div>


    {{-- =========================================
    JAVASCRIPT
    ========================================== --}}
    <script>

        function bookAppointment() {

            alert(
                "You are about to book an appointment with Dr. James Elad."
            );

            // You can later redirect to your appointment page:
            // window.location.href = "{{ url('/appointments/book') }}";

        }

    </script>

</body>

</html>