<?php 
require_once '../config.php';
checkAdminLogin();
require_once '../includes/header.php'; 
?>

<div class="container-fluid">
    <div class="row">
        <?php require_once '../includes/sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Dashboard</h1>
            </div>

            <!-- Stats Cards -->
            <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 mb-4">
                <div class="col">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Students</h5>
                                    <h2 class="mb-0">
                                        <?php 
                                        $result = $conn->query("SELECT COUNT(*) FROM students");
                                        echo $result->fetch_row()[0];
                                        ?>
                                    </h2>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Professors</h5>
                                    <h2 class="mb-0">
                                        <?php 
                                        $result = $conn->query("SELECT COUNT(*) FROM professors");
                                        echo $result->fetch_row()[0];
                                        ?>
                                    </h2>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Courses</h5>
                                    <h2 class="mb-0">
                                        <?php 
                                        $result = $conn->query("SELECT COUNT(*) FROM courses");
                                        echo $result->fetch_row()[0];
                                        ?>
                                    </h2>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title">Enrollments</h5>
                                    <h2 class="mb-0">
                                        <?php 
                                        $result = $conn->query("SELECT COUNT(*) FROM enrollments");
                                        echo $result->fetch_row()[0];
                                        ?>
                                    </h2>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Recent Enrollments</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Student</th>
                                            <th>Course</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result = $conn->query("
                                            SELECT e.enrollment_date, s.first_name, s.last_name, c.course_name
                                            FROM enrollments e
                                            JOIN students s ON e.student_id = s.student_id
                                            JOIN class_schedules cs ON e.class_id = cs.class_id
                                            JOIN courses c ON cs.course_id = c.course_id
                                            ORDER BY e.enrollment_date DESC
                                            LIMIT 5
                                        ");
                                        
                                        while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                                                <td><?= $row['course_name'] ?></td>
                                                <td><?= date('M d, Y', strtotime($row['enrollment_date'])) ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5>Active Classes</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Course</th>
                                            <th>Professor</th>
                                            <th>Schedule</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $result = $conn->query("
                                            SELECT c.course_name, p.first_name, p.last_name, cs.day, cs.time_start, cs.time_end
                                            FROM class_schedules cs
                                            JOIN courses c ON cs.course_id = c.course_id
                                            JOIN professors p ON cs.professor_id = p.professor_id
                                            LIMIT 5
                                        ");
                                        
                                        while ($row = $result->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= $row['course_name'] ?></td>
                                                <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                                                <td><?= $row['day'] . ' ' . date('h:i A', strtotime($row['time_start'])) . '-' . date('h:i A', strtotime($row['time_end'])) ?></td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>