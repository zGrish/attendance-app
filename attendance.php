<?php
session_start();
if(isset($_SESSION["current_user"])) {
    $facid=$_SESSION["current_user"];
} else {
    header("location:"."/attendanceapp/login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance App</title>
    <style>
        /* Inline CSS converted from external stylesheet */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background-color: #c9d6ff;
            background: linear-gradient(to right, #e2e2e2, #c9d6ff);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            min-height: 100vh; /* Ensure the page height expands */
        }

        .page {
            background-color: #fff;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
            position: relative;
            overflow: hidden;
            width: 90%; /* Adjusted for responsiveness */
            max-width: 768px; /* Ensure maximum width for consistency */
            padding: 20px;
        }

        .header-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #512da8;
            color: #fff;
        }

        .logo-area {
            flex: 1;
        }

        .logout-area {
            flex: 1;
            text-align: right;
        }

        .btnlogout {
            background-color: #fff;
            color: #512da8;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 600;
            transition: background-color 0.3s, color 0.3s;
        }

        .btnlogout:hover {
            background-color: #512da8;
            color: #fff;
        }

        .session-area {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
        }

        .label-area {
            flex: 1;
        }

        .dropdown-area {
            flex: 2;
            text-align: right;
        }

        .ddlclass {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 12px;
        }

        .classlist-area {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            padding: 20px;
        }

        .classcard {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            cursor: pointer;
            font-size: 12px;
        }

        .classdetails-area {
            padding: 20px;
        }

        .classdetails {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
        }

        .code-area {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .title-area {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .ondate-area {
            margin-top: 10px;
        }

        .ondate-area input {
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 12px;
        }

        .studentlist-area {
            padding: 20px;
        }

        .studenttlist {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .studentdetails {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd; /* Add bottom border for separation */
            padding-bottom: 5px; /* Add padding for spacing */
        }

        .slno-area,
        .rollno-area,
        .name-area {
            flex: 1;
            padding: 8px;
            font-size: 12px;
        }

        .checkbox-area {
            flex: 1;
            text-align: right;
        }

        .checkbox-area input {
            margin-right: 10px;
        }

        .hidden {
            display: none;
        }

        .report-button {
            margin-top: 20px;
            text-align: center;
        }

        .btnreport {
            background-color: #512da8;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-transform: uppercase;
            font-weight: 600;
            transition: background-color 0.3s, color 0.3s;
        }

        .btnreport:hover {
            background-color: #311b92;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="header-area">
            <div class="logo-area">
                <h2 class="logo">ATTENDANCE APP</h2>
            </div>
            <div class="logout-area">
                <button class="btnlogout" id="btnLogout">LOGOUT</button>
            </div>
        </div>

        <div class="session-area">
            <div class="label-area">
                <label>SESSION</label>
            </div>
            <div class="dropdown-area">
                <select class="ddlclass" id="ddlclass">
                    <!-- <option>SELECT ONE</option>-->
                </select>
            </div>
        </div>

        <div class="classlist-area" id="classlistarea">
            <!--<div class="classcard">CS101</div>>-->
        </div>

        <div class="classdetails-area" id="classdetailsarea">
            <!--<div class="classdetails">-->
        </div>
        
        <div class="studentlist-area" id="studentlistarea">
            <!--<div class="studenttlist"><label>STUDENT LIST</label></div>-->
            <!--<div class="studentdetails"><div class="slno-area">001</div><div class="rollno-area">CSB21001</div><div class="name-area">PRAKASH KUMAR CHAUHAN</div><div class="checkbox-area">
                    <input type="checkbox">
                </div>
            </div>-->
        </div>

        <div class="report-button">
            <button class="btnreport" id="btnReport">Generate Report</button>
        </div>
    </div>

    <input type="hidden" id="hiddenFacId" value="<?php echo $facid; ?>">
    <input type="hidden" id="hiddenSelectedCourseID" value="-1">

    <script src="js/jquery.js"></script>
    <script src="js/attendance.js"></script>
</body>
</html>