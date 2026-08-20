@extends('admin_layout.index')
@section('content')

 <div class="container-text">
            <h1>Hello Administrator</h1>
            <p>Here's What's happening with the system today </p>
         </div>

      <div class="container">
         
         <div class="container-first">
        

         <div class="statistic-cards">
            
            <div class="cards">
               <div class="first_card_elements">
               <i class="ri-calendar-line" style="background: #F97316;"></i>
                 <p> Pending<br> Appointments</p>
               </div>
               <div class="second_card_elements">
                  <h2 class="integers">00</h2>
                  <i class="ri-calendar-line"></i>
               </div> 
            </div>

            <div class="cards">
               <div class="first_card_elements">
               <i class="ri-flask-line" style="background: #7C3AED;"></i>
                 <p> Pending<br> Lab Requests</p>
               </div>
               <div class="second_card_elements">
                  <h2 class="integers">00</h2>
                  <i class="ri-flask-line"></i>
               </div> 
            </div>

            <div class="cards">
               <div class="first_card_elements">
               <i class="ri-shopping-cart-line" style="background: #10B981;"></i>
                 <p> Pending<br> Medicine Orders</p>
               </div>
               <div class="second_card_elements">
                  <h2 class="integers">00</h2>
                  <i class="ri-shopping-cart-line"></i>
               </div> 
            </div>

            <div class="cards">
               <div class="first_card_elements">
               <i class="ri-account-circle-line" style="background: #1D4ED8;"></i>
                 <p>Total<br> Doctors</p>
               </div>
               <div class="second_card_elements">
                  <h2 class="integers">00</h2>
                  <i class="ri-account-circle-line"></i>
               </div> 
            </div>
          </div>
       </div>

         <div class="graphs">

                        <!-- Chart 1 Layout Block -->
         <div class="bars-container">
                  <!-- Chart 1 Layout Block -->
            <div class="overview-chart-card">
               <h3 class="chart-title">Overview</h3>
               <p class="chart-subtitle">Here is what is happening with your System metrics:</p>
               
               <div class="bars-container">
                  
                  <!-- Row 1: Appointments -->
                  <div class="metric-row">
                        <div class="metric-header fill-appointments">
                           <span>Appointments</span>
                           <span class="total-number">34</span>
                        </div>
                        <div class="metric-track">
                           <!-- 💡 Set the width percentage inline to represent your data distribution -->
                           <div class="metric-fill fill-appointments" style="width: 44%;"></div>
                        </div>
                  </div>

        <!-- Row 2: Medicine Orders -->
                        <div class="metric-row">
                              <div class="metric-header fill-medicines">
                                 <span>Medicine Orders</span>
                                 <span class="total-number">27</span>
                              </div>
                              <div class="metric-track">
                                 <div class="metric-fill fill-medicines" style="width: 34%;"></div>
                              </div>
                        </div>

                        <!-- Row 3: Lab Requests -->
                        <div class="metric-row">
                              <div class="metric-header fill-labs">
                                 <span>Lab Requests</span>
                                 <span class="total-number">19</span>
                              </div>
                              <div class="metric-track">
                                 <div class="metric-fill fill-labs" style="width: 22%;"></div>
                              </div>
                        </div>

                     </div>
                  </div>

                </div>


                  <!-- Chart 2 Layout Block -->
                  <div class="distribution-chart-card">
                     <h3 class="chart-title" style="width: 100%;">Requests Distribution</h3>
                     
                     <!-- Donut Ring Graphic Layout -->
                     <div class="donut-ring">
                        <div class="donut-hole">
                              <span class="donut-total-num">80</span>
                              <span class="donut-total-text">Total</span>
                        </div>
                     </div>

    <!-- Chart Color Key Metrics Legend -->
                  <div class="legend-container">
                     <div class="legend-item">
                           <div class="dot dot-appointments"></div>
                           <span>Appointments (44%)</span>
                     </div>
                     <div class="legend-item">
                           <div class="dot dot-medicines"></div>
                           <span>Medicine Orders (34%)</span>
                     </div>
                     <div class="legend-item">
                           <div class="dot dot-labs"></div>
                           <span>Lab Requests (22%)</span>
                     </div>
                  </div>
               </div>
            </div>
      </div>

   @endsection