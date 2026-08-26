```blade
@extends('admin_layout.index')

@section('content')

<section class="page">

    <h1 class="page-title">Manage Medicine Orders</h1>

    <p class="page-subtitle">
        View and manage all medicine orders placed by patients.
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
         ADD MEDICINE BUTTON
    ====================================================== -->

    <button popovertarget="my-modal" class="open-btn">
        Add Medicines
    </button>



    <!-- =====================================================
         CREATE MEDICINE MODAL
    ====================================================== -->

    <div id="my-modal" popover class="modal-box">

        <div class="modal-content">

            <form
                method="POST"
                action="{{ route('admin.medicines.store') }}"
                enctype="multipart/form-data"
                class="doctor-form"
            >

                @csrf


                <div class="form-title">
                    Add New Medicine to Pharmacy
                </div>



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


                    <!-- MEDICINE IMAGE -->

                    <div class="field full">

                        <label for="image">
                            Medicine Image
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



                    <!-- MEDICINE NAME -->

                    <div class="field full">

                        <label for="name">
                            Medicine Name *
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter medicine name"
                            required
                        >

                        @error('name')

                            <small class="error-message">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>



                    <!-- TYPE -->

                    <div class="field">

                        <label for="type">
                            Type *
                        </label>

                        <select id="type" name="type" required>

                            <option value="">
                                Select Type
                            </option>

                            @foreach([
                                'Tablets',
                                'Capsules',
                                'Syrup',
                                'Powder',
                                'Injection',
                                'Drips',
                                'Band',
                                'Cotton'
                            ] as $typeOption)

                                <option
                                    value="{{ $typeOption }}"
                                    {{ old('type') == $typeOption ? 'selected' : '' }}
                                >
                                    {{ $typeOption }}
                                </option>

                            @endforeach

                        </select>

                        @error('type')

                            <small class="error-message">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>



                    <!-- STOCK -->

                    <div class="field">

                        <label for="stock">
                            Stock Quantity *
                        </label>

                        <input
                            type="number"
                            id="stock"
                            name="stock"
                            value="{{ old('stock') }}"
                            placeholder="Enter stock quantity"
                            min="0"
                            required
                        >

                        @error('stock')

                            <small class="error-message">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>



                    <!-- PRICE -->

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
                            placeholder="Enter price"
                            min="0"
                            required
                        >

                        @error('price')

                            <small class="error-message">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>



                    <!-- EXPIRY DATE -->

                    <div class="field">

                        <label for="expiry_date">
                            Expiry Date *
                        </label>

                        <input
                            type="date"
                            id="expiry_date"
                            name="expiry_date"
                            value="{{ old('expiry_date') }}"
                            required
                        >

                        @error('expiry_date')

                            <small class="error-message">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>



                    <!-- DESCRIPTION -->

                    <div class="field full">

                        <label for="description">
                            Description
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            placeholder="Enter short description"
                            rows="3"
                        >{{ old('description') }}</textarea>

                        @error('description')

                            <small class="error-message">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                </div>



                <!-- FORM BUTTONS -->

                <div class="save-row">

                    <button
                        type="submit"
                        class="btn btn-primary save-btn"
                    >

                        <i class="fa-regular fa-floppy-disk"></i>

                        Save Medicine

                    </button>

                </div>


                <div class="required-note">

                    <i class="fa-solid fa-circle-info"></i>

                    All fields marked with * are required.

                </div>


            </form>



            <!-- CLOSE -->

            <button
                popovertarget="my-modal"
                popovertargetaction="hide"
                class="close-btn"
            >
                Close
            </button>

        </div>

    </div>



    <!-- =====================================================
         MEDICINES TABLE
    ====================================================== -->

    <div class="doctors-layout">

        <div>

            <table class="data-table">

                <thead>

                    <tr>

                        <th>Image</th>

                        <th>Medicine Name</th>

                        <th>Type</th>

                        <th>Stock</th>

                        <th>Price (FCFA)</th>

                        <th>Expiry</th>

                        <th>Actions</th>

                    </tr>

                </thead>



                <tbody>

                    @forelse($medicines as $med)

                        <tr>


                            <!-- IMAGE -->

                            <td>

                                @if($med->image)

                                    <img
                                        src="{{ asset('storage/' . $med->image) }}"
                                        alt="{{ $med->name }}"
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



                            <!-- NAME -->

                            <td>
                                <strong>
                                    {{ $med->name }}
                                </strong>
                            </td>



                            <!-- TYPE -->

                            <td>
                                {{ $med->type }}
                            </td>



                            <!-- STOCK -->

                            <td>
                                {{ $med->stock }}
                            </td>



                            <!-- PRICE -->

                            <td>
                                {{ number_format($med->price, 0, '.', ' ') }} FCFA
                            </td>



                            <!-- EXPIRY -->

                            <td>

                                {{ \Carbon\Carbon::parse($med->expiry_date)->format('Y-m-d') }}

                            </td>



                            <!-- =================================================
                                 THREE ACTION BUTTONS
                            ================================================== -->

                            <td class="actions-cell">


                                <!-- EDIT -->

                                <button
                                    type="button"
                                    class="icon-btn orange"
                                    popovertarget="edit-medicine-{{ $med->id }}"
                                    title="Edit medicine"
                                >

                                    <i class="fa-solid fa-pen"></i>

                                </button>



                                <!-- ACTIVATE / DEACTIVATE -->

                                <form
                                    method="POST"
                                    action="{{ route('admin.medicines.toggleStatus', $med->id) }}"
                                    style="display:inline;"
                                >

                                    @csrf

                                    @method('PATCH')


                                    <button
                                        type="submit"
                                        class="icon-btn {{ $med->status ? 'red' : 'green' }}"
                                        title="{{ $med->status ? 'Deactivate medicine' : 'Activate medicine' }}"
                                    >

                                        @if($med->status)

                                            <i class="fa-solid fa-pause"></i>

                                        @else

                                            <i class="fa-solid fa-play"></i>

                                        @endif

                                    </button>

                                </form>



                                <!-- DELETE -->

                                <form
                                    method="POST"
                                    action="{{ route('admin.medicines.delete', $med->id) }}"
                                    style="display:inline;"
                                    onsubmit="return confirm('Are you sure you want to delete this medicine?');"
                                >

                                    @csrf

                                    @method('DELETE')


                                    <button
                                        type="submit"
                                        class="icon-btn red"
                                        title="Delete medicine"
                                    >

                                        <i class="fa-solid fa-trash"></i>

                                    </button>

                                </form>


                            </td>


                        </tr>



                        <!-- =====================================================
                             EDIT MEDICINE MODAL
                        ====================================================== -->

                        <div
                            id="edit-medicine-{{ $med->id }}"
                            popover
                            class="modal-box"
                        >

                            <div class="modal-content">


                                <form
                                    method="POST"
                                    action="{{ route('admin.medicines.update', $med->id) }}"
                                    enctype="multipart/form-data"
                                    class="doctor-form"
                                >

                                    @csrf

                                    @method('PUT')


                                    <div class="form-title">
                                        Update Medicine
                                    </div>



                                    <div class="form-grid">


                                        <!-- IMAGE -->

                                        <div class="field full">

                                            <label>
                                                Medicine Image
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

                                            @if($med->image)

                                                <small style="display:block;margin-top:8px;">

                                                    Current image:

                                                    <img
                                                        src="{{ asset('storage/' . $med->image) }}"
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
                                                Medicine Name *
                                            </label>

                                            <input
                                                type="text"
                                                name="name"
                                                value="{{ $med->name }}"
                                                required
                                            >

                                        </div>



                                        <!-- TYPE -->

                                        <div class="field">

                                            <label>
                                                Type *
                                            </label>

                                            <select name="type" required>

                                                @foreach([
                                                    'Tablets',
                                                    'Capsules',
                                                    'Syrup',
                                                    'Powder',
                                                    'Injection',
                                                    'Drips',
                                                    'Band',
                                                    'Cotton'
                                                ] as $typeOption)

                                                    <option
                                                        value="{{ $typeOption }}"
                                                        {{ $med->type == $typeOption ? 'selected' : '' }}
                                                    >
                                                        {{ $typeOption }}
                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>



                                        <!-- STOCK -->

                                        <div class="field">

                                            <label>
                                                Stock Quantity *
                                            </label>

                                            <input
                                                type="number"
                                                name="stock"
                                                value="{{ $med->stock }}"
                                                min="0"
                                                required
                                            >

                                        </div>



                                        <!-- PRICE -->

                                        <div class="field">

                                            <label>
                                                Price (FCFA) *
                                            </label>

                                            <input
                                                type="number"
                                                name="price"
                                                value="{{ $med->price }}"
                                                min="0"
                                                step="1"
                                                required
                                            >

                                        </div>



                                        <!-- EXPIRY -->

                                        <div class="field">

                                            <label>
                                                Expiry Date *
                                            </label>

                                            <input
                                                type="date"
                                                name="expiry_date"
                                                value="{{ \Carbon\Carbon::parse($med->expiry_date)->format('Y-m-d') }}"
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
                                                placeholder="Enter short description"
                                            >{{ $med->description }}</textarea>

                                        </div>



                                        <!-- STATUS -->

                                        <div class="field full">

                                            <label>
                                                Availability
                                            </label>

                                            <select name="status" required>

                                                <option
                                                    value="1"
                                                    {{ $med->status ? 'selected' : '' }}
                                                >
                                                    Available
                                                </option>

                                                <option
                                                    value="0"
                                                    {{ !$med->status ? 'selected' : '' }}
                                                >
                                                    Out of Stock
                                                </option>

                                            </select>

                                        </div>


                                    </div>



                                    <!-- UPDATE BUTTON -->

                                    <div class="save-row">

                                        <button
                                            type="submit"
                                            class="btn btn-primary save-btn"
                                        >

                                            <i class="fa-solid fa-pen"></i>

                                            Update Medicine

                                        </button>

                                    </div>


                                </form>



                                <!-- CLOSE -->

                                <button
                                    popovertarget="edit-medicine-{{ $med->id }}"
                                    popovertargetaction="hide"
                                    class="close-btn"
                                >
                                    Cancel
                                </button>


                            </div>

                        </div>


                    @empty

                        <tr>

                            <td
                                colspan="7"
                                style="text-align:center;"
                            >
                                No medicines found in pharmacy storage.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>



            <!-- =====================================================
                 MEDICINE COUNTER
            ====================================================== -->

            <div class="pagination">

                <span style="margin-right:8px;color:#66728a">

                    Showing {{ $medicines->count() }} medicines

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
                                Update medicine information
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
                                Toggle medicine availability
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
                                Permanently delete medicine
                            </span>

                        </div>

                    </div>


                </div>

            </div>


        </div>

    </div>

</section>

@endsection
```
