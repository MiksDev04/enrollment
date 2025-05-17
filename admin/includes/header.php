<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Admin Panel</title>
    
    <!-- Bootstrap CSS -->
    <link href="../../bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-blue: #1a73e8;
            --secondary-blue: #0d47a1;
            --light-blue: #e8f0fe;
            --dark-blue: #0a2e5a;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: white !important;
        }
        
        .navbar {
            background-color: var(--primary-blue) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
        }
        
        .nav-link:hover {
            color: white !important;
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .dropdown-item:active {
            background-color: var(--light-blue);
            color: var(--dark-blue);
        }
        
        .sidebar {
            background-color: var(--light-blue);
            min-height: calc(100vh - 56px);
        }
        
        .sidebar .nav-link {
            color: var(--dark-blue) !important;
            font-weight: 500;
            border-radius: 5px;
            margin: 2px 0;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(26, 115, 232, 0.1);
        }
        
        .sidebar .nav-link.active {
            background-color: var(--primary-blue);
            color: white !important;
        }
        
        .sidebar .nav-link svg {
            margin-right: 8px;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .card-header {
            background-color: var(--primary-blue);
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-blue);
            border-color: var(--secondary-blue);
        }
        
        .table th {
            background-color: var(--light-blue);
            color: var(--dark-blue);
        }
        
        .profile-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark position-sticky top-0 z-3">

        <div class="container-fluid">
            <a class="navbar-brand" href="../dashboard/index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16" class="me-2">
                    <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zM5 12h1v1H5v-1zm2 0h1v1H7v-1zm-2 2h1v1H5v-1zm2 0h1v1H7v-1zm4-2h1v1h-1v-1zm-2 2h1v1h-1v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1v-1zm0 2h1v1h-1v-1z"/>
                </svg>
                University Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            
        </div>
    </nav>