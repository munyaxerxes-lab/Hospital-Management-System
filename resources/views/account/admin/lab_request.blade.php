@extends('admin_layout.index')

@section('content')

<section class="page" style="padding-bottom: 50px;">

<h1 class="page-title">Manage Lab Tests</h1>

<p class="page-subtitle">
    Create and manage laboratory tests available to patients.
</p>


<!-- =====================================================
     SUCCESS MESSAGE
====================================================== -->

@if(session('success'))

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



<!-- =====================================================
     ADD LAB TEST BUTTON
====================================================== -->

<button popovertarget="my-modal" class="open-btn">
    Add Lab Test
</button>



<!-- =====================================================
     CREATE LAB TEST MODAL
====================================================== -->

<div id="my-modal" popover class="modal-box">

    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fa-solid fa-flask"></i>
                Add New Laboratory Test
            </h3>
            <button type="button" popovertarget="my-modal" popovertargetaction="hide" class="modal-close-x" title="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form
            method="POST"
            action="{{ route('admin.lab_tests.store') }}"
            enctype="multipart/form-data"
            class="doctor-form"
        >

            @csrf

            <div class="modal-body">



            <!-- VALIDATION SUMMARY -->

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


                <!-- =================================================
                     TEST IMAGE
                ================================================== -->

                <div class="field full">

                    <label for="image">
                        Lab Test Image
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept="image/*"
                        style="
                            border:1px dashed #ccc;
                            padding:10px;
                            width:100%;
                            height:3rem;
                            border-radius:4px;
                        "
                    >

                    @error('image')

                        <small class="error-message">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                <!-- =================================================
                     TEST NAME
                ================================================== -->

                <div class="field full">

                    <label for="name">
                        Test Name *
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter laboratory test name"
                        required
                    >

                    @error('name')

                        <small class="error-message">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                <!-- =================================================
                     CATEGORY
                ================================================== -->

                <div class="field">

                    <label for="category">
                        Category *
                    </label>

                    <select
                        id="category"
                        name="category"
                        required
                    >

                        <option value="">
                            Select Category
                        </option>

                        @foreach([
                            'Hematology',
                            'Microbiology',
                            'Parasitology',
                            'Biochemistry',
                            'Immunology',
                            'Serology',
                            'Urinalysis',
                            'Other'
                        ] as $categoryOption)

                            <option
                                value="{{ $categoryOption }}"
                                {{ old('category') == $categoryOption ? 'selected' : '' }}
                            >
                                {{ $categoryOption }}
                            </option>

                        @endforeach

                    </select>

                    @error('category')

                        <small class="error-message">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                <!-- =================================================
                     PRICE
                ================================================== -->

                <div class="field">

                    <label for="price">
                        Price (FCFA) *
                    </label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        step="1"
                        value="{{ old('price') }}"
                        placeholder="Enter test price"
                        min="0"
                        required
                    >

                    @error('price')

                        <small class="error-message">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                <!-- =================================================
                     DESCRIPTION
                ================================================== -->

                <div class="field full">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        placeholder="Enter a short description of the laboratory test"
                        rows="3"
                    >{{ old('description') }}</textarea>

                    @error('description')

                        <small class="error-message">
                            {{ $message }}
                        </small>

                    @enderror

                </div>



                <!-- =================================================
                     PREPARATION
                ================================================== -->

                <div class="field full">

                    <label for="preparation">
                        Preparation Instructions
                    </label>

                    <textarea
                        id="preparation"
                        name="preparation"
                        placeholder="Enter any preparation instructions for the patient"
                        rows="3"
                    >{{ old('preparation') }}</textarea>

                    @error('preparation')

                        <small class="error-message">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


            </div>



                <div class="required-note">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>All fields marked with * are required.</span>
                </div>

            </div>

            <!-- Modal Footer Actions -->
            <div class="modal-footer">
                <button
                    type="button"
                    popovertarget="my-modal"
                    popovertargetaction="hide"
                    class="close-btn"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="save-btn"
                >
                    <i class="fa-regular fa-floppy-disk"></i>
                    <span>Save Lab Test</span>
                </button>
            </div>

        </form>

    </div>

</div>



<!-- =====================================================
     LAB TESTS TABLE
====================================================== -->

