@extends('admin_layout.index')

@section('content')

 <div class="app">

    <main class="main">

        <section class="page">

            <h1 class="page-title">Manage Doctor Accounts</h1>

            <p class="page-subtitle">
                Create, update, activate, deactivate or delete doctor accounts.
            </p>

            {{-- SUCCESS MESSAGE --}}
           
            @if (session('success'))
                <div class="alert alert-success" id="success-message">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>

                <script>
                    setTimeout(function () {
                        const message = document.getElementById('success-message');

                        if (message) {
                            message.style.opacity = '0';

                            setTimeout(function () {
                                message.remove();
                            }, 500);
                        }
                    }, 3000);
                </script>
            @endif

            <!-- Create Doctor Button -->
            <button popovertarget="my-modal" class="open-btn">
                Create Doctors
            </button>


            <!-- =========================
                 CREATE DOCTOR MODAL
            ========================== -->

            <div id="my-modal" popover class="modal-box">

                <div class="modal-content">

                    <form
                        method="POST"
                        action="{{ route('admin.doctors.store') }}"
                        class="doctor-form"
                    >

                        @csrf

                        <div class="form-title">
                            Create New Doctor Account
                        </div>


                        <!-- Validation Summary -->

                        @if ($errors->any())

                            <div class="alert alert-danger">

                                <strong>
                                    Please correct the following errors:
                                </strong>

                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>

                            </div>

                        @endif


                        <div class="form-grid">


                            <!-- Doctor Name -->

                            <div class="field full">

                                <label for="doctor_name">
                                    Doctor Name *
                                </label>

                                <input
                                    type="text"
                                    id="doctor_name"
                                    name="doctor_name"
                                    value="{{ old('doctor_name') }}"
                                    placeholder="Enter full name"
                                    autocomplete="name"
                                    required
                                >

                                @error('doctor_name')
                                    <small class="error-message">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            <!-- Specialty -->

                            <div class="field">

                                <label for="specialty">
                                    Specialty *
                                </label>

                                <select
                                    id="specialty"
                                    name="specialty"
                                    required
                                >

                                    <option value="">
                                        Select specialty
                                    </option>

                                    <option
                                        value="Cardiology"
                                        {{ old('specialty') == 'Cardiology' ? 'selected' : '' }}
                                    >
                                        Cardiology
                                    </option>

                                    <option
                                        value="Neurosurgery"
                                        {{ old('specialty') == 'Neurosurgery' ? 'selected' : '' }}
                                    >
                                        Neurosurgery
                                    </option>

                                    <option
                                        value="Pharmacy"
                                        {{ old('specialty') == 'Pharmacy' ? 'selected' : '' }}
                                    >
                                        Pharmacy
                                    </option>

                                    <option
                                        value="Laboratory"
                                        {{ old('specialty') == 'Laboratory' ? 'selected' : '' }}
                                    >
                                        Laboratory
                                    </option>

                                    <option
                                        value="Pediatrics"
                                        {{ old('specialty') == 'Pediatrics' ? 'selected' : '' }}
                                    >
                                        Pediatrics
                                    </option>

                                    <option
                                        value="Orthopedics"
                                        {{ old('specialty') == 'Orthopedics' ? 'selected' : '' }}
                                    >
                                        Orthopedics
                                    </option>

                                    <option
                                        value="Gynecology"
                                        {{ old('specialty') == 'Gynecology' ? 'selected' : '' }}
                                    >
                                        Gynecology
                                    </option>

                                    <option
                                        value="Neurology"
                                        {{ old('specialty') == 'Neurology' ? 'selected' : '' }}
                                    >
                                        Neurology
                                    </option>

                                </select>

                                @error('specialty')
                                    <small class="error-message">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            <!-- Qualification -->

                            <div class="field">

                                <label for="qualification">
                                    Qualification *
                                </label>

                                <input
                                    type="text"
                                    id="qualification"
                                    name="qualification"
                                    value="{{ old('qualification') }}"
                                    placeholder="Enter qualification"
                                    required
                                >

                                @error('qualification')
                                    <small class="error-message">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            <!-- Years Experience -->

                            <div class="field">

                                <label for="years_of_experience">
                                    Years of Experience *
                                </label>

                                <input
                                    type="number"
                                    id="years_of_experience"
                                    name="years_of_experience"
                                    value="{{ old('years_of_experience') }}"
                                    placeholder="Enter years of experience"
                                    min="0"
                                    max="70"
                                    required
                                >

                                @error('years_of_experience')
                                    <small class="error-message">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            <!-- Consultation Fee -->

                            <div class="field">

                                <label for="consultation_fee">
                                    Consultation Fee (XAF) *
                                </label>

                                <input
                                    type="number"
                                    id="consultation_fee"
                                    name="consultation_fee"
                                    value="{{ old('consultation_fee') }}"
                                    placeholder="Enter consultation fee"
                                    min="0"
                                    step="0.01"
                                    required
                                >

                                @error('consultation_fee')
                                    <small class="error-message">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            <!-- Username -->

                            <div class="field full">

                                <label for="username">
                                    Username *
                                </label>

                                <input
                                    type="text"
                                    id="username"
                                    name="username"
                                    value="{{ old('username') }}"
                                    placeholder="Enter username"
                                    required
                                >

                                @error('username')
                                    <small class="error-message">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            <!-- Status -->

                            <div class="field full">

                                <label for="status">
                                    Status *
                                </label>

                                <select
                                    id="status"
                                    name="status"
                                    required
                                >

                                    <option value="">
                                        Select status
                                    </option>

                                    <option
                                        value="active"
                                        {{ old('status') == 'active' ? 'selected' : '' }}
                                    >
                                        Active
                                    </option>

                                    <option
                                        value="inactive"
                                        {{ old('status') == 'inactive' ? 'selected' : '' }}
                                    >
                                        Inactive
                                    </option>

                                </select>

                                @error('status')
                                    <small class="error-message">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>


                        <!-- Save -->

                        <div class="save-row">

                            <button
                                type="submit"
                                class="btn btn-primary save-btn"
                            >

                                <i class="fa-regular fa-floppy-disk"></i>

                                Save Doctor

                            </button>

                        </div>


                        <div class="required-note">

                            <i class="fa-solid fa-circle-info"></i>

                            All fields marked with * are required.

                        </div>

                    </form>


                    <!-- Close Button -->

                    <button
                        popovertarget="my-modal"
                        popovertargetaction="hide"
                        class="close-btn"
                    >
                        Close
                    </button>

                </div>

            </div>


            <!-- =========================
                 DOCTORS TABLE
            ========================== -->

            <div class="doctors-layout">

                <div>

                    <table class="data-table">

                        <thead>

                            <tr>

                                <th></th>

                                <th>Doctor Name</th>

                                <th>Specialty</th>

                                <th>Experience</th>

                                <th>Fee (XAF)</th>

                                <th>Actions</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($doctors as $doctor)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td>
                                        {{ $doctor->doctor_name }}
                                    </td>

                                    <td>
                                        {{ $doctor->specialty }}
                                    </td>

                                    <td>
                                        {{ $doctor->years_of_experience }} years
                                    </td>

                                    <td>
                                        {{ number_format($doctor->consultation_fee, 0) }}
                                    </td>

                                    <td class="actions-cell">

                                        @if ($doctor->status === 'active')

                                            <span class="badge green">
                                                Active
                                            </span>

                                        @else

                                            <span class="badge red">
                                                Inactive
                                            </span>

                                        @endif


                                        {{-- ACTIVATE / DEACTIVATE BUTTON --}}

                                        <form
                                            method="POST"
                                            action="{{ route('admin.doctors.toggleStatus', $doctor->id) }}"
                                            style="display:inline;"
                                        >

                                            @csrf

                                            @method('PATCH')

                                            <button
                                                type="submit"
                                                class="icon-btn {{ $doctor->status === 'active' ? 'red' : 'green' }}"
                                                title="{{ $doctor->status === 'active' ? 'Deactivate doctor' : 'Activate doctor' }}"
                                            >

                                                @if ($doctor->status === 'active')

                                                    <i class="fa-solid fa-pause"></i>

                                                @else

                                                    <i class="fa-solid fa-play"></i>

                                                @endif

                                            </button>

                                        </form>


                                        {{-- =================================================
                                             DELETE DOCTOR ACCOUNT
                                             ================================================= --}}

                                        <form
                                            method="POST"
                                            action="{{ route('admin.doctors.delete', $doctor->id) }}"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this doctor account?');"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="icon-btn red"
                                                title="Delete doctor"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </button>

                                        </form>


                                        {{-- =================================================
                                             EDIT / UPDATE DOCTOR PROFILE BUTTON
                                             ================================================= --}}

                                        <button
                                            type="button"
                                            class="icon-btn orange"
                                            popovertarget="edit-doctor-{{ $doctor->id }}"
                                            title="Edit doctor profile"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                        </button>

                                    </td>

                                </tr>


                                <!-- =====================================================
                                     EDIT / UPDATE DOCTOR PROFILE MODAL
                                ====================================================== -->

                                <div
                                    id="edit-doctor-{{ $doctor->id }}"
                                    popover
                                    class="modal-box"
                                >

                                    <div class="modal-content">

                                        <form
                                            method="POST"
                                            action="{{ route('admin.doctors.update', $doctor->id) }}"
                                            class="doctor-form"
                                        >

                                            @csrf

                                            @method('PUT')


                                            <div class="form-title">
                                                Update Doctor Profile
                                            </div>


                                            <div class="form-grid">


                                                <!-- Doctor Name -->

                                                <div class="field full">

                                                    <label for="edit_doctor_name_{{ $doctor->id }}">
                                                        Doctor Name *
                                                    </label>

                                                    <input
                                                        type="text"
                                                        id="edit_doctor_name_{{ $doctor->id }}"
                                                        name="doctor_name"
                                                        value="{{ $doctor->doctor_name }}"
                                                        placeholder="Enter full name"
                                                        autocomplete="name"
                                                        required
                                                    >

                                                </div>


                                                <!-- Specialty -->

                                                <div class="field">

                                                    <label for="edit_specialty_{{ $doctor->id }}">
                                                        Specialty *
                                                    </label>

                                                    <select
                                                        id="edit_specialty_{{ $doctor->id }}"
                                                        name="specialty"
                                                        required
                                                    >

                                                        <option value="">
                                                            Select specialty
                                                        </option>

                                                        <option value="Cardiology"
                                                            {{ $doctor->specialty == 'Cardiology' ? 'selected' : '' }}>
                                                            Cardiology
                                                        </option>

                                                        <option value="Neurosurgery"
                                                            {{ $doctor->specialty == 'Neurosurgery' ? 'selected' : '' }}>
                                                            Neurosurgery
                                                        </option>

                                                        <option value="Pharmacy"
                                                            {{ $doctor->specialty == 'Pharmacy' ? 'selected' : '' }}>
                                                            Pharmacy
                                                        </option>

                                                        <option value="Laboratory"
                                                            {{ $doctor->specialty == 'Laboratory' ? 'selected' : '' }}>
                                                            Laboratory
                                                        </option>

                                                        <option value="Pediatrics"
                                                            {{ $doctor->specialty == 'Pediatrics' ? 'selected' : '' }}>
                                                            Pediatrics
                                                        </option>

                                                        <option value="Orthopedics"
                                                            {{ $doctor->specialty == 'Orthopedics' ? 'selected' : '' }}>
                                                            Orthopedics
                                                        </option>

                                                        <option value="Gynecology"
                                                            {{ $doctor->specialty == 'Gynecology' ? 'selected' : '' }}>
                                                            Gynecology
                                                        </option>

                                                        <option value="Neurology"
                                                            {{ $doctor->specialty == 'Neurology' ? 'selected' : '' }}>
                                                            Neurology
                                                        </option>

                                                    </select>

                                                </div>


                                                <!-- Qualification -->

                                                <div class="field">

                                                    <label for="edit_qualification_{{ $doctor->id }}">
                                                        Qualification *
                                                    </label>

                                                    <input
                                                        type="text"
                                                        id="edit_qualification_{{ $doctor->id }}"
                                                        name="qualification"
                                                        value="{{ $doctor->qualification }}"
                                                        placeholder="Enter qualification"
                                                        required
                                                    >

                                                </div>


                                                <!-- Years Experience -->

                                                <div class="field">

                                                    <label for="edit_experience_{{ $doctor->id }}">
                                                        Years of Experience *
                                                    </label>

                                                    <input
                                                        type="number"
                                                        id="edit_experience_{{ $doctor->id }}"
                                                        name="years_of_experience"
                                                        value="{{ $doctor->years_of_experience }}"
                                                        min="0"
                                                        max="70"
                                                        required
                                                    >

                                                </div>


                                                <!-- Consultation Fee -->

                                                <div class="field">

                                                    <label for="edit_fee_{{ $doctor->id }}">
                                                        Consultation Fee (XAF) *
                                                    </label>

                                                    <input
                                                        type="number"
                                                        id="edit_fee_{{ $doctor->id }}"
                                                        name="consultation_fee"
                                                        value="{{ $doctor->consultation_fee }}"
                                                        min="0"
                                                        step="0.01"
                                                        required
                                                    >

                                                </div>


                                                <!-- Username -->

                                                <div class="field full">

                                                    <label for="edit_username_{{ $doctor->id }}">
                                                        Username *
                                                    </label>

                                                    <input
                                                        type="text"
                                                        id="edit_username_{{ $doctor->id }}"
                                                        name="username"
                                                        value="{{ $doctor->username }}"
                                                        placeholder="Enter username"
                                                        required
                                                    >

                                                </div>


                                                <!-- Status -->

                                                <div class="field full">

                                                    <label for="edit_status_{{ $doctor->id }}">
                                                        Status *
                                                    </label>

                                                    <select
                                                        id="edit_status_{{ $doctor->id }}"
                                                        name="status"
                                                        required
                                                    >

                                                        <option
                                                            value="active"
                                                            {{ $doctor->status === 'active' ? 'selected' : '' }}
                                                        >
                                                            Active
                                                        </option>

                                                        <option
                                                            value="inactive"
                                                            {{ $doctor->status === 'inactive' ? 'selected' : '' }}
                                                        >
                                                            Inactive
                                                        </option>

                                                    </select>

                                                </div>

                                            </div>


                                            <!-- Update -->

                                            <div class="save-row">

                                                <button
                                                    type="submit"
                                                    class="btn btn-primary save-btn"
                                                >

                                                    <i class="fa-solid fa-pen"></i>

                                                    Update Doctor

                                                </button>

                                            </div>


                                            <div class="required-note">

                                                <i class="fa-solid fa-circle-info"></i>

                                                Update the doctor's information and save your changes.

                                            </div>

                                        </form>


                                        <!-- Close -->

                                        <button
                                            popovertarget="edit-doctor-{{ $doctor->id }}"
                                            popovertargetaction="hide"
                                            class="close-btn"
                                        >
                                            Cancel
                                        </button>

                                    </div>

                                </div>


                            @empty

                                <tr>

                                    <td colspan="6">
                                        No doctors found.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>


                    <!-- Pagination placeholder -->

                    <div class="pagination">

                        <span style="margin-right:8px;color:#66728a">

                            Showing {{ $doctors->count() }} doctors

                        </span>

                    </div>


                    <!-- Action Guide -->

                    <div class="action-guide">

                        <div class="guide-title">
                            Actions Guide
                        </div>

                        <div class="guide-grid">

                            <div class="guide-item">

                                <div class="guide-icon blue">
                                    <i class="fa-solid fa-pen"></i>
                                </div>

                                <div>

                                    <strong>
                                        Edit / Update
                                    </strong>

                                    <span>
                                        Update doctor information
                                    </span>

                                </div>

                            </div>


                            <div class="guide-item">

                                <div class="guide-icon red">
                                    <i class="fa-solid fa-pause"></i>
                                </div>

                                <div>

                                    <strong>
                                        Deactivate / Activate
                                    </strong>

                                    <span>
                                        Toggle account status
                                    </span>

                                </div>

                            </div>


                            <div class="guide-item">

                                <div class="guide-icon red">
                                    <i class="fa-solid fa-trash"></i>
                                </div>

                                <div>

                                    <strong>
                                        Delete
                                    </strong>

                                    <span>
                                        Permanently delete account
                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>

</div>

@endsection