@extends('layout.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Profil Anda
        </h1>
    </div>

    @include('partials.toaster')

    <!-- Profile Card -->
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-edit mr-2"></i>Kelola Profil & Password
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">
                                <i class="fas fa-user mr-2"></i>Update Profil
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="password-tab" data-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">
                                <i class="fas fa-key mr-2"></i>Ganti Password
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-4" id="profileTabContent">
                        <!-- Profile Form Tab -->
                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            @include('auth.profile.components.profile_form')
                        </div>

                        <!-- Password Form Tab -->
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            @include('auth.profile.components.update_password_form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#profileTab a').on('click', function (e) {
            e.preventDefault();
            window.location.hash = this.hash;
            $(this).tab('show');
        });

        var hash = window.location.hash;
        if (hash) {
            $('#profileTab a[href="' + hash + '"]').tab('show');
        }

        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        $('.form-control').on('blur', function() {
            if ($(this).val().trim() === '') {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
            }
        });

        $('.form-control').on('input', function() {
            $(this).removeClass('is-invalid is-valid');
        });
    });
</script>
@endpush
