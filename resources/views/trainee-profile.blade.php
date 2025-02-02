@extends('layouts.app')
@section('pageTitle', 'Profile')

@section('breadcrumbs', Breadcrumbs::render('profile'))

@section('content') 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .profile-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid #333;
            margin: 0 auto;
            display: block;
        }

        .profile-buttons {
            margin-top: 20px;
        }

        .profile-info {
            text-align: center;
            margin-top: 20px;
        }

        .profile-info h2 {
            margin: 0;
            color: #333;
        }

        .profile-info p {
            color: #777;
        }

        .profile-heading {
            border-bottom: 1px solid #333; 
            padding: 10px 0; 
        }

        .profile-heading h3 {
            margin: 0; 
            font-family: Arial, sans-serif;
        }

        /* Style for the message when there's no resume */
        .no-resume-message {
            color: #777;
            font-style: italic;
        }

        /* Style for the list of resume cards */
        .resume-cards {
            list-style: none;
            padding: 0;
        }

        /* Style for individual resume cards */
        .resume-card {
            margin-top: 10px;
        }

        /* Style for the resume links */
        .resume-link {
            color: blue;
            text-decoration: none;
        }

        /* Hover effect for resume links */
        .resume-link:hover {
            text-decoration: underline;
        }

        /* Style for the "No logbooks uploaded yet" message */
        .no-logbooks-message {
            color: #777;
            font-style: italic;
        }

        /* Style for the list of logbook cards */
        .logbook-cards {
            list-style: none;
            padding: 0;
        }

        /* Style for individual logbook cards */
        .logbook-card {
            margin-top: 10px;
        }

        /* Style for the logbook links */
        .logbook-link {
            color: blue;
            text-decoration: none;
        }

        /* Hover effect for logbook links */
        .logbook-link:hover {
            text-decoration: underline;
        }

        /* Style for the logbook created time */
        .logbook-created-time {
            color: #555;
        }

        .status-unsigned {
            background-color: red;
            color: white;
            padding: 4px 8px;
            border-radius: 50px;
        }

        .status-signed {
            background-color: #82eb82;
            color: white;
            padding: 4px 8px;
            border-radius: 50px;
        }

        /* Style for the comment labels */
        .comment-label {
            font-weight: bold;
            color: #333;
        }

        /* Style for the comment textarea */
        .comment-text {
            width: 100%; /* Expand the textarea to fill its container */
            min-height: 50px;
            height: auto;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-primary {
            margin-top: -10px;
            margin-bottom: 10px;
            background-color: #007BFF; 
            color: #fff;
            padding: 10px 20px;
            border: none; 
            border-radius: 5px; 
            text-decoration: none;
            cursor: pointer; 
        }

        .btn-primary:hover {
            background-color: #0056b3; 
        }
    </style>
</head>
<body>
    <div class="profile-container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-warning">{{ session('error') }}</div>
        @endif 
        <img class="profile-picture" src="{{ asset('storage/' . str_replace('public/', '', $trainee->profile_image)) }}" alt="Profile Picture">

        <div class="profile-heading">
            <h3>Information</h3>
        </div>

        <div class="profile-info" style="text-align: left;">  
            <p><strong>Full Name</strong>: {{ $trainee->name }} </p>
            <p><strong>Personal Email</strong>: {{ $trainee->personal_email }}</p>
            <p><strong>SAINS Email</strong>: {{ $trainee->sains_email }}</p>
            <p><strong>Phone Number</strong>: {{ $trainee->phone_number }}</p>
            <p><strong>Expertise</strong>: {{ $trainee->expertise }}</p>
            <p><strong>Internship Date (Start)</strong>: {{ $internship_dates->internship_start ?? '' }}
            <p><strong>Internship Date (End)</strong>: {{ $internship_dates->internship_end ?? '' }}
            <p><strong>Graduation Date</strong>: {{ $trainee->graduate_date }}</p>
        </div>

        <div class="profile-buttons">
            <a href="/trainee-edit-profile" class="btn btn-primary">Edit Profile</a>
        </div>

        <div class="profile-heading">
            <h3>Resume</h3>
        </div>

        @if ($trainee->resume_path == null)
            <p class="no-resume-message">You have not upload any resume yet.</p>
        @else
        <ul class="resume-cards">
            <li class="resume-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ asset($trainee->resume_path) }}" target="_blank" class="resume-link" style="color: blue;">
                                {{ pathinfo($trainee->resume_path, PATHINFO_BASENAME) }}
                            </a>
                        </h5>
                    </div>
                </div>
            </li>
        </ul> 
        @endif

        <div class="profile-buttons">
            <a href="/trainee-upload-resume" class="btn btn-primary">Upload Resume</a>
        </div>

        <div class="profile-heading">
            <h3>Logbook</h3>
        </div>

        @if ($logbooks->isEmpty())
            <p class="no-logbooks-message">No logbooks uploaded yet.</p>
        @else
        <ul class="logbook-cards">
            @foreach ($logbooks as $logbook)
            <li class="logbook-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ asset($logbook->logbook_path) }}" target="_blank" class="logbook-link" style="color: blue;">
                                {{ pathinfo($logbook->logbook_path, PATHINFO_BASENAME) }}
                            </a>
                        </h5>
                        <p class="card-text logbook-created-time">Uploaded at: {{ $logbook->created_at }}</p>
                        <p class="card-text logbook-created-time">
                            Status:
                            <span class="{{ $logbook->status === 'Unsigned' ? 'status-unsigned' : 'status-signed' }}">
                                {{ $logbook->status }}
                            </span>
                        </p>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>          
        @endif

        <div class="profile-buttons">
            <a href="/trainee-upload-logbook" class="btn btn-primary">Upload or Remove Logbook</a>
        </div>

        <div class="profile-heading">
            <h3>Task Timeline</h3>
        </div>

        <div class="profile-buttons">
            <a href="/trainee-task-timeline" class="btn btn-primary">View Task Timeline</a>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#upload-button').click(function() {
            $('#resume').click();
        });

        $('#resume').change(function() {
            // Submit the form when a file is selected (you may add additional validation here)
            $('#upload-form').submit();
        });
    });
</script>
</html>
@endsection