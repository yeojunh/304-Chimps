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

  <!-- chmod 755 ~/public_html/entities/customer.php -->
<!DOCTYPE html>
<html>
    <head>
        <title>Customer Page</title>

        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

        <style>
            body {
                text-align: center;
                background-color: #8C8181;
            }

            .add-customer-button {
                margin: 12px;
            }

            .customer, .customer-reset-button, .addCustomerTable {
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

            .tables {
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

            .customerTable, th, td {
                /* padding-bottom: 2rem;  */
                margin-top: -2rem;
                border: 1px solid; 
                position: relative;
            }

            .customerTable {
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

                <div class="customer-container">
                    <h1>Back To Homepage</h1>
                    <div class="add-customer-button">
                        <input type="submit" value="Go to home page!">    
                    </div>
                </div>
            </form>        
        </div>

        <div>
            
        </div>

        <div class="customer customer-reset-button">
            <h2>Reset Customers</h2>
            <p>Click here to reset the customers table</p>

            <form method="POST" action="customer.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetCustomerRequest" name="resetCustomerRequest">
            <p><input type="submit" value="Reset" name="resetCustomer"></p>
            </form>
        </div>
        
        <div class="addCustomerTable">
            <form method="POST" action="customer.php">

                <div class="container">
                    <h2>Add Customer</h2>
                    <p>Fill in the form with new customer details</p>
                    <div>
                        <label for="customername"><b>Customer Name</b></label>
                        <input type="text" name="customername">
                    </div>
                    
                    <div>
                        <label for="dateofbirth"><b>Date Of Birth</b></label>
                        <input type="date" name="dateofbirth">
                    </div>

                    <div>
                        <label for="customerid"><b>Customer ID</b></label>
                        <input type="number" name="customerid">
                    </div>
                    <div>

                        <div class="add-customer-button">
                            <input type="submit" name="addCustomerRequest" value="Add Customer">    
                        </div>
                    </div>
                </div>
            </form>        
        </div>

        <div class="customer updateCustomer">
            <h2>Update Customer Information</h2>
            <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

            <form method="POST" action="customer.php"> <!--refresh page when submitted-->
                <input type="hidden" id="updateCustomerQueryRequest" name="updateCustomerQueryRequest">
                Old Customer ID: <input type="text" name="oldCustomerID"> <br /><br />
                New Customer ID: <input type="text" name="newCustomerID"> <br /><br />
                <!-- Old DateOfBirth: <input type="text" name="oldDateOfBirth"> <br /><br /> -->
                New DateOfBirth: <input type="text" name="newDateOfBirth"> <br /><br />
                <!-- Old Customer Name: <input type="text" name="oldName"> <br /><br /> -->
                New Customer Name: <input type="text" name="newName"> <br /><br />

                <input type="submit" value="Update" name="updateSubmit"></p>
            </form>
        </div>

        <div class="customer">
            <h2>Delete Customer</h2>
            <p>Enter in the customer id of the customer you would like to delete</p>

            <form method="POST" action="customer.php"> <!--refresh page when submitted-->
                <input type="hidden" id="deleteCustomerRequest" name="deleteCustomerRequest">
                Customer ID: <input type="text" name="oldCustomerID"> <br /><br />
                <input type="submit" value="Delete" name="deleteSubmit"></p>
            </form>
        </div>

        <div class="customer">
            <h2>Count the Tuples in Customer</h2>
            <form method="GET" action="customer.php"> <!--refresh page when submitted-->
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
                    echo "<br>The number of tuples in Customer: " . $row[0] . "<br>";
                    echo $row[0]; 
                } else {
                    echo "<br>The number of tuples in Customer: 0"; 
                }
             }

             ?></p>
        </div>

        <div class="customer show-all-customers" id="show-all-customers">
            <h2>Show All Customers</h2>
            <p>Click here to see all the customers in your table!</p>

            <form method="POST" action="customer.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="showCustomers" name="showCustomersRequest">
            <p><input type="submit" value="Show Customers" name="showCustomersRequest"></p>
            </form>

            <div class="internal-table">
                <?php
                //fjsdjfklsfjdskjfkdsfjsdklfjskdfjdsklfjsdklfjkdsl

                if (isset($_POST['showCustomersRequest'])) {
                    if (connectToDB(array_key_exists('addCustomerRequest', $_POST))) {
                        if (array_key_exists('showCustomersRequest', $_POST)) {
                            $result = executePlainSQL("SELECT * FROM Customer");
                            printInternalResult($result);
                        }
        
                        disconnectFromDB();
                    }
                }

                function printInternalResult($result) { //prints results from a select statement
                    $row = OCI_Fetch_Array($result, OCI_BOTH);
                    if(empty($row)) {
                        echo "<div class = 'customer-table'>";
                        echo "<h2>The Customer Table is Empty.</h2>";
                    } else {
                        echo "<div class = 'customer-table'>";
                        echo "<h2>Retrieved data from the Customer table:</h2>";
                        echo "<table class = 'customerTable'>";
                        echo "<tr></tr>
                                <th>Customer ID</th><br>
                                <th>Customer Name</th><br>
                                <th>Date of Birth</th>
                            </tr>";
                        echo "<tr>
                                <td>" . $row[0] . "</td>
                                <td>" . $row[1] . "</td>
                                <td>" . $row[2] . "</td>
                            </tr>"; //or just use "echo $row[0]"
                        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) { 
                            echo "<tr>
                                    <td>" . $row[0] . "</td>
                                    <td>" . $row[1] . "</td>
                                    <td>" . $row[2] . "</td>
                                </tr>"; //or just use "echo $row[0]"
                        }
                        echo "</table>";
                        echo "<br>";
                        echo "</div>";
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

        function handleUpdateRequest() {
            global $db_conn;

            $old_customer_id = $_POST['oldCustomerID'];
            $new_customer_id = $_POST['newCustomerID'];

            // $old_date_of_birth = $_POST['old_date_of_birth'];
            $new_date_of_birth = $_POST['newDateOfBirth'];
            
            // $old_customer_name = $_POST['old_name'];
            $new_customer_name = $_POST['newName'];

            // you need the wrap the old name and new name values with single quotations
            // don't we have to use CID?
            
            executePlainSQL("UPDATE Customer SET DateOfBirth='" . $new_date_of_birth . "' WHERE CustomerID='" . $old_customer_id . "'");
    
            executePlainSQL("UPDATE Customer SET CustomerName='" . $new_customer_name . "' WHERE CustomerID='" . $old_customer_id . "'");
            
            executePlainSQL("UPDATE Customer SET CustomerID='" . $new_customer_id . "' WHERE CustomerID='" . $old_customer_id . "'");
    
            
            // executePlainSQL("UPDATE Customer SET CustomerID='" . $new_customer_id . "' WHERE CustomerID='" . $old_customer_id . "'");
            // executePlainSQL("UPDATE Customer SET DateOfBirth='" . $new_date_of_birth . "' WHERE DateOfBirth='" . $old_date_of_birth . "'");
            // executePlainSQL("UPDATE Customer SET CustomerName='" . $new_customer_name . "' WHERE CustomerName='" . $old_customer_name . "'");
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
                DateOfBirth VARCHAR(255) NOT NULL
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
            
            if ($customerid == NULL || $customername == NUL || $dateofbirth == NULL) {
                return; 
            }

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

        function handleDeleteCustomerRequest() {
            // sql to delete a record
            global $db_conn;
            $customer_id = $_POST['oldCustomerID'];

            executePlainSQL("DELETE FROM Customer WHERE CustomerID ='" . $customer_id ."'");
            OCICommit($db_conn);
        }


        // HANDLE ALL POST ROUTES
	    // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB(array_key_exists('addCustomerRequest', $_POST))) {
                if (array_key_exists('addCustomerRequest', $_POST)) {
                    handleAddCustomerRequest();
                } else if (array_key_exists('resetCustomer', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateSubmit', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('showCustomersRequest', $_POST)) {
                    handleShowCustomersRequest();
                } else if (array_key_exists('deleteCustomerRequest', $_POST)) {
                    handleDeleteCustomerRequest();
                }

                disconnectFromDB();
            }
        }

    // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                // if (array_key_exists('countTuples', $_GET)) {
                //     handleCountRequest();
                // }

                disconnectFromDB();
            }
        }

		if (isset($_POST['resetCustomer']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['addCustomerRequest']) || isset($_POST['showCustomersRequest']) || isset($_POST['deleteCustomerRequest'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest'])) {
            handleGETRequest();
        }
		?>

    </body>

    </html>