<div class="doctors-layout">

    <div>

        <table class="data-table">

            <thead>

                <tr>

                    <!-- IMAGE FIRST -->

                    <th>Image</th>

                    <th>Test Name</th>

                    <th>Category</th>

                    <th>Price (FCFA)</th>

                    <th>Status</th>

                    <th>Actions</th>

                </tr>

            </thead>



            <tbody>

                @forelse($lab_tests as $test)

                    <tr>


                        <!-- =================================================
                             IMAGE
                        ================================================== -->

                        <td>

                            @if($test->image)

                                <img
                                    src="{{ asset('storage/' . $test->image) }}"
                                    alt="{{ $test->name }}"
                                    style="
                                        width:50px;
                                        height:50px;
                                        object-fit:cover;
                                        border-radius:6px;
                                        border:1px solid #e5e7eb;
                                    "
                                >

                            @else

                                <div
                                    style="
                                        width:50px;
                                        height:50px;
                                        background:#e5e7eb;
                                        border-radius:6px;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                        font-size:10px;
                                        color:#6b7280;
                                        font-weight:bold;
                                    "
                                >
                                    NO IMG
                                </div>

                            @endif

                        </td>



                        <!-- =================================================
                             TEST NAME
                        ================================================== -->

                        <td>

                            <strong>
                                {{ $test->name }}
                            </strong>

                        </td>



                        <!-- =================================================
                             CATEGORY
                        ================================================== -->

                        <td>
                            {{ $test->category }}
                        </td>



                        <!-- =================================================
                             PRICE
                        ================================================== -->

                        <td>

                            {{ number_format($test->price, 0, '.', ' ') }}

                            FCFA

                        </td>



                        <!-- =================================================
                             STATUS
                        ================================================== -->

                        <td>

                            @if($test->status)

                                <span class="badge green">
                                    Available
                                </span>

                            @else

                                <span class="badge orange">
                                    Unavailable
                                </span>

                            @endif

                        </td>



                        <!-- =================================================
                             ACTIONS
                        ================================================== -->

                        <td class="actions-cell">


                            <!-- EDIT -->

                            <button
                                type="button"
                                class="icon-btn orange"
                                popovertarget="edit-lab-test-{{ $test->id }}"
                                title="Edit lab test"
                            >

                                <i class="fa-solid fa-pen"></i>

                            </button>



                            <!-- ACTIVATE / DEACTIVATE -->

                            <form
                                method="POST"
                                action="{{ route('admin.lab_tests.toggleStatus', $test->id) }}"
                                style="display:inline;"
                            >

                                @csrf

                                @method('PATCH')

                                <button
                                    type="submit"
                                    class="icon-btn {{ $test->status ? 'red' : 'green' }}"
                                    title="{{ $test->status ? 'Deactivate lab test' : 'Activate lab test' }}"
                                >

                                    @if($test->status)

                                        <i class="fa-solid fa-pause"></i>

                                    @else

                                        <i class="fa-solid fa-play"></i>

                                    @endif

                                </button>

                            </form>



                            <!-- DELETE TRIGGER -->
                            <button
                                type="button"
                                class="icon-btn red"
                                popovertarget="delete-lab-{{ $test->id }}"
                                title="Delete lab test"
                            >
                                <i class="fa-solid fa-trash"></i>
                            </button>

                        </td>

                    </tr>

                    <!-- =====================================================
                         DELETE LAB TEST CONFIRMATION MODAL
                    ====================================================== -->
                    <div id="delete-lab-{{ $test->id }}" popover class="alert-modal-box">
                        <div class="alert-modal-content">
                            <div class="alert-modal-icon">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </div>
                            <h3 class="alert-modal-title">Delete Laboratory Test</h3>
                            <p class="alert-modal-desc">
                                Are you sure you want to delete <strong>{{ $test->test_name }}</strong>?
                            </p>
                            <div class="alert-modal-box-warning">
                                <strong>Warning:</strong> This lab test will be removed from patient requisition catalogs.
                            </div>
                            <div class="alert-modal-actions">
                                <button type="button" popovertarget="delete-lab-{{ $test->id }}" popovertargetaction="hide" class="btn-modal-cancel">
                                    Cancel
                                </button>
                                <form method="POST" action="{{ route('admin.lab_tests.delete', $test->id) }}" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-modal-danger">
                                        <i class="fa-solid fa-trash"></i> Yes, Delete Test
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- =====================================================
                         EDIT LAB TEST MODAL
                    ====================================================== -->

                    <div
                        id="edit-lab-test-{{ $test->id }}"
                        popover
                        class="modal-box"
                    >

                        <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h3 class="modal-title">
                                    <i class="fa-solid fa-flask-vial"></i>
                                    Update Laboratory Test
                                </h3>
                                <button type="button" popovertarget="edit-lab-test-{{ $test->id }}" popovertargetaction="hide" class="modal-close-x" title="Close">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <form
                                method="POST"
                                action="{{ route('admin.lab_tests.update', $test->id) }}"
                                enctype="multipart/form-data"
                                class="doctor-form"
                            >

                                @csrf

                                @method('PUT')

                                <div class="modal-body">



                                <div class="form-grid">


                                    <!-- IMAGE -->

                                    <div class="field full">

                                        <label>
                                            Lab Test Image
                                        </label>

                                        <input
                                            type="file"
                                            name="image"
                                            accept="image/*"
                                            style="
                                                border:1px dashed #ccc;
                                                padding:10px;
                                                width:100%;
                                                height:3rem;
                                                border-radius:4px;
                                            "
                                        >

                                        @if($test->image)

                                            <small style="display:block;margin-top:8px;">

                                                Current image:

                                                <img
                                                    src="{{ asset('storage/' . $test->image) }}"
                                                    alt="{{ $test->name }}"
                                                    style="
                                                        width:40px;
                                                        height:40px;
                                                        object-fit:cover;
                                                        vertical-align:middle;
                                                        margin-left:8px;
                                                        border-radius:4px;
                                                    "
                                                >

                                            </small>

                                        @endif

                                    </div>



                                    <!-- NAME -->

                                    <div class="field full">

                                        <label>
                                            Test Name *
                                        </label>

                                        <input
                                            type="text"
                                            name="name"
                                            value="{{ $test->name }}"
                                            required
                                        >

                                    </div>



                                    <!-- CATEGORY -->

                                    <div class="field">

                                        <label>
                                            Category *
                                        </label>

                                        <select name="category" required>

                                            @foreach([
                                                'Hematology',
                                                'Microbiology',
                                                'Parasitology',
                                                'Biochemistry',
                                                'Immunology',
                                                'Serology',
                                                'Urinalysis',
                                                'Other'
                                            ] as $categoryOption)

                                                <option
                                                    value="{{ $categoryOption }}"
                                                    {{ $test->category == $categoryOption ? 'selected' : '' }}
                                                >
                                                    {{ $categoryOption }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>



                                    <!-- PRICE -->

                                    <div class="field">

                                        <label>
                                            Price (FCFA) *
                                        </label>

                                        <input
                                            type="number"
                                            name="price"
                                            value="{{ $test->price }}"
                                            min="0"
                                            step="1"
                                            required
                                        >

                                    </div>



                                    <!-- DESCRIPTION -->

                                    <div class="field full">

                                        <label>
                                            Description
                                        </label>

                                        <textarea
                                            name="description"
                                            rows="3"
                                            placeholder="Enter test description"
                                        >{{ $test->description }}</textarea>

                                    </div>



                                    <!-- PREPARATION -->

                                    <div class="field full">

                                        <label>
                                            Preparation Instructions
                                        </label>

                                        <textarea
                                            name="preparation"
                                            rows="3"
                                            placeholder="Enter preparation instructions"
                                        >{{ $test->preparation }}</textarea>

                                    </div>



                                    <!-- STATUS -->

                                    <div class="field full">

                                        <label>
                                            Availability
                                        </label>

                                        <select name="status" required>

                                            <option
                                                value="1"
                                                {{ $test->status ? 'selected' : '' }}
                                            >
                                                Available
                                            </option>

                                            <option
                                                value="0"
                                                {{ !$test->status ? 'selected' : '' }}
                                            >
                                                Unavailable
                                            </option>

                                        </select>

                                    </div>


                                </div>



                                </div>

                                <!-- Modal Footer Actions -->
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        popovertarget="edit-lab-test-{{ $test->id }}"
                                        popovertargetaction="hide"
                                        class="close-btn"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        class="save-btn"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                        <span>Update Lab Test</span>
                                    </button>
                                </div>

                            </form>

                        </div>

                    </div>


                @empty

                    <tr>

                        <td
                            colspan="6"
                            style="text-align:center;"
                        >
                            No laboratory tests found.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>



        <!-- =====================================================
             LAB TEST COUNTER
        ====================================================== -->

        <div class="pagination">

            <span style="margin-right:8px;color:#66728a">

                Showing {{ $lab_tests->count() }} laboratory tests

            </span>

        </div>



        <!-- =====================================================
             ACTION GUIDE
        ====================================================== -->

        <div class="action-guide">

            <div class="guide-title">
                Actions Guide
            </div>


            <div class="guide-grid">


                <!-- EDIT -->

                <div class="guide-item">

                    <div class="guide-icon blue">

                        <i class="fa-solid fa-pen"></i>

                    </div>

                    <div>

                        <strong>
                            Edit
                        </strong>

                        <span>
                            Update laboratory test information
                        </span>

                    </div>

                </div>



                <!-- STATUS -->

                <div class="guide-item">

                    <div class="guide-icon red">

                        <i class="fa-solid fa-pause"></i>

                    </div>

                    <div>

                        <strong>
                            Activate / Deactivate
                        </strong>

                        <span>
                            Control test availability for patients
                        </span>

                    </div>

                </div>



                <!-- DELETE -->

                <div class="guide-item">

                    <div class="guide-icon red">

                        <i class="fa-solid fa-trash"></i>

                    </div>

                    <div>

                        <strong>
                            Delete
                        </strong>

                        <span>
                            Permanently delete laboratory test
                        </span>

                    </div>

                </div>


            </div>

        </div>


    </div>

</div>

</section>

@endsection
