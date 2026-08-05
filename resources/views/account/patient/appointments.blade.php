@extends('layout.index')
@section('content')
    {{-- ================= DOCTORS LIST CONTENT ================= --}}
    <div class="doctors-content">

        {{-- Page Title --}}
        <h1 class="doctors-title">DOCTORS LIST</h1>

        {{-- Search Bar --}}
         <div class="search-container">

            <span class="search-icon">
                search Doctors...
            </span>

            <input type="text" id="searchInput" placeholder="">

        </div>

        {{-- Hero Banner --}}
        <div class="doctor-banner">

            <div class="banner-text">

                <div class="banner-label">
                    <span></span>
                    HEALTH WITHOUT A STEP
                </div>

                <h2>
                    Find the right
                    <strong>specialist</strong>
                    <br>
                    for your care
                </h2>

            </div>

            {{-- Decorative circles --}}
            <div class="banner-circle circle-1"></div>
            <div class="banner-circle circle-2"></div>

        </div>


        {{-- Doctors List --}}
        <div class="doctors-grid">

            {{-- Doctor 1 --}}
            <div class="doctor-item">

                <div class="doctor-card">

                    <div class="doctor-photo">
                        <img src="{{ asset('image/doc.png') }}" alt="Dr. John Doe">
                    </div>

                    <h3>Dr. John Doe</h3>

                    <p>Cardiologist</p>

                </div>

                <a href="/Dr john">
                    <button class="profile-button">
                        View Profile
                    </button>
                </a>

                <a href="/book">
                    <button class="book-button">
                        BOOK
                    </button>
                </a>

            </div>


            {{-- Doctor 2 --}}
            <div class="doctor-item">

                <div class="doctor-card">

                    <div class="doctor-photo">
                        <img src="{{ asset('image/doc2.jpg') }}" alt="Dr. Jane Smith">
                    </div>

                    <h3>Dr. Jane Smith</h3>

                    <p>General Practitioner</p>

                </div>

                <a href="/Dr jane">
                    <button class="profile-button">
                        View Profile
                    </button>
                </a>

                <a href="/book">
                    <button class="book-button">
                        BOOK
                    </button>
                </a>

            </div>


            {{-- Doctor 3 --}}
            <div class="doctor-item">

                <div class="doctor-card">

                    <div class="doctor-photo">
                        <img src="{{ asset('image/doc3.jpg') }}" alt="Dr. Sarah Jen">
                    </div>

                    <h3>Dr. Sarah Jen</h3>

                    <p>Gynecologist</p>

                </div>

                <a href="/Dr sarah">
                    <button class="profile-button">
                        View Profile
                    </button>
                </a>
                
                <a href="/book">
                    <button class="book-button">
                        BOOK
                    </button>
                </a>

            </div>


            {{-- Doctor 4 --}}
            <div class="doctor-item">

                <div class="doctor-card">

                    <div class="doctor-photo">
                        <img src="{{ asset('image/download.jpg') }}" alt="Dr. Michael Brown">
                    </div>

                    <h3>Dr. Michael Brown</h3>

                    <p>Neurologist</p>

                </div>

                <a href="/Dr michael">
                    <button class="profile-button">
                        View Profile
                    </button>
                </a>

                <a href="/book">
                    <button class="book-button">
                        BOOK
                    </button>
                </a>

            </div>

        </div>


        {{-- Instruction --}}
        <div class="doctor-instruction">
            CLICK THE BUTTONS BELOW TO <strong>"BOOK"</strong> OR <strong> VIEW </strong> PROFILE
        </div>

    </div>


    {{-- Search Function --}}
    <script>
        document.getElementById('doctorSearch').addEventListener('keyup', function () {

            let search = this.value.toLowerCase();

            document.querySelectorAll('.doctor-item').forEach(function (doctor) {

                let name = doctor.querySelector('h3').textContent.toLowerCase();
                let specialty = doctor.querySelector('p').textContent.toLowerCase();

                if (name.includes(search) || specialty.includes(search)) {
                    doctor.style.display = '';
                } else {
                    doctor.style.display = 'none';
                }

            });

        });
    </script>
@endsection