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
            <img src="{{ asset('image/doc.png') }}">

        </section>
         <section class="cards">
            <div class="card">
                <div class="icon blue">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <small>Total Appointment booked</small>
                    <h2>{{ $stats['appointments'] ?? $appointments->count() }}</h2>
                </div>
            </div>
            <div class="card">
                <div class="icon green">
                    <i class="fa-solid fa-capsules"></i>
                </div>
                <div>
                    <small>Total Medicines Ordered</small>
                    <h2>{{ $stats['medicines'] ?? $orders->count() }}</h2>
                </div>
            </div>
            <div class="card">
                <div class="icon navy">
                    <i class="fa-solid fa-flask"></i>
                </div>
                <div>
                    <small>Total Lab Tests</small>
                    <h2>{{ $stats['lab_tests'] ?? $labRequests->count() }}</h2>
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
                    @forelse($appointments as $appointment)
                    <tr>
                        <td class="order-id">Dr {{ $appointment->doctor?->doctor_name ?? 'Doctor' }}<br><span class="green1">ID#APT{{ str_pad($appointment->id, 4, '0', STR_PAD_LEFT) }}</span></td>
                        <td>{{ $appointment->doctor?->specialty ?? 'General' }}</td>
                        <td>
                            @if($appointment->doctor_schedule)
                                {{ \Carbon\Carbon::parse($appointment->doctor_schedule->date)->format('d M Y') }}
                                @if($appointment->doctor_schedule->start_time)
                                    <br><small style="color:#64748b;">{{ \Carbon\Carbon::parse($appointment->doctor_schedule->start_time)->format('H:i') }}</small>
                                @endif
                            @else
                                {{ $appointment->created_at?->format('d M Y') ?? 'N/A' }}
                            @endif
                        </td>
                        <td>{{ $appointment->reason ?? 'Consultation' }}</td>
                        <td>
                            @if($appointment->doctor_schedule?->price)
                                {{ number_format($appointment->doctor_schedule->price, 0, '.', ' ') }} FCFA
                            @elseif($appointment->doctor?->consultation_fee)
                                {{ number_format($appointment->doctor->consultation_fee, 0, '.', ' ') }} FCFA
                            @else
                                0 FCFA
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #64748b; padding: 24px;">No appointments booked yet.</td>
                    </tr>
                    @endforelse
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
                    @forelse($orders as $order)
                    <tr>
                        <td class="order-id"><span class="green1">{{ $order->order_number ?? ('MED' . str_pad($order->id, 3, '0', STR_PAD_LEFT)) }}</span></td>
                        <td>
                            @php
                                $medNames = $order->items->map(fn($item) => $item->medicine?->name ?? 'Medicine')->filter()->join(', ');
                            @endphp
                            {{ $medNames ?: 'Medicine Order' }}
                        </td>
                        <td>{{ $order->created_at ? $order->created_at->format('d M Y') : 'N/A' }}</td>
                        <td>{{ number_format((float)$order->total_amount, 0, '.', ' ') }} FCFA</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #64748b; padding: 24px;">No medicines ordered yet.</td>
                    </tr>
                    @endforelse
            </tbody>
        </table>
    </div>

     <div class="tab-content" id="lab-records" style="display: none">
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
                    @forelse($labRequests as $request)
                    <tr>
                        <td class="order-id"><span class="green1">{{ $request->request_number ?? ('LT' . str_pad($request->id, 4, '0', STR_PAD_LEFT)) }}</span></td>
                        <td>
                            @php
                                $testNames = $request->items->map(fn($item) => $item->test_name ?? $item->test?->name ?? 'Lab Test')->filter()->join(', ');
                            @endphp
                            {{ $testNames ?: 'Lab Test' }}
                        </td>
                        <td>{{ $request->created_at ? $request->created_at->format('d M Y') : 'N/A' }}</td>
                        <td>
                            @if($request->scheduled_date)
                                {{ \Carbon\Carbon::parse($request->scheduled_date)->format('d M Y') }}
                                @if($request->scheduled_time)
                                    <br><small style="color:#64748b;">{{ $request->scheduled_time }}</small>
                                @endif
                            @else
                                {{ $request->created_at ? $request->created_at->format('d M Y') : 'N/A' }}
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #64748b; padding: 24px;">No lab results yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>

@endsection
@section('scripts')
<script>
     function showTab(tabId, button){
        // hide all tab contents
        let tabs = document.querySelectorAll('.tab-content');
        tabs.forEach(tab => {
            tab.style.display = 'none';
        });
        //remove highlight from all buttons
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
        const firstButton = document.querySelector(".tab-btn");
        showTab("recent-appointments", firstButton);
    };
</script>
@endsection