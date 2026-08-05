@extends('layout.index')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<div class="notification-wrapper">

    <!-- LEFT SIDE -->
    <div class="notification-list">

        <div class="notification-card active"
             onclick="showResult('malaria', this)">

            <div class="notification-icon purple">
                <i class="fa-solid fa-flask"></i>
            </div>

            <div class="notification-info">
                <h4>Laboratory Result Available</h4>

                <p>
                    Your Malaria Test Result is ready.
                </p>

                <span>
                    21 May 2024 • 09:15 AM
                </span>
            </div>

        </div>


        <div class="notification-card"
             onclick="showResult('typhoid', this)">

            <div class="notification-icon purple">
                <i class="fa-solid fa-flask"></i>
            </div>

            <div class="notification-info">

                <h4>Laboratory Result Available</h4>

                <p>
                    Your Typhoid Test Result is ready.
                </p>

                <span>
                    18 May 2024 • 10:20 AM
                </span>

            </div>

        </div>


        <div class="notification-card"
             onclick="showResult('blood', this)">

            <div class="notification-icon purple">
                <i class="fa-solid fa-flask"></i>
            </div>

            <div class="notification-info">

                <h4>Laboratory Result Available</h4>

                <p>
                    Your Blood Sugar Test Result is ready.
                </p>

                <span>
                    15 May 2024 • 01:45 PM
                </span>

            </div>

        </div>

    </div>



    <!-- RIGHT SIDE -->

    <div class="notification-details">

        <div id="resultTitle">
            <h2>Laboratory Result Available</h2>

            <small>21 May 2024 • 09:15 AM</small>
        </div>


        <hr>


        <p class="intro">
            Hello Kennedy,
            <br><br>

            Your laboratory result is now available.
            Kindly download your report below.
        </p>


        <div class="result-box">

            <div class="row">
                <span>Test Type</span>

                <strong id="testType">
                    Malaria Test
                </strong>
            </div>

            <div class="row">
                <span>Laboratory ID</span>

                <strong id="labId">
                    LAB-2024-00125
                </strong>
            </div>

            <div class="row">
                <span>Visit Date</span>

                <strong id="visitDate">
                    18 May 2024
                </strong>
            </div>

            <div class="row">
                <span>Reported Date</span>

                <strong id="reportDate">
                    21 May 2024
                </strong>
            </div>

            <div class="row">
                <span>Status</span>

                <strong class="completed">
                    Completed
                </strong>
            </div>

        </div>


        <div class="info-box">

            <i class="fa-solid fa-circle-info"></i>

            Please take medication based on your laboratory report.

        </div>


        <div class="button-group">

            <a href="#" class="download-btn">
                <i class="fa-solid fa-download"></i>

                Download Result
            </a>

        </div>

    </div>

</div>

<script>

function showResult(type, element){

    document.querySelectorAll('.notification-card').forEach(card=>{
        card.classList.remove('active');
    });

    element.classList.add('active');


    if(type=="malaria"){

        document.getElementById("testType").innerHTML="Malaria Test";
        document.getElementById("labId").innerHTML="LAB-2024-00125";
        document.getElementById("visitDate").innerHTML="18 May 2024";
        document.getElementById("reportDate").innerHTML="21 May 2024";

    }

    if(type=="typhoid"){

        document.getElementById("testType").innerHTML="Typhoid Test";
        document.getElementById("labId").innerHTML="LAB-2024-00163";
        document.getElementById("visitDate").innerHTML="15 May 2024";
        document.getElementById("reportDate").innerHTML="18 May 2024";

    }

    if(type=="blood"){

        document.getElementById("testType").innerHTML="Blood Sugar Test";
        document.getElementById("labId").innerHTML="LAB-2024-00195";
        document.getElementById("visitDate").innerHTML="13 May 2024";
        document.getElementById("reportDate").innerHTML="15 May 2024";

    }

}

</script>
@endsection