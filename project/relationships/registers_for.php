
  <!-- chmod 755 ~/public_html/relationships/purchases.php -->
  <!DOCTYPE html>
<html>
    <head>
        <title>CPSC 304 Purchases Relationship</title>

        <style>
            body {
                text-align: center;
                background-color: #92140C;
            }

            .add-purchases-button {
                margin: 12px;
            }

            .purchases, .purchases-reset-button, .addpurchasesTable {
                /* width: 50%; */
                position: relative;
                text-align: center;
                background-color: #FFF8F0;
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

        <div class="purchases purchases-reset-button">
            <h2>Reset Registers For</h2>
            <p>Click here to reset the purchases table</p>

            <form method="POST" action="registers_for.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetpurchasesRequest" name="resetpurchasesRequest">
            <p><input type="submit" value="Reset" name="resetpurchases"></p>
            </form>
        </div>
        
        <div class="addpurchasesTable">
            <form method="POST" action="registers_for.php">

                <div class="container">
                    <h2>Add Registration Relationship</h2>
                    <p>Fill in the form with new registration details</p>
                    <div>
                        <label for="membershipNum"><b>Customer Number</b></label>
                        <input type="text" name="customerID">
                        <!-- <input type="text" name="membershipNum"> -->
                    </div>
                    
                    <div>
                        <label for="customerNum"><b>Program ID</b></label>
                        <input type="text" name="programID">
                        <!-- <input type="text" name="customerNum"> -->
                    </div>

                </div>

                <div class="add-registration-button">
                    <input type="submit" name="addRegistrationRequest" value="Add registration">    
                </div>
                </form>       
        </div>


        <div class="purchases show-all-purchases" id="show-all-registrations">
            <h2>Show All Registrations</h2>
            <p>Click here to see all the registrations in your table!</p>

            <form method="POST" action="registers_for.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="showRegistrations" name="showRegistrationRequest">
            <p><input type="submit" value="Show registrations" name="showRegistrationRequest"></p>
            </form>
        </div>

        <!-- <h2>Insert Values into IceRinkTable</h2>
        <form method="POST" action="304project.php"> 
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Number: <input type="text" name="insNo"> <br /><br />
            Name: <input type="text" name="insName"> <br /><br />

            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form> -->

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

        function printRegistrationResult($result) { //prints results from a select statement
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            if(empty($row)) {
                echo "<div class = 'purchases'>";
                echo "<h2>The Registers For Table is Empty.</h2>";
            } else {
                echo "<div class = 'purchases'>";
                echo "<h2>Retrieved data from the registers_for table:</h2>";
                echo "<table class = 'purchases'>";
                echo "<tr></tr>
                        <th>customer ID</th><br>
                        <th>program ID</th>
                    </tr>";
                echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                    </tr>"; //or just use "echo $row[0]"
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) { 
                    echo "<tr>
                            <td>" . $row[0] . "</td>
                            <td>" . $row[1] . "</td>
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

            $old_membership_id = $_POST['oldfcAccess'];
            $new_membership_id = $_POST['newfcAccess'];

            // $old_date_of_birth = $_POST['old_date_of_birth'];
            $new_date_of_birth = $_POST['newcustomerNum'];
            
            // $old_membership_name = $_POST['old_name'];
            $new_membership_name = $_POST['newName'];

            // you need the wrap the old name and new name values with single quotations
            // don't we have to use CID?
            
            executePlainSQL("UPDATE membership SET customerNum='" . $new_date_of_birth . "' WHERE fcAccess='" . $old_membership_id . "'");
            echo "new date of birth = " . $new_date_of_birth;
            executePlainSQL("UPDATE membership SET membershipNum='" . $new_membership_name . "' WHERE fcAccess='" . $old_membership_id . "'");
            echo "new name = " . $new_membership_name;
            executePlainSQL("UPDATE membership SET fcAccess='" . $new_membership_id . "' WHERE fcAccess='" . $old_membership_id . "'");
            echo "new id = " . $new_membership_id;
            echo "old id = " . $old_membership_id;
            echo "DONE";
            
            // executePlainSQL("UPDATE membership SET fcAccess='" . $new_membership_id . "' WHERE fcAccess='" . $old_membership_id . "'");
            // executePlainSQL("UPDATE membership SET customerNum='" . $new_date_of_birth . "' WHERE customerNum='" . $old_date_of_birth . "'");
            // executePlainSQL("UPDATE membership SET membershipNum='" . $new_membership_name . "' WHERE membershipNum='" . $old_membership_name . "'");
            OCICommit($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            // Drop old table
            executePlainSQL("DROP TABLE Registers_For");

            // Create new table
            echo "<br> creating new table <br>";

            executePlainSQL("CREATE TABLE Registers_For(
                CustomerNum INTEGER,
                ProgramID INTEGER,
                PRIMARY KEY (CustomerNum, ProgramID),
                FOREIGN KEY (CustomerNum) REFERENCES Customer (CustomerID) ON DELETE CASCADE,
                FOREIGN KEY (ProgramID) REFERENCES Program (ProgramID) ON DELETE CASCADE
            )");

            echo "table created!";

            OCICommit($db_conn);
        }

        // adds membership into the membership table row 
        function handleAddRegistrationRequest() {
            global $db_conn;

            $customerNum = $_POST['customerID'];
            $programID = $_POST["programID"];
            
            if ($customerNum == NULL || $programID == NUL) {
                return; 
            }

            $tuple = array (
                ":bind1" => $customerNum,
                ":bind2" => $programID,
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("INSERT INTO Registers_For VALUES (:bind1, :bind2)", $alltuples);
            OCICommit($db_conn);
            echo $customerNum . " is the customer number";
            echo $programID . " is the program ID";
        }

        // function handleAddCustomerRequest() {
        //     global $db_conn;

        //     $customerid = $_POST['customerid'];
        //     $customername = $_POST['customername'];
        //     $dateofbirth = $_POST['dateofbirth'];
            
        //     if ($customerid == NULL || $customername == NUL || $dateofbirth == NULL) {
        //         return; 
        //     }

        //     $tuple = array (
        //         ":bind1" => $customerid,
        //         ":bind2" => $customername,
        //         ":bind3" => $dateofbirth
        //     );

        //     $alltuples = array (
        //         $tuple
        //     );

        //     executeBoundSQL("INSERT INTO Customer VALUES (:bind1, :bind2, :bind3)", $alltuples);
        //     OCICommit($db_conn);
        // }
    
        function handleShowRegistrationRequest() {
            $result = executePlainSQL("SELECT * FROM Registers_For");
            printRegistrationResult($result); 
        }

        function handleDeletemembershipRequest() {
            // sql to delete a record
            global $db_conn;
            $membership_id = $_POST['oldfcAccess'];

            executePlainSQL("DELETE FROM membership WHERE fcAccess ='" . $membership_id ."'");
            OCICommit($db_conn);
        }


        // HANDLE ALL POST ROUTES
	    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB(array_key_exists('addRegistrationRequest', $_POST))) {
                if (array_key_exists('addRegistrationRequest', $_POST)) {
                    handleAddRegistrationRequest();
                } else if (array_key_exists('resetpurchases', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateSubmit', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('showRegistrationRequest', $_POST)) {
                    handleShowRegistrationRequest();
                } else if (array_key_exists('deletemembershipRequest', $_POST)) {
                    handleDeletemembershipRequest();
                }

                disconnectFromDB();
            }
        }

    // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        // function handleGETRequest() {
        //     if (connectToDB()) {
        //         if (array_key_exists('countTuples', $_GET)) {
        //             handleCountRequest();
        //         }

        //         disconnectFromDB();
        //     }
        // }

		if (isset($_POST['resetpurchases']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['addRegistrationRequest']) || isset($_POST['showRegistrationRequest']) || isset($_POST['deletemembershipRequest'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest'])) {
            handleGETRequest();
        }
		?>

    </body>

</html>