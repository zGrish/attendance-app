<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once $path."/attendanceapp/database/database.php";
require_once $path."/attendanceapp/database/sessionDetails.php";
require_once $path."/attendanceapp/database/facultyDetails.php";
require_once $path."/attendanceapp/database/courseRegistrationDetails.php";
require_once $path."/attendanceapp/database/attendanceDetails.php";

function createCSVReport($list, $filename)
{
    $error = 0;
    $path = $_SERVER['DOCUMENT_ROOT'];
    $finalFileName = $path . $filename;
    try {
        $fp = fopen($finalFileName, "w");
        foreach ($list as $line) {
            fputcsv($fp, $line);
        }
        fclose($fp);
    } catch (Exception $e) {
        $error = 1;
    }
}

if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];

    if ($action == "getSession") {
        // Fetch the sessions from DB and return to client
        $dbo = new Database();
        $sobj = new SessionDetails();
        $rv = $sobj->getSessions($dbo);
        echo json_encode($rv);
    }

    if ($action == "getFacultyCourses") {
        // Fetch the courses taken by fac in sess
        $facid = $_POST['facid'];
        $sessionid = $_POST['sessionid'];
        $dbo = new Database();
        $fo = new faculty_details();
        $rv = $fo->getCoursesInASession($dbo, $sessionid, $facid);
        echo json_encode($rv);
    }

    if ($action == "getStudentList") {
        // Fetch the courses taken by fac in sess
        $classid = $_POST['classid'];
        $sessionid = $_POST['sessionid'];
        $facid = $_POST['facid'];
        $ondate = $_POST['ondate'];
        $dbo = new Database();
        $crgo = new CourseRegistrationDetails();
        $allstudents = $crgo->getRegisteredStudents($dbo, $sessionid, $classid);

        // Get the attendance of these students on that day by the fac
        $ado = new attendanceDetails();
        $presentStudents = $ado->getPresentListOfAClassByAFacOnADate($dbo, $sessionid, $classid, $facid, $ondate);

        // Mark students as present or absent
        foreach ($allstudents as &$student) {
            $student['isPresent'] = 'NO'; // Default to 'NO'
            foreach ($presentStudents as $present) {
                if ($student['id'] == $present['student_id']) {
                    $student['isPresent'] = 'YES';
                    break;
                }
            }
        }

        echo json_encode($allstudents);
    }

    if ($action == "saveattendance") {
        // Fetch the courses taken by fac in sess
        $courseid = $_POST['courseid'];
        $sessionid = $_POST['sessionid'];
        $studentid = $_POST['studentid'];
        $facultyid = $_POST['facultyid'];
        $ondate = $_POST['ondate'];
        $status = $_POST['ispresent'];
        $dbo = new Database();
        $ado = new attendanceDetails();
        $rv = $ado->saveAttendance($dbo, $sessionid, $courseid, $facultyid, $studentid, $ondate, $status);
        echo json_encode($rv);
    }

    if ($action == "downloadReport") {
        // Fetch the courses taken by fac in sess
        $courseid = $_POST['classid'];
        $sessionid = $_POST['sessionid'];
        $facultyid = $_POST['facid'];
        
        $dbo = new Database();
        $ado = new attendanceDetails();
        $list = $ado->getAttendanceReport($dbo, $sessionid, $courseid, $facultyid); // Fetch data dynamically from DB

        // Generate the CSV report
        $filename = "/attendanceapp/report.csv";
        $rv = ["filename" => $filename];
        createCSVReport($list, $filename);
        echo json_encode($rv);
    }
}
?>