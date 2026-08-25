@extends('layout.index')

@section('content')
    <header>
     <main class="main">

    <section class="welcome">
            <div>
                <h1>Welcome back, {{ $user->name }}! 👋</h1>
                <p>
                    Here's what's happening with your health today.
                </p>
            </div>
            <img src="image/doc.png">

        </section>
         <section class="cards">
            <div class="card">
                <div class="icon blue">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <small>Total Appointment booked</small>
                    <h2>12</h2>
                </div>
            </div>
            <div class="card">
                <div class="icon green">
                    <i class="fa-solid fa-capsules"></i>
                </div>
                <div>
                    <small>Total Medicines Ordered</small>
                    <h2>8</h2>
                </div>
            </div>
            <div class="card">
                <div class="icon navy">
                    <i class="fa-solid fa-flask"></i>
                </div>
                <div>
                    <small>Total Lab Tests</small>
                    <h2>5</h2>
                </div>
            </div>
       </header>
       <section class="tabs">
          <button onclick="showTab('recent-appointments', this)" class="tab-btn">Total Appointments</button>
          <button onclick="showTab('medicine-orders', this)" class="tab-btn">Medicines Odered</button>
          <button onclick="showTab('lab-records', this)" class="tab-btn">Lab Results</button>
        </section>


       

     <div class="tab-content" id="recent-appointments">
         <table>
                <thead>
                    <tr>
                        <th>Doctor</th>
                        <th>Specialty</th>
                        <th>Date & Time</th>
                        <th>Reason</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="order-id">Dr Jason Jones<br><span class="green1">ID#APTI2349</span></td>
                        <td>Cardiologist</td>
                        <td>05 May 2026</td>
                        <td>Heart-check</td>
                        <td>5000 FCFA</td>
                    </tr>
                   <tr>
                        <td class="order-id">Dr Jason Jones<br><span class="green1">ID#APTI2349</span></td>
                        <td>Cardiologist</td>
                        <td>05 May 2026</td>
                        <td>Heart-check</td>
                        <td>5000 FCFA</td>
                    </tr>
                    <tr>
                        <td class="order-id">Dr Jason Jones<br><span class="green1">ID#APTI2349</span></td>
                        <td>Cardiologist</td>
                        <td>05 May 2026</td>
                        <td>Heart-check</td>
                        <td>5000 FCFA</td>
                    </tr>
                   <tr>
                        <td class="order-id">Dr Jason Jones<br><span class="green1">ID#APTI2349</span></td>
                        <td>Cardiologist</td>
                        <td>05 May 2026</td>
                        <td>Heart-check</td>
                        <td>5000 FCFA</td>
                    </tr>
                    <tr>
                        <td class="order-id">Dr Jason Jones<br><span class="green1">ID#APTI2349</span></td>
                        <td>Cardiologist</td>
                        <td>05 May 2026</td>
                        <td>Heart-check</td>
                        <td>5000 FCFA</td>
                    </tr>
                    <tr>
                        <td class="order-id">Dr Jason Jones<br><span class="green1">ID#APTI2349</span></td>
                        <td>Cardiologist</td>
                        <td>05 May 2026</td>
                        <td>Heart-check</td>
                        <td>5000 FCFA</td>
                    </tr>
                   
                </tbody>
            </table>
    </div>

    <div class="tab-content" id="medicine-orders" style="display: none">
        <table>
             <thead>
                <tr>
                <th>Order ID</th>
                <th>Medicine</th>
                <th>Date</th>
                <th>Total</th>
            </tr>
          </thead>
                <tbody>
                    <tr>
                        <td class="order-id"><span>MED120</span></td>
                        <td>Amoxicillin</td>
                        <td>05 May 2026</td>
                        <td>5000 FCFA</td>
                    </tr>
                    <tr>
                        <td class="order-id"><span class="green1">MED120</span></td>
                        <td>Paracetamol</td>
                        <td>05 May 2026</td>
                        <td>5500 FCFA</td>
                    </tr>
                    <tr>
                        <td class="order-id"><span class="green1">MED120</span></td>
                        <td>Vitamin C</td>
                        <td>05 May 2026</td>
                        <td>5500 FCFA</td>
                    </tr>
                    <tr>
                        <td class="order-id"><span class="green1">MED120</span></td>
                        <td>Ibuprofen</td>
                        <td>06 May 2026</td>
                        <td>6500 FCFA</td>
                    </tr>
                        <tr>
                        <td class="order-id"><span class="green1">MED120</span></td>
                        <td>Ibuprofen</td>
                        <td>06 May 2026</td>
                        <td>6500 FCFA</td>
                    </tr>
                        <tr>
                        <td class="order-id"><span class="green1">MED120</span></td>
                        <td>Ibuprofen</td>
                        <td>06 May 2026</td>
                        <td>6500 FCFA</td>
                    </tr>
                        <tr>
                        <td class="order-id"><span class="green1">MED120</span></td>
                        <td>Ibuprofen</td>
                        <td>06 May 2026</td>
                        <td>6500 FCFA</td>
                    </tr>
                        <tr>
                        <td class="order-id"><span class="green1">MED120</span></td>
                        <td>Ibuprofen</td>
                        <td>06 May 2026</td>
                        <td>6500 FCFA</td>
                    </tr>
                        
            </tbody>
        </table>
    </div>

     <div class="tab-content"  id="lab-records" style="display: none">
            <table>
                <thead>
                    <tr>
                        <th>Request ID</th>
                        <th>Test Type</th>
                        <th>Date Required</th>
                        <th>Appointment Date</th>
                    </tr>
                </thead>
                <tbody>
                     <tr>
                        <td class="order-id"><span class="green1">LT0120</span></td>
                        <td>Malaria</td>
                        <td>05 May 2026</td>
                        <td>20 May 2027</td>
                    </tr>
                     <tr>
                         <td class="order-id"><span class="green1">LT0120</span></td>
                        <td>Malaria</td>
                        <td>05 May 2026</td>
                        <td>20 May 2027</td>
                    </tr>
                    <tr>
                         <td class="order-id"><span class="green1">LT0120</span></td>
                        <td>Malaria</td>
                        <td>05 May 2026</td>
                        <td>20 May 2027</td>
                    </tr>
                     <tr>
                         <td class="order-id"><span class="green1">LT0120</span></td>
                        <td>Malaria</td>
                        <td>05 May 2026</td>
                        <td>20 May 2027</td>
                    </tr>
                     <tr>
                         <td class="order-id"><span class="green1">LT0120</span></td>
                        <td>Malaria</td>
                        <td>05 May 2026</td>
                        <td>20 May 2027</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

@endsection
@section('scripts')
<script>
     function showTab(tabId, button){
        // hide al tan contents
                let tabs = 
                document.querySelectorAll('.tab-content');
                tabs.forEach(tab => {
                    tab.style.display = 'none';
                });
        //remove highlight form all buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        // show selected content
                document.getElementById(tabId).style.display = 'block';
        //highlight clicked button
        if (button){
            button.classList.add("active");
        }
            }
        //show first tab by default
            window.onload = function () {
                const firstButton = 
                document.querySelector(".tab-btn");
                showTab("recent-appointments", firstButton);
            };
</script>
@endsection