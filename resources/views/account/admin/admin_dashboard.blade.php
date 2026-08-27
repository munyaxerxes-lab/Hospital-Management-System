@extends('admin_layout.index')
@section('content')



<section class="page" style="padding-bottom: 90px; min-height: calc(100vh - 280px);">
    <h1 class="page-title dashboard-title">Hello Administrator,</h1>
    <p class="page-subtitle dashboard-subtitle">Here's what's happening with your System today.</p>

    <div class="stats-grid">
        <div class="card stat-card"><div class="stat-icon orange"><i class="fa-solid fa-calendar-days"></i></div><div><div class="stat-label">Pending<br>Appointments</div><div class="stat-number">34</div></div></div>
        <div class="card stat-card"><div class="stat-icon purple"><i class="fa-solid fa-flask"></i></div><div><div class="stat-label">Pending<br>Laboratory Requests</div><div class="stat-number">19</div></div></div>
        <div class="card stat-card"><div class="stat-icon green"><i class="fa-solid fa-prescription-bottle-medical"></i></div><div><div class="stat-label">Pending<br>Medicine Orders</div><div class="stat-number">27</div></div></div>
        <div class="card stat-card"><div class="stat-icon blue"><i class="fa-solid fa-user-doctor"></i></div><div><div class="stat-label">Total Doctors</div><div class="stat-number">128</div></div></div>
    </div>

    <div class="dashboard-layout">
        <div class="card overview-card">
            <div class="card-head"><div class="card-title">Overview <span style="font-weight:400;color:#8a93a3">(Last 7 Days)</span></div><select class="small-select"><option>Last 7 Days</option></select></div>
            <div class="chart-wrap">
                <div class="legend"><span><i class="l1"></i>Appointments</span><span><i class="l2"></i>Medicine Orders</span><span><i class="l3"></i>Lab Requests</span></div>
                <svg class="line-chart" viewBox="0 0 430 190" preserveAspectRatio="none">
                    <g>
                        <line class="grid" x1="32" y1="25" x2="420" y2="25"/><line class="grid" x1="32" y1="60" x2="420" y2="60"/>
                        <line class="grid" x1="32" y1="95" x2="420" y2="95"/><line class="grid" x1="32" y1="130" x2="420" y2="130"/><line class="grid" x1="32" y1="165" x2="420" y2="165"/>
                    </g>
                    <g>
                        <text x="11" y="28">50</text><text x="11" y="63">40</text><text x="11" y="98">30</text><text x="11" y="133">20</text><text x="11" y="168">10</text>
                        <text x="48" y="184">May 5</text><text x="105" y="184">May 6</text><text x="163" y="184">May 7</text><text x="220" y="184">May 8</text><text x="278" y="184">May 9</text><text x="336" y="184">May 10</text><text x="395" y="184">May 11</text>
                    </g>
                    <polyline class="blue-line" points="52,82 110,68 168,91 226,48 284,69 342,38 400,70"/>
                    <polyline class="green-line" points="52,113 110,101 168,113 226,88 284,103 342,83 400,94"/>
                    <polyline class="purple-line" points="52,141 110,133 168,145 226,126 284,139 342,124 400,116"/>
                    <g class="blue-dot"><circle cx="52" cy="82" r="2.8"/><circle cx="110" cy="68" r="2.8"/><circle cx="168" cy="91" r="2.8"/><circle cx="226" cy="48" r="2.8"/><circle cx="284" cy="69" r="2.8"/><circle cx="342" cy="38" r="2.8"/><circle cx="400" cy="70" r="2.8"/></g>
                    <g class="green-dot"><circle cx="52" cy="113" r="2.8"/><circle cx="110" cy="101" r="2.8"/><circle cx="168" cy="113" r="2.8"/><circle cx="226" cy="88" r="2.8"/><circle cx="284" cy="103" r="2.8"/><circle cx="342" cy="83" r="2.8"/><circle cx="400" cy="94" r="2.8"/></g>
                    <g class="purple-dot"><circle cx="52" cy="141" r="2.8"/><circle cx="110" cy="133" r="2.8"/><circle cx="168" cy="145" r="2.8"/><circle cx="226" cy="126" r="2.8"/><circle cx="284" cy="139" r="2.8"/><circle cx="342" cy="124" r="2.8"/><circle cx="400" cy="116" r="2.8"/></g>
                </svg>
            </div>
        </div>
        <div class="card distribution">
            <div class="card-head"><div class="card-title">Requests Distribution</div></div>
            <div class="distribution-content">
                <div class="donut"></div>
                <div class="dist-legend">
                    <div class="dist-row"><span class="dist-dot d-blue"></span><b>Appointments</b>&nbsp;34 (44%)</div>
                    <div class="dist-row"><span class="dist-dot d-green"></span><b>Medicine Orders</b>&nbsp;27 (34%)</div>
                    <div class="dist-row"><span class="dist-dot d-purple"></span><b>Lab Requests</b>&nbsp;19 (22%)</div>
                    <div style="margin-top:9px">Total: 80 Requests</div>
                </div>
            </div>
        </div>
    </div>
</section>


   @endsection