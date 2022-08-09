<!DOCTYPE html>
<html>
    <head>
        <title>CPSC 304 Project Homepage</title>

        <style>

            body {
                text-align: center;
                background-color: #C2D8B9;
                display: flex;
                flex-wrap: wrap;
            }

            .add-customer-button {
                margin: 12px;
            }

            .tables {
                flex-wrap: wrap;
                /* width: 50%; */
                position: relative;
                text-align: center;
                background-color: #FFFCF7;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin: 2rem;
                padding: 2rem;
                border-radius: 10px;
                outline: 5px solid black;
            }

            .relationships {
                /* width: 50%; */
                position: relative;
                text-align: center;
                background-color: #8E9AAF;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin: 2rem;
                padding: 2rem;
                border-radius: 10px;
                outline: 5px solid black;
            }

            .allQueries {
                position: relative;
                text-align: center;
                background-color: #90D7FF;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                margin: 2rem;
                padding: 2rem;
                border-radius: 10px;
                outline: 5px solid black;
            }
        </style>
    </head>

    

    <body>

        <div>
            <?php
                if (isset($_POST['resetCustomer'])) {
                    // echo "customer table reset";
                }
                if (isset($_POST['addCustomerRequest'])) {
                    $name = $_POST['customername'];
                    $customerid = $_POST['customerid'];
                    $dateofbirth = $_POST['dateofbirth'];

                    echo $name . " " . $customerid . " " . $dateofbirth;
                }
            ?>
        </div>
        
        <div class="tables">
            <form method="POST" action="entities/customer.php">

                <div class="customer-container">
                    <h1>Customer Table</h1>
                    
                    <div class="add-customer-button">
                        <input type="submit" value="Go to customer table!">    
                    </div>
                    
                </div>
            </form>        
        </div>

        <div class="tables">
            <form method="POST" action="entities/membership.php">
                <h1>Membership Table</h1>
                
                <input type="submit" value="Go to membership table!">
                    
            </form>        
        </div>

        <!-- <div class="tables">
            <form method="POST" action="staff.php">
                <h1>Staff Table</h1>
                    
                <input type="submit" value="Go to staff table!">
                    
            </form>        
        </div> -->

        <!-- <div class="tables">
            <form method="POST" action="fitnessCentre.php">
                <h1>Fitness Centre Table</h1>
                    
                <input type="submit" value="Go to fitness centre table!">
                    
            </form>        
        </div> -->

        <!-- <div class="tables">
            <form method="POST" action="gymnasium.php">
                <h1>Gymnasium Table</h1>
                    
                <input type="submit" value="Go to gymnasium table!">
                    
            </form>        
        </div> -->

        <div class="tables">
            <form method="POST" action="entities/program.php">
                <h1>Program Table</h1>
                    
                <input type="submit" value="Go to program table!">
                    
            </form>        
        </div>

        <!-- <div class="tables">
            <form method="POST" action="aquaticCentre.php">
                <h1>Aquatic Centre Table</h1>
                    
                <input type="submit" value="Go to aquatic centre table!">
                    
            </form>        
        </div> -->

        <!-- <div class="tables">
            <form method="POST" action="events.php">
                <h1>Events Table</h1>
                    
                <input type="submit" value="Go to events table!">
                    
            </form>        
        </div> -->

        <!-- <div class="tables">
            <form method="POST" action="skatingRink.php">
                <h1>Skating Rink Table</h1>
                    
                <input type="submit" value="Go to skating rink table!">
                    
            </form>        
        </div> -->

        <!-- relationship tables start here -->

        <!-- <div class="relationships">
            <form method="POST" action="worksIn.php">
                <h1>Works In Relationship Table</h1>
                    
                <input type="submit" value="Go to works in relationship table!">
                    
            </form>        
        </div> -->

        <!-- <div class="relationships">
            <form method="POST" action="managesAquaticCentre.php">
                <h1>Manages Aquatic Centre Relationship Table</h1>
                    
                <input type="submit" value="Go to manages aquatic centre relationship table!">
                    
            </form>        
        </div> -->

        <!-- <div class="relationships">
            <form method="POST" action="managesFitnessCentre.php">
                <h1>Manages Fitness Centre Relationship Table</h1>
                    
                <input type="submit" value="Go to manages fitness centre relationship table!">
                    
            </form>        
        </div> -->

        <!-- <div class="relationships">
            <form method="POST" action="managesGymnasium.php">
                <h1>Manages Gymnasium Relationship Table</h1>
                    
                <input type="submit" value="Go to manages gymnasium relationship table!">
                    
            </form>        
        </div> -->

        <!-- <div class="relationships">
            <form method="POST" action="managesSkatingRink.php">
                <h1>Manages Skating Rink Relationship Table</h1>
                    
                <input type="submit" value="Go to manages skating rink relationship table!">
                    
            </form>        
        </div> -->

        <!-- <div class="relationships">
            <form method="POST" action="usesEvent.php">
                <h1>Uses Event Relationship Table</h1>
                    
                <input type="submit" value="Go to uses event relationship table!">
                    
            </form>        
        </div> -->

        <!-- <div class="relationships">
            <form method="POST" action="usesGymnasium.php">
                <h1>Uses Gymnasium Relationship Table</h1>
                    
                <input type="submit" value="Go to uses gymnasium relationship table!">
                    
            </form>        
        </div> -->

        <!-- <div class="relationships">
            <form method="POST" action="usesAquaticCentre.php">
                <h1>Uses Aquatic Centre Relationship Table</h1>
                    
                <input type="submit" value="Go to uses aquatic centre relationship table!">
                    
            </form>        
        </div> -->

        <!-- <div class="relationships">
            <form method="POST" action="usesFitnessCentre.php">
                <h1>Uses Fitness Centre Relationship Table</h1>
                    
                <input type="submit" value="Go to uses fitness centre relationship table!">
                    
            </form>        
        </div> -->

        <!-- <div class="relationships">
            <form method="POST" action="usesSkatingRink.php">
                <h1>Uses Skating Rink Relationship Table</h1>
                    
                <input type="submit" value="Go to uses skating rink relationship table!">
                    
            </form>        
        </div> -->

        <!-- <div class="relationships">
            <form method="POST" action="greets.php">
                <h1>Greets Relationship Table</h1>
                    
                <input type="submit" value="Go to greets relationship table!">
                    
            </form>        
        </div> -->

        <!-- <div class="relationships">
            <form method="POST" action="volunteersFor.php">
                <h1>Volunteers For Relationship Table</h1>
                    
                <input type="submit" value="Go to volunteers for relationship table!">
                    
            </form>        
        </div> -->

        <!-- <div class="relationships">
            <form method="POST" action="teaches.php">
                <h1>Teaches Relationship Table</h1>
                    
                <input type="submit" value="Go to teaches relationship table!">
                    
            </form>        
        </div> -->

        <div class="relationships">
            <form method="POST" action="relationships/registers_for.php">
                <h1>Registers For Relationship Table</h1>
                    
                <input type="submit" value="Go to registers for relationship table!">
                    
            </form>        
        </div>

        <div class="allQueries">
            <form method="POST" action="allQueries.php">
                <h1>Show ALL Tables in the Database</h1>
                <input type="submit" value="Show ALL Tables in the Database!">
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
            echo "<br>Retrieved data from table Customer:<br>";
            echo "<table>";
            echo "<tr>
                    <th>Customer ID</th><br>
                    <th>Customer Name</th><br>
                    <th>Date of Birth</th>
                </tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                    </tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
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

            $old_customer_id = $_POST['old_id'];
            $new_customer_id = $_POST['new_id'];

            $old_date_of_birth = $_POST['old_date_of_birth'];
            $new_date_of_birth = $_POST['new_date_of_birth'];
            
            $old_customer_name = $_POST['old_name'];
            $new_customer_name = $_POST['new_name'];

            // you need the wrap the old name and new name values with single quotations
            // don't we have to use CID?
            executePlainSQL("UPDATE Customer SET CustomerID='" . $new_customer_id . "' WHERE CustomerID='" . $old_customer_id . "'");
            executePlainSQL("UPDATE Customer SET DateOfBirth='" . $new_date_of_birth . "' WHERE DateOfBirth='" . $old_date_of_birth . "'");
            executePlainSQL("UPDATE Customer SET CustomerName='" . $new_customer_name . "' WHERE CustomerName='" . $old_customer_name . "'");
            OCICommit($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            // Drop old table
            executePlainSQL("DROP TABLE Customer cascade constraints");

            // Create new table
            echo "<br> creating new table <br>";
            // executePlainSQL("CREATE TABLE demoTable (id int PRIMARY KEY, 
            //                                             name char(30))");
            executePlainSQL("CREATE TABLE Customer (
                CustomerID INTEGER PRIMARY KEY,
                CustomerName CHAR(255) NOT NULL,
                DateOfBirth VARCHAR(255)
            )");

            echo "table created!";

            OCICommit($db_conn);
        }

        // adds customer into the Customer table row 
        function handleAddCustomerRequest() {
            global $db_conn;

            $customerid = $_POST['customerid'];
            $customername = $_POST['customername'];
            $dateofbirth = $_POST['dateofbirth'];
            
            $tuple = array (
                ":bind1" => $customerid,
                ":bind2" => $customername,
                ":bind3" => $dateofbirth
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("INSERT INTO Customer VALUES (:bind1, :bind2, :bind3)", $alltuples);
            OCICommit($db_conn);
        }

        function handleCountRequest():int {
            $result = executePlainSQL("SELECT Count(*) FROM Customer");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br>The number of tuples in Customer: " . $row[0] . "<br>";
                return $row[0]; 
            } else {
                return 0; 
            }
        }
    
        function handleShowCustomersRequest() {
            $result = executePlainSQL("SELECT * FROM Customer");
            printResult($result); 
        }

        function deleteRow() {
             // sql to delete a record
            // executePlainSQL("DELETE FROM Customer WHERE CustomerID='" . $customNum . "'");

            global $db_conn;

            echo "made it here to beginning of delete";

            $customer_id = $_POST['oldCustomerID'];

            // you need the wrap the old name and new name values with single quotations
            executePlainSQL("DELETE FROM Customer WHERE CustomerID ='" . $customer_id ."'");
            OCICommit($db_conn);

            echo "deleted!!!!";

            // use exec() because no results are returned
            // $conn->exec($sql);
                    // echo "Customer deleted successfully";
            // } catch(PDOException $e) {
            // echo $sql . "<br>" . $e->getMessage();
            // }
        }


        // HANDLE ALL POST ROUTES
	    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB(array_key_exists('addCustomerRequest', $_POST))) {
                if (array_key_exists('addCustomerRequest', $_POST)) {
                    handleAddCustomerRequest();
                } else if (array_key_exists('resetCustomer', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateCustomerQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('showCustomersRequest', $_POST)) {
                    handleShowCustomersRequest(); 
                } else if (array_key_exists('deleteSubmit', $_POST)) {
                    deleteRow();
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

		if (isset($_POST['resetCustomer']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['addCustomerRequest']) || isset($_POST['showCustomersRequest'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest'])) {
            handleGETRequest();
        }
		?>

    </body>

    </html>
