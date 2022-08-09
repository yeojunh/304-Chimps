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

  <!-- chmod 755 ~/public_html/entities/membership.php -->
  <!DOCTYPE html>
<html>
    <head>
        <title>CPSC 304 All Queries</title>

        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

        <style>
            body {
                text-align: center;
                background-color: #00296b;
            }

            .add-membership-button {
                margin: 12px;
            }

            .membership, .membership-reset-button, .addmembershipTable {
                /* width: 50%; */
                position: relative;
                text-align: center;
                background-color: #daecff;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin: 2rem;
                border-radius: 10px;
                outline: 5px solid black;
            }

            .tables {
                width: 200px;
                position: relative;
                text-align: center;
                background-color: #daecff;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin: 2rem;
                border-radius: 10px;
                outline: 5px solid black;
            }

            .membershipTable, th, td {
                margin-top: -2rem;
                border: 1px solid; 
            }

        </style>
    </head>

    <body>
        <div class="tables">
            <form method="POST" action="../main.php">
                <div class="membership-container">
                    <h1>Back To Homepage</h1>
                    <div class="add-membership-button">
                        <input type="submit" value="Go to home page!">    
                    </div>
                </div>
            </form>        
        </div>

        <div>
            
        </div>

        <div class="membership membership-reset-button">
            <h2>Reset memberships</h2>
            <p>Click here to reset the memberships table</p>

            <form method="POST" action="membership.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetmembershipRequest" name="resetmembershipRequest">
            <p><input type="submit" value="Reset" name="resetmembership"></p>
            </form>
        </div>
        
        <div class="addmembershipTable">
            <form method="POST" action="membership.php"></form>

                <div class="container">
                    <h2>Add membership</h2>
                    <p>Fill in the form with new membership details</p>
                    <div>
                        <label for="membershipNum"><b>Membership Number</b></label>
                        <input type="text" name="membershipNum">
                    </div>
                    
                    <div>
                        <label for="customerID"><b>Customer Number</b></label>
                        <input type="text" name="customerID">
                    </div>

                    <div>
                        <label for="fcAccess"><b>Fitness Centre Access</b></label>
                        <input type="checkbox" name="fcAccess" value = "1">
                    </div>

                    <div>
                        <label for="pAccess"><b>Pool Access</b></label>
                        <input type="checkbox" name="pcAccess" value = "1">
                    </div>

                    <div>
                        <label for="gAccess"><b>Gym Access</b></label>
                        <input type="checkbox" name="gAccess" value = "1">
                    </div>

                    <div>
                        <label for="startDate"><b>Start Date</b></label>
                        <input type="date" name="startDate">
                    </div>

                    <div>
                        <label for="endDate"><b>End Date</b></label>
                        <input type="date" name="endDate">
                    </div>
                    <br>
                    <input type="submit" name="addmembershipRequest" value="Add Membership"></p> 
                </div>
            </form>        
        </div>

        <div class="membership updatemembership">
            <h2>Update Membership Information</h2>
            <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

            <form method="POST" action="membership.php"> <!--refresh page when submitted-->
                <input type="hidden" id="updatemembershipQueryRequest" name="updatemembershipQueryRequest">
                Membership ID: <input type="text" name="membershipID"> <br />

                Fitness Centre Access: <input type="checkbox" name="fcAccess" value="1"> <br />
                 
                Pool Access: <input type="checkbox" name="pcAccess" value="1"> <br />
                 
                Gym Access: <input type="checkbox" name="gAccess" value="1"> <br />
                
                Start Date: <input type="date" name="startDate"> <br />
                
                End Date: <input type="date" name="endDate"> <br /><br />
                <input type="submit" value="Update" name="updateSubmit"></p>
            </form>
        </div>

        <div class="membership">
            <h2>Delete Membership</h2>
            <p>Enter in the membership id of the membership you would like to delete</p>

            <form method="POST" action="membership.php"> <!--refresh page when submitted-->
                <input type="hidden" id="deletemembershipRequest" name="deletemembershipRequest">
                Membership ID: <input type="text" name="membershipID"> <br /><br />
                <input type="submit" value="Delete" name="deleteSubmit"></p>
            </form>
        </div>

        <div class="membership">
            <h2>Count the Tuples in Membership</h2>
            <form method="GET" action="membership.php"> <!--refresh page when submitted-->
                <input type="hidden" id="countTupleRequest" name="countTupleRequest">
                <input type="submit" name="countTuples"></p>
            </form>
        </div>

        <div class="membership show-all-memberships" id="show-all-memberships">
            <h2>Show All memberships</h2>
            <p>Click here to see all the memberships in your table!</p>

            <form method="POST" action="membership.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="showmemberships" name="showmembershipsRequest">
            <p><input type="submit" value="Show memberships" name="showmembershipsRequest"></p>
            </form>
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
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            if(empty($row)) {
                echo "<div class = 'membership'>";
                echo "<h2>The membership Table is Empty.</h2>";
            } else {
                echo "<div class = 'membership'>";
                echo "<h2>Retrieved data from the membership table:</h2>";
                echo "<table class = 'membershipTable'>";
                echo "<tr></tr>
                        <th>Membership ID</th><br>
                        <th>Customer ID</th><br>
                        <th>Fitness Centre Access</th>
                        <th>Aquatic Centre Access</th>
                        <th>Gymnasium Access</th>
                        <th>Start Date</th>
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
                    </tr>"; //or just use "echo $row[0]"
                }
                echo "</table>";
                echo "<br>";
                echo "</div>";
            }
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

        function handleUpdateRequest() {
            global $db_conn;

            $membership_num = $_POST['membershipNum'];
            if ($_POST['fcAccess'] == '1') {
                $fcAccess = 1;
            } else {
                $fcAccess = 0;
            }
            if ($_POST['pcAccess'] == '1') {
                $pcAccess = 1;
            } else {
                $pcAccess = 0;
            }
            if ($_POST['gAccess'] == '1') {
                $gAccess = 1;
            } else {
                $gAccess = 0;
            }

            $newStartDate = $_POST['startDate'];
            $newEndDate = $_POST['endDate'];

            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("UPDATE membership SET FitnessCentreAccess='" . $fcAccess . "' WHERE CustomerMembershipNum='" . $membership_num . "'");
            
            executePlainSQL("UPDATE membership SET PoolAccess='" . $pcAccess . "' WHERE CustomerMembershipNum='" . $membership_num . "'");
            
            executePlainSQL("UPDATE membership SET GymAccess='" . $gAccess . "' WHERE CustomerMembershipNum='" . $membership_num . "'");
            
            executePlainSQL("UPDATE membership SET StartDate='" . $newStartDate . "' WHERE CustomerMembershipNum='" . $membership_num . "'");
           
            executePlainSQL("UPDATE membership SET EndDate='" . $newEndDate . "' WHERE CustomerMembershipNum='" . $membership_num . "'");

            OCICommit($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            // Drop old table
            executePlainSQL("DROP TABLE Membership cascade constraints");

            // Create new table
            executePlainSQL("CREATE TABLE Membership (
                CustomerMembershipNum INTEGER PRIMARY KEY,
                CustomerID INTEGER NOT NULL,
                FitnessCentreAccess NUMBER(1),
                PoolAccess NUMBER(1),
                GymAccess NUMBER(1),
                StartDate VARCHAR(255) NOT NULL,
                EndDate VARCHAR(255),
                FOREIGN KEY (CustomerID) REFERENCES Customer (CustomerID) ON DELETE CASCADE
            )");



            OCICommit($db_conn);
        }

        // adds membership into the membership table row 
        function handleAddMembershipRequest() {
            global $db_conn;

            $membershipNum = $_POST['membershipNum'];
            $customerID = $_POST['customerID'];

            echo "fcaccess = " .$fcAccess . "type: " .gettype($fcAccess);
            echo "pcaccess = " .$pcAccess . "type: " .gettype($pcAccess);
            echo "gaccess = " .$gAccess . "type: " .gettype($gAccess); 

            if ($_POST['fcAccess'] == 1) {
                $fcAccess = 1;
            } else {
                $fcAccess = 0;
            }

            if ($_POST['pcAccess'] == 1) {
                $pcAccess = 1;
            } else {
                $pcAccess = 0;
            }


            if ($_POST['gAccess'] == 1) {
                $gAccess = 1;
            } else {
                $gAccess = 0;
            }
            echo "fcaccess = " .$fcAccess . "type: " .gettype($fcAccess);
            echo "pcaccess = " .$pcAccess . "type: " .gettype($pcAccess);
            echo "gaccess = " .$gAccess . "type: " .gettype($gAccess); 


            $newStartDate = $_POST['startDate'];
            $newEndDate = $_POST['endDate'];
            echo "membershipnum = " . $membershipNum;
            echo "customerID = " .$customerID;
            echo "fcaccess = " .$fcAccess;
            echo "pcaccess = " .$pcAccess;
            echo "gaccess = " .$gAccess; 
            echo "newstartdate = " .$newStartDate;
            echo "newenddate = " .$newEndDate; 
            
            if ($membership_num == NULL || $customerID == NUL || $newStartDate == NULL || $newEndDate == NULL) {
                return; 
            }

            $tuple = array (
                ":bind1" => $membership_num,
                ":bind2" => $customerID,
                ":bind3" => $pcAccess,
                ":bind4" => $fcAccess,
                ":bind5" => $gAccess,
                ":bind6" => $newStartDate,
                ":bind7" => $newEndDate
                
            );

            $alltuples = array (
                $tuple
            );
            executeBoundSQL("INSERT INTO Membership VALUES (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6, :bind7)", $alltuples);
            OCICommit($db_conn);
        }

        function handleCountRequest():int {
            $result = executePlainSQL("SELECT Count(*) FROM Membership");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br>The number of tuples in membership: " . $row[0] . "<br>";
                return $row[0]; 
            } else {
                return 0; 
            }
        }
    
        function handleShowmembershipsRequest() {
            $result = executePlainSQL("SELECT * FROM Membership");
            printResult($result); 
        }

        function handleDeletemembershipRequest() {
            // sql to delete a record
            global $db_conn;
            $membership_id = $_POST['membershipNum'];
            echo "". $membership_id."";
            

            executePlainSQL("DELETE FROM Membership WHERE CustomerMembershipNum ='" . $membership_id ."'");
            
            OCICommit($db_conn);
        }


        // HANDLE ALL POST ROUTES
        // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB(array_key_exists('addmembershipRequest', $_POST))) {
                if (array_key_exists('addmembershipRequest', $_POST)) {
                    handleAddMembershipRequest();
                } else if (array_key_exists('resetmembership', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateSubmit', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('showmembershipsRequest', $_POST)) {
                    handleShowmembershipsRequest();
                } else if (array_key_exists('deletemembershipRequest', $_POST)) {
                    handleDeletemembershipRequest();
                }

                disconnectFromDB();
            }
        }

    // HANDLE ALL GET ROUTES
    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                }

                disconnectFromDB();
            }
        }

        if (isset($_POST['resetmembership']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['addmembershipRequest']) || isset($_POST['showmembershipsRequest']) || isset($_POST['deletemembershipRequest'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest'])) {
            handleGETRequest();
        }
        ?>

    </body>

    </html>