@extends('layout.index')
@section('content')
    <link rel="stylesheet" href="{{ asset('style/main.css') }}">

    <!-- PAGE CONTENT -->

    <section class="page-content">


        <!-- PAGE TITLE -->

        <h2 class="page-title">
            Quick Lab Test
        </h2>



        <!-- SEARCH -->

        <div class="search-container">

            <span class="search-icon">
                search lab test...
            </span>

            <input type="text" id="searchInput" placeholder="">

        </div>



        <!-- TEST SECTION -->

        <div class="test-section">

            <h3>
                Select test Type(s)
            </h3>

            <p class="instruction">
                Your can choose one or more
            </p>



            <!-- TEST CARDS -->

            <div class="test-grid">


                <!-- =================================================
                                                         MALARIA
                                                    ================================================== -->

                <div class="test-card selected" data-name="Malaria Test" data-price="2000">

                    <div class="checkbox-container">

                        <input type="checkbox" class="test-checkbox" checked>

                    </div>

                    <img src="{{ asset('image/malaria.png') }}" alt="malaria" class="test-image">

                    <div class="test-information">

                        <h4>
                            Malaria Test
                        </h4>

                        <p>
                            Detects parasites
                        </p>

                        <strong>
                            2000FCFA
                        </strong>

                    </div>

                </div>



                <!-- =================================================
                                                         TYPHOID
                                                    ================================================== -->

                <div class="test-card" data-name="Typhoid Test" data-price="2000">

                    <div class="checkbox-container">

                        <input type="checkbox" class="test-checkbox">

                    </div>


                    <img src="{{ asset('image/thyphoid.png') }}" alt="typhoid" class="test-image">


                    <div class="test-information">

                        <h4>
                            Typhoid Test
                        </h4>

                        <p>
                            Detects Typhoid
                        </p>

                        <strong>
                            2000FCFA
                        </strong>

                    </div>

                </div>



                <!-- =================================================
                                                         BP
                                                    ================================================== -->

                <div class="test-card" data-name="BP Test" data-price="3000">

                    <div class="checkbox-container">

                        <input type="checkbox" class="test-checkbox">

                    </div>


                    <img src="{{ asset('image/bp.png') }}" alt="bp" class="test-image">


                    <div class="test-information">

                        <h4>
                            BP Test
                        </h4>

                        <p>
                            checks BP
                        </p>

                        <strong>
                            3000FCFA
                        </strong>

                    </div>

                </div>



                <!-- =================================================
                                                         HEMOGLOBIN
                                                    ================================================== -->

                <div class="test-card" data-name="Hemoglobin Test" data-price="1500">

                    <div class="checkbox-container">

                        <input type="checkbox" class="test-checkbox">

                    </div>


                    <img src="{{ asset('image/hypertension.png') }}" alt="hemoglobin" class="test-image">

                    <div class="test-information">

                        <h4>
                            Hemoglobin Test
                        </h4>

                        <p>
                            Checks Hem level
                        </p>

                        <strong>
                            1500FCFA
                        </strong>

                    </div>

                </div>


            </div>

        </div>



        <!-- BOOK BUTTON -->
        <div class="dnc">
            <a href="/request">
                <button class="bookbutton">
                    BOOK
                </button>
            </a>
        </div>
    </section>


    <!-- =====================================================
                                     JAVASCRIPT
                                ===================================================== -->

    <script>


        /*
        |--------------------------------------------------------------------------
        | SELECTABLE TEST CARDS
        |--------------------------------------------------------------------------
        |
        | When the user clicks a test card, the checkbox changes.
        |
        */

        const testCards = document.querySelectorAll(".test-card");


        testCards.forEach(card => {

            card.addEventListener("click", function (event) {

                /*
                | If the user directly clicks the checkbox,
                | don't manually toggle it again.
                */

                if (event.target.type === "checkbox") {

                    if (event.target.checked) {

                        card.classList.add("selected");

                    } else {

                        card.classList.remove("selected");

                    }

                    return;

                }


                const checkbox =
                    card.querySelector(".test-checkbox");


                checkbox.checked = !checkbox.checked;


                if (checkbox.checked) {

                    card.classList.add("selected");

                } else {

                    card.classList.remove("selected");

                }

            });

        });



        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        const searchInput =
            document.getElementById("searchInput");


        searchInput.addEventListener("input", function () {

            const searchValue =
                this.value.toLowerCase();


            testCards.forEach(card => {

                const testName =
                    card.dataset.name.toLowerCase();


                if (testName.includes(searchValue)) {

                    card.style.display = "block";

                } else {

                    card.style.display = "none";

                }

            });

        });




    </script>



@endsection