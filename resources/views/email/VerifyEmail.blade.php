@extends('.layouts.Email')
@section('header')
    <div class="header-grid">
        <span class="primaryTextColor headerText">
            School Inventory
            <br/>
            System
        </span>
    </div>
@endsection
@section('content')
    <div class="content-grid mt-4">
            <span class="hello lightGrayTextColor">
                Hello,
            </span>
        <span class="secondaryTextColor mt-1">
            Your account has been created on our system with
            <br/>
            Username: {{$email}}
            <br/>
            Password: {{$response}}
            <br/>
            Please click the following button to verify your email.
         </span>
        <a class="btn lightTextColor mt-2 text-center"
           href="{{ $reactBaseURL.'auth/verifyEmail?'. 'id='. $id.'&token='.$token }}">
            verify email address
        </a>
        <span class="secondaryTextColor mt-2">
            Regards,
            <br/>
            System Administrator
        </span>
    </div>
@endsection
@section('footer')
    <span class="secondaryTextColor">
        &copy; School Inventory System. All rights reserved.
        <br/>
        <span class="ml-1">School Inventory System, Tripureshwor</span>
    </span>
    <div class="mt-1">
        <div class="primaryTextColor footerText">
            School Inventory
            <br/>
            System
        </div>
    </div>
@endsection
