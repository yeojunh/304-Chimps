<!--Test Oracle file for UBC CPSC304 2018 Winter Term 1
  This file shows the very basics of how to execute PHP commands
  on Oracle.
  Specifically, it will drop a table, create a table, insert values
  update values, and then query for values

  IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the
  OCILogon below to be your ORACLE username and password -->

  <!-- chmod 755 ~/public_html/entities/program.php -->
  <!DOCTYPE html>
<html>
    <head>
        <title>Program Page</title>

        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

        <style>
            body {
                text-align: center;
                background-color: #8C8181;
            }

            .add-button {
                margin: 12px;
            }

            .container, .button {
                /* width: 50%; */
                position: relative;
                text-align: center;
                background-color: #BFB4B4;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin: 2rem;
                border-radius: 10px;
                outline: 5px solid black;
            }

            .main-menu {
                width: 200px;
                position: relative;
                text-align: center;
                background-color: #BFB4B4;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin: 2rem;
                border-radius: 10px;
                outline: 5px solid black;
            }

            .show-table, th, td {
                /* padding-bottom: 2rem;  */
                margin-top: -2rem;
                border: 1px solid; 
                position: relative;
            }

            .show-table {
                /* background-color: red; */
                position: relative;
                left: 12%;
            }

            .table-data table {
                text-align: center;

            }

        </style>
    </head>

    <body>
        <div class="tables">
            <form method="POST" action="../main.php">

                <div class="main-menu">
                    <h1>Back To Homepage</h1>
                    <div class="add-button">
                        <input type="submit" value="Go to home page!">    
                    </div>
                </div>
            </form>        
        </div>

        <div>
            
        </div>

        <div class="container reset-button">
            <h2>Reset Programs</h2>
            <p>Click here to reset the Program table</p>

            <form method="POST" action="program.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetRequest" name="resetRequest">
            <p><input type="submit" value="Reset" name="resetRequest"></p>
            </form>
        </div>
        
        <div class="container">
            <form method="POST" action="program.php">
                <h2>Add Program</h2>
                <p>Fill in the form with new Program details</p>
                <div>
                    <label for="programID"><b>Program ID</b></label>
                    <input type="number" name="programID">
                </div>
                <div>
                    <label for="programName"><b>Program Name</b></label>
                    <input type="text" name="programName">
                </div>
                <div>
                    <label for="frequency"><b>Frequency (# times/week)</b></label>
                    <input type="number" name="frequency">
                </div>
                <div>
                    <label for="programLocation"><b>Location</b></label>
                    <input type="text" name="programLocation">
                </div>
                <div>
                    <label for="purpose"><b>Purpose</b></label>
                    <input type="text" name="purpose">
                </div>
                <div>
                    <label for="tartgetAudience"><b>Target Audience</b></label>
                    <input type="text" name="targetAudience">
                </div>
                <div>
                    <label for="capacity"><b>Capacity</b></label>
                    <input type="number" name="capacity">
                </div>
                <div>
                    <label for="startDate"><b>Start Date</b></label>
                    <input type="date" name="startDate">
                </div>
                <div>
                    <label for="endDate"><b>End Date</b></label>
                    <input type="date" name="endDate">
                </div>

                <div class="add-button">
                    <input type="submit" name="addRequest" value="Add Program">    
                </div>
            </form>        
        </div>

        <!-- <div class="container">
            <h2>Delete Program</h2>
            <p>Enter in the Program ID of the Program you would like to delete</p>

            <form method="POST" action="program.php"> <!--refresh page when submitted-->
                <!-- <input type="hidden" id="deleteRequest" name="deleteRequest">
                Program ID: <input type="number" name="deleteSubmit"> <br /><br />
                <input type="submit" value="Delete" name="deleteSubmit"></p>
            </form>
        </div> --> 

        <div class="container">
            <h2>Count the Tuples in Program</h2>
            <form method="GET" action="program.php"> <!--refresh page when submitted-->
                <input type="hidden" id="countTupleRequest" name="countTupleRequest">
                <input type="submit" name="countTuples"></p>
            </form>
            <p><?php
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                }

                disconnectFromDB();
            }

            function countRequest():int {
                // $result = executePlainSQL("SELECT Count(*) FROM Customer");
    
                if (($row = oci_fetch_row($result)) != false) {
                    echo "<br>The number of tuples in program: " . $row[0] . "<br>";
                    echo $row[0]; 
                } else {
                    echo "<br>The number of tuples in program: 0"; 
                }
             }

             ?></p>
        </div>


        <div class="container">
            <h2>Show All Programs</h2>
            <p>Click here to see all the Programs in your table!</p>

            <form method="POST" action="program.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="showRequest" name="showRequest">
            <p><input type="submit" value="Show Programs" name="showRequest"></p>
            </form>

            <div class="internal-table">
                <?php
                if (isset($_POST['showRequest'])) {
                    if (connectToDB(array_key_exists('addRequest', $_POST))) {
                        if (array_key_exists('showRequest', $_POST)) {
                            $result = executePlainSQL("SELECT * FROM Program");
                            echo "<div class = 'table'>";
                            printInternalResult($result);
                            echo "</div>";
                        }
        
                        disconnectFromDB();
                    }
                }

                function printInternalResult($result) { //prints results from a select statement
                    $row = OCI_Fetch_Array($result, OCI_BOTH);
                    if(empty($row)) {
                        echo "<h2>The Program Table is Empty.</h2>";
                    } else {
                        echo "<h2>Retrieved data from the Program table:</h2>";
                        echo "<table class = 'show-table'>";
                        echo "<tr></tr>
                                <th>Program ID</th><br>
                                <th>Program Name</th><br>
                                <th>Frequency</th><br>
                                <th>Location</th><br>
                                <th>Purpose</th><br>
                                <th>Target Audience</th><br>
                                <th>Capacity</th><br>
                                <th>Start Date</th><br>
                                <th>End Date</th>
                            </tr>";
                        echo "<tr>
                                <td>" . $row[0] . "</td>
                                <td>" . $row[1] . "</td>
                                <td>" . $row[2] . "</td>
                                <td>" . $row[3] . "</td>
                                <td>" . $row[4] . "</td>
                                <td>" . $row[5] . "</td>
                                <td>" . $row[6] . "</td>
                                <td>" . $row[7] . "</td>
                                <td>" . $row[8] . "</td>
                            </tr>"; //or just use "echo $row[0]"
                        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) { 
                            echo "<tr>
                                    <td>" . $row[0] . "</td>
                                    <td>" . $row[1] . "</td>
                                    <td>" . $row[2] . "</td>
                                    <td>" . $row[3] . "</td>
                                    <td>" . $row[4] . "</td>
                                    <td>" . $row[5] . "</td>
                                    <td>" . $row[6] . "</td>
                                    <td>" . $row[7] . "</td>
                                    <td>" . $row[8] . "</td>
                                </tr>"; //or just use "echo $row[0]"
                        }
                        echo "</table>";
                        echo "<br>";
                    }
                }
                ?>
            </div>
        </div>

        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr);
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function printResult($result) { //prints results from a select statement
            //do nothing
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example,
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_bwang00", "a75734509", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        function handleCountRequest():int {
            $result = executePlainSQL("SELECT Count(*) FROM Program");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br>The number of tuples in Program: " . $row[0] . "<br>";
                return $row[0]; 
            } else {
                return 0; 
            }
        }

        // function handleUpdateRequest() {
        //     global $db_conn;

        //     $programID = $_POST['programID'];
        //     $newProgramName = $_POST['newProgramName'];
        //     $newFrequency = $_POST['newDateOfBirth'];
        //     $newLocation = $_POST['newLocation'];
        //     $newPurpose = $_POST['newPurpose'];
        //     $newTargetAudience = $_POST['newTargetAudience'];
        //     $newCapacity = $_POST['newCapacity'];
        //     $newStartDate = $_POST['newStartDate'];
        //     $newEndDate = $_POST['newEndDate'];


        //     // you need the wrap the old name and new name values with single quotations
        //     // don't we have to use CID?
            
        //     executePlainSQL("UPDATE Program SET ProgramName='" . $newProgramName . "' WHERE ProgramID='" . $programID . "'");
        //     executePlainSQL("UPDATE Program SET Frequency='" . $newFrequency . "' WHERE ProgramID='" . $programID . "'");
        //     executePlainSQL("UPDATE Program SET ProgramLocation='" . $newLocation . "' WHERE ProgramID='" . $programID . "'");
        //     executePlainSQL("UPDATE Program SET Purpose='" . $newPurpose . "' WHERE ProgramID='" . $programID . "'");
        //     executePlainSQL("UPDATE Program SET TargetAudience='" . $newTargetAudience . "' WHERE ProgramID='" . $programID . "'");
        //     executePlainSQL("UPDATE Program SET Capacity='" . $newCapacity . "' WHERE ProgramID='" . $programID . "'");
        //     executePlainSQL("UPDATE Program SET StartDate='" . $newStartDate . "' WHERE ProgramID='" . $programID . "'");
        //     executePlainSQL("UPDATE Program SET EndDate='" . $newEndDate . "' WHERE ProgramID='" . $programID . "'");

        //     OCICommit($db_conn);
        // }

        function handleResetRequest() {
            global $db_conn;
            // Drop old table
            executePlainSQL("DROP TABLE Program cascade constraints");

            // Create new table
            executePlainSQL("CREATE TABLE Program (
                ProgramID INTEGER,
                ProgramName CHAR(225) NOT NULL,
                Frequency INTEGER NOT NULL,
                ProgramLocation CHAR(255) NOT NULL,
                Purpose CHAR(255),
                TargetAudience CHAR(255),
                Capacity INTEGER NOT NULL,
                StartDate VARCHAR(255) NOT NULL,
                EndDate VARCHAR(255),
                PRIMARY KEY (ProgramID)
            )");

            OCICommit($db_conn);
        }

        // adds program into the Program table row 
        function handleAddRequest() {
            global $db_conn;

            $programID = $_POST['programID'];
            $programName = $_POST['programName'];
            $frequency = $_POST['frequency'];
            $programLocation = $_POST['programLocation'];
            $purpose = $_POST['purpose'];
            $targetAudience = $_POST['targetAudience'];
            $capacity = $_POST['capacity'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];

            if ($programID == NULL || $programName == NUL || $frequency == NULL || $programLocation == NULL || $capacity == NULL || $startDate == NULL) {
                return; 
            }

            $tuple = array (
                ":bind1" => $programID,
                ":bind2" => $programName,
                ":bind3" => $frequency,
                ":bind4" => $programLocation,
                ":bind5" => $purpose,
                ":bind6" => $targetAudience,
                ":bind7" => $capacity,
                ":bind8" => $startDate,
                ":bind9" => $endDate
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("INSERT INTO Program VALUES (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7, :bind8, :bind9)", $alltuples);
            OCICommit($db_conn);
        }
    
        function handleShowRequest() {
            $result = executePlainSQL("SELECT * FROM Program");
            printResult($result); 
        }

        // function handleDeleteRequest() {
        //     // sql to delete a record
        //     global $db_conn;
        //     $programID = $_POST['deleteSubmit'];

        //     executePlainSQL("DELETE FROM Program WHERE ProgramID ='" . $programID ."'");
        //     OCICommit($db_conn);
        // }


        // HANDLE ALL POST ROUTES
	    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB(array_key_exists('addRequest', $_POST))) {
                if (array_key_exists('addRequest', $_POST)) {
                    handleAddRequest();
                } else if (array_key_exists('resetRequest', $_POST)) {
                    handleResetRequest();
                // } else if (array_key_exists('updateRequest', $_POST)) {
                //     handleUpdateRequest();
                } else if (array_key_exists('showRequest', $_POST)) {
                    handleShowRequest();
                // } else if (array_key_exists('deleteRequest', $_POST)) {
                //     handleDeleteRequest();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['resetRequest']) || isset($_POST['addRequest']) || isset($_POST['showRequest'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest'])) {
            handleGETRequest();
        }

        function handleGETRequest() {
            if (connectToDB()) {
                // if (array_key_exists('countTuples', $_GET)) {
                //     handleCountRequest();
                // }

                disconnectFromDB();
            }
        }
		?>

    </body>

    </html>
