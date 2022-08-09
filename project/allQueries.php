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
        <title>All Queries</title>

        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

        <style>
            body {
                text-align: center;
                background-color: #ffffff;
            }

            .button {
                margin: 12px;
            }

            .container, .button {
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

            .homepage-container {
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

            .data-table, th, td {
                margin-top: -2rem;
                border: 1px solid; 
            }
        </style>
    </head>

    <body>
        <div class="homepage-container">
            <form method="POST" action="main.php">

                <div>
                    <h1>Back To Homepage</h1>
                        <p><input type="submit" value="Go to home page!"></p>
                </div>
            </form>        
        </div>

        <div>
            
        </div>

        <div class="container button">
            <h2>Reset Database</h2>
            <p>Click here to reset the Database</p>

            <form method="POST" action="allQueries.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetRequest" name="resetRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
            </form>
        </div>

        <div class="container button">
            <h2>Add Sample Values into Database</h2>
            <p>Click here to add sample values into the Database</p>

            <form method="POST" action="allQueries.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="sampleRequest" name="sampleRequest">
            <p><input type="submit" value="Add Sample Values" name="sampleRequest"></p>
            </form>
        </div>

        <div class="container button">
            <h2>Select Query</h2>
            <p>Click here to perform a Select Query. </p>

            <form method="POST" action="allQueries.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <div>
                <label for="selectInput"><b>SELECT: </b></label>
                <input type="text" name="selectInput">
            </div>
            <div>
                <label for="fromInput"><b>FROM: </b></label>
                <input type="text" name="fromInput">
            </div>
            <div>
                <label for="whereInput"><b>WHERE: </b></label>
                <input type="text" name="whereInput">
            </div>

            <input type="hidden" id="selectRequest" name="selectRequest">
            <p><input type="submit" value="Select" name="selectRequest"></p>
            </form>
        </div>

        <div class="container button">
            <h2>Projection Query</h2>
            <p>Type here to perform a Projection on Program.<br>Options: Customer, Membership, Program, Registers_For </p>

            <form method="POST" action="allQueries.php">
            <div>
                <label for="projectInput"><b>Type a Table to Project: </b></label>
                <input type="text" name="projectInput">
            </div>

            <input type="hidden" id="projectionRequest" name="projectionRequest">
            <p><input type="submit" value="Project" name="projectionRequest"></p>
            </form>
        </div>

        <div class="container button">
            <h2>Join Query</h2>
            <p>Click here to perform a Join Query.</p>

            <form method="POST" action="allQueries.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="joinRequest" name="joinRequest">
            <p><input type="submit" value="Join Customers and Registers For Tables" name="joinCustomersAndRegistersRequest"></p>
            </form>

        </div>

        <div class="container button">
            <h2>Aggregation Query</h2>
            <p>Find the name of the program with the max capacity that is at most 10 people, for each frequency that is at least 2 programs.</p>

            <form method="POST" action="allQueries.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="groupRequest" name="groupRequest">
            <p><input type="submit" value="Find the program" name="groupRequest"></p>
            </form>

        </div>

        <div class="container button">
            <h2>Nested Aggregation Query</h2>
            <p>Find the capacity of programs for which their average frequency is the maximum over all capacities</p>

            <form method="POST" action="allQueries.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="nestedAggRequest" name="nestedAggRequest">
            <p><input type="submit" value="Find the Nested Aggregation" name="nestedAggRequest"></p>
            </form>

        </div>

        <div class="container button">
            <h2>Division Query</h2>
            <p>Click here to find the ids of all the customers who are taking at least all the same programs that the customer with the ID of 1001 is taking.</p>

            <form method="POST" action="allQueries.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="divisionRequest" name="divisionRequest">
            <p><input type="submit" value="Divide" name="divisionRequest"></p>
            </form>
        </div>
        
        <div class="container show-all-customers" id="show-all-customers">
            <h2>Show All Tables in the Database</h2>
            <p>Click here to see all the Tables in the Database!</p>

            <form method="POST" action="allQueries.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="showAllTablesRequest" name="showAllTablesRequest">
            <p><input type="submit" value="Show All Tables" name="showAllTablesRequest"></p>
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

        function handleAddSamplesRequest() {
            global $db_conn;

            handleResetRequest(); 

            executePlainSQL("INSERT INTO Customer VALUES (1001, 'Yeojun Han', '2002-06-17')");
            executePlainSQL("INSERT INTO Customer VALUES (1002, 'Byron Wang', '2001-05-12')");
            executePlainSQL("INSERT INTO Customer VALUES (1003, 'Aaron Fos-Oy', '2001-01-23')");
            executePlainSQL("INSERT INTO Customer VALUES (1004, 'Apple Bottom', '1999-05-11')");
            executePlainSQL("INSERT INTO Customer VALUES (1005, 'Jean Boots', '2000-01-11')");
            executePlainSQL("INSERT INTO Customer VALUES (1006, 'Mario Kart', '1999-02-13')");

            executePlainSQL("INSERT INTO Membership VALUES (2001, 1001, 1, 1, 0, '2020-02-20', '2020-02-25')");
            executePlainSQL("INSERT INTO Membership VALUES (2002, 1002, 1, 0, 1, '2022-02-20', '2022-01-25')");
            executePlainSQL("INSERT INTO Membership VALUES (2003, 1003, 0, 1, 0, '2017-03-29', '2020-12-31')");
            executePlainSQL("INSERT INTO Membership VALUES (2004, 1004, 0, 0, 1, '2021-01-20', '2022-07-23')");

            executePlainSQL("INSERT INTO Program VALUES (3001, 'Get Fit with Aaron!', 2, 'Bird Cooper Gym', 'Getting fit with your resident gym rat', 'Anyone is welcome!', 3, '2022-04-02', '2022-04-31')");
            executePlainSQL("INSERT INTO Program VALUES (3002, 'Swimming with Byron!', 3, 'UBC (University of a Billion Constructions) Pool', 'WOOHOO SWIMMING', 'Everybody is welcome!', 5, '2020-01-01', '2022-06-31')");

            executePlainSQL("INSERT INTO Registers_For VALUES (1001, 3001)");
            executePlainSQL("INSERT INTO Registers_For VALUES (1001, 3002)");
            executePlainSQL("INSERT INTO Registers_For VALUES (1002, 3001)");
            executePlainSQL("INSERT INTO Registers_For VALUES (1003, 3001)");
            executePlainSQL("INSERT INTO Registers_For VALUES (1003, 3002)");
            executePlainSQL("INSERT INTO Registers_For VALUES (1005, 3001)");
            executePlainSQL("INSERT INTO Registers_For VALUES (1005, 3002)"); 
            OCICommit($db_conn);
        }

        function handleSelectRequest() {
            $from = $_POST['fromInput'];
            if ($from == "Customer") {
                printCustomerSelectTable();
            } else if ($from == "Membership") {
                printMembershipSelectTable();
            } else if ($from == "Program") {
                printProgramSelectTable();
            } else if ($from == "Registers_For") {
                printRegistersForSelectTable();
            }
        }

        function printCustomerSelectTable() {
            $select = $_POST['selectInput'];
            $where = $_POST['whereInput'];
            $result = executePlainSQL("SELECT " . $select . " FROM Customer WHERE " . $where);
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            echo "<div class = 'container'>";
            if(empty($row)) {
                echo "<h2>The Table after a SELECT Query is Empty.</h2>";
            } else {
                echo "<h2>Retrieved data from the SELECT Query table:</h2>";
                echo "<table class = 'data-table'>";
                echo "<tr></tr>
                        <th>Customer ID</th><br>
                        <th>Customer Name</th><br>
                        <th>Date of Birth</th><br>
                    </tr>";
                echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                    </tr>"; 
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) { 
                    echo "<tr>
                    <td>" . $row[0] . "</td>
                    <td>" . $row[1] . "</td>
                    <td>" . $row[2] . "</td>
                    </tr>"; 
                }
                echo "</table>";
                echo "<br>";
            }
            echo "</div>";
        }

        function printMembershipSelectTable() {
            $select = $_POST['selectInput'];
            $where = $_POST['whereInput'];
            $result = executePlainSQL("SELECT " . $select . " FROM Membership WHERE " . $where);
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            echo "<div class = 'container'>";
            if(empty($row)) {
                echo "<h2>The Table after a SELECT Query is Empty.</h2>";
            } else {
                echo "<h2>Retrieved data from the SELECT Query table:</h2>";
                echo "<table class = 'data-table'>";
                echo "<tr></tr>
                        <th>Customer Membership Number</th><br>
                        <th>Customer ID</th><br>
                        <th>Fitness Centre Access</th><br>
                        <th>Pool Access</th><br>
                        <th>Gym Access</th><br>
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
                    </tr>"; 
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) { 
                    echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                        <td>" . $row[3] . "</td>
                        <td>" . $row[4] . "</td>
                        <td>" . $row[5] . "</td>
                        <td>" . $row[6] . "</td>
                    </tr>"; 
                }
                echo "</table>";
                echo "<br>";
            }
            echo "</div>";
        }

        function printProgramSelectTable() {
            $select = $_POST['selectInput'];
            $where = $_POST['whereInput'];
            $result = executePlainSQL("SELECT " . $select . " FROM Program WHERE " . $where);
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            echo "<div class = 'container'>";
            if(empty($row)) {
                echo "<h2>The Table after a SELECT Query is Empty.</h2>";
            } else {
                echo "<h2>Retrieved data from the SELECT Query table:</h2>";
        echo "<taclass = 'data-table'>";
                echo "<tr></tr>
                        <th>Program ID</th><br>
                        <th>Program Name</th><br>
                        <th>Frequency</th><br>
                        <th>Location</th><br>
                        <th>Purpose</th><br>
                        <th>Target Audience</th><br>
                        <th>Start Date</th><br>
                        <th>End Date</th>
                    </tr>";
                echo "<tr>
                        <td>" . $row[0] . " </td>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                        <td>" . $row[3] . "</td>
                        <td>" . $row[4] . "</td>
                        <td>" . $row[5] . "</td>
                        <td>" . $row[6] . "</td>
                        <td>" . $row[7] . "</td>
                        <td>" . $row[8] . "</td>
                    </tr>"; 
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
                    </tr>"; 
                }
                echo "</table>";
               
 echo "<br>";
            }
            echo "</div>";
        }

        function printRegistersForSelectTable() {
                            $select = $_POST['selectInput'];
             $where = $_POST['whereInput'];
            $result = executePlainSQL("SELECT " . $select . " FROM Registers_For WHERE " . $where);
            $row = OCI_Fetch_Array($result, OCI_BOTH);
   
                     echo "<div class = 'container'>";
            if(empty($row)) {
                echo "<h2>The Table aft er a SELECT Query s Empty.</h2> ";
               
            } else {
                echo "<h2>Retrieved data from the SELECT Queryle:2>";
                echo "<table cla 'data-table'>";
                echo "<tr></tr>
                        <th>CustomerID</th><br>
                        <th>Program ID</th><br>
                   </tr>";
               echo "<tr>
                       <td>" .$row[0] . "</td>
                        <td>" . $row[1] . "</td>
                    </tr>"; 
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) { 
                    echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                    </tr>"; 
                }
                echo "</table>";
                echo "<br>";
            }
            echo "</div>";
        }
        
        function handleProjectionRequest() {
            $value = $_POST['projectInput'];
            if ($value == "Customer") {
                printCustomerProjectionTable();
            } else if ($value == "Membership") {
                printMembershipProjectionTable();
            } else if ($value == "Program") {
                printProgramProjectionTable();
            } else if ($value == "Registers_For") {
                printRegistersForProjectionTable();
            }
        }

        function printProgramProjectionTable() {
            $result = executePlainSQL("SELECT ProgramID, ProgramName, StartDate, Frequency, Capacity FROM Program");
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            echo "<div class = 'container'>";
            if(empty($row)) {
                echo "<h2>The Table after a PROJECTION Query is Empty.</h2>";
            } else {
                echo "<h2>Retrieved data from the PROJECTION Query table:</h2>";
                echo "<table class = 'data-table'>";
                echo "<tr></tr>
                        <th>Program ID</th><br>
                        <th>Program Name</th><br>
                        <th>StartDate</th><br>
                        <th>Frequency</th><br>
                        <th>Capacity</th><br>
                    </tr>";
                echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                        <td>" . $row[3] . "</td>
                        <td>" . $row[4] . "</td>
                    </tr>"; 
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) { 
                    echo "<tr>
                    <td>" . $row[0] . "</td>
                    <td>" . $row[1] . "</td>
                    <td>" . $row[2] . "</td>
                    <td>" . $row[3] . "</td>
                    <td>" . $row[4] . "</td>
                    </tr>"; 
                }
                echo "</table>";
                echo "<br>";
            }
            echo "</div>";
        }
        
        function printCustomerProjectionTable() {
            $result = executePlainSQL("SELECT CustomerID, CustomerName FROM Customer");
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            echo "<div class = 'container'>";
            if(empty($row)) {
                echo "<h2>The Table after a PROJECTION Query is Empty.</h2>";
            } else {
                echo "<h2>Retrieved data from the PROJECTION Query table:</h2>";
                echo "<table class = 'data-table'>";
                echo "<tr></tr>
                        <th>Customer ID</th><br>
                        <th>Customer Name</th><br>
                    </tr>";
                echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                    </tr>"; 
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) { 
                    echo "<tr>
                    <td>" . $row[0] . "</td>
                    <td>" . $row[1] . "</td>
                    </tr>"; 
                }
                echo "</table>";
                echo "<br>";
            }
            echo "</div>";
        }

        function printMembershipProjectionTable() {
            $result = executePlainSQL("SELECT CustomerMembershipNum, CustomerID, StartDate FROM Membership");
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            echo "<div class = 'container'>";
            if(empty($row)) {
                echo "<h2>The Table after a PROJECTION Query is Empty.</h2>";
            } else {
                echo "<h2>Retrieved data from the PROJECTION Query table:</h2>";
                echo "<table class = 'data-table'>";
                echo "<tr></tr>
                        <th>Customer Membership ID</th><br>
                        <th>Customer ID</th><br>
                        <th>Start Date</th><br>
                    </tr>";
                echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                    </tr>"; 
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) { 
                    echo "<tr>
                    <td>" . $row[0] . "</td>
                    <td>" . $row[1] . "</td>
                    <td>" . $row[2] . "</td>
                    </tr>"; 
                }
                echo "</table>";
                echo "<br>";
            }
            echo "</div>";
        }

        function printRegistersForProjectionTable() {
            $result = executePlainSQL("SELECT CustomerID FROM Registers_For");
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            echo "<div class = 'container'>";
            if(empty($row)) {
                echo "<h2>The Table after a PROJECTION Query is Empty.</h2>";
            } else {
                echo "<h2>Retrieved data from the PROJECTION Query table:</h2>";
                echo "<table class = 'data-table'>";
                echo "<tr></tr>
                        <th>Customer ID</th><br>
                    </tr>";
                echo "<tr>
                        <td>" . $row[0] . "</td>
                    </tr>"; 
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) { 
                    echo "<tr>
                    <td>" . $row[0] . "</td>
                    </tr>"; 
                }
                echo "</table>";
                echo "<br>";
            }
            echo "</div>";
        }

        function printCRJoinTable($result) {
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            echo "<div class = 'container'>";
            if(empty($row)) {
                echo "<h2>The Table after a JOIN Customers and Registers Query is Empty.</h2>";
            } else {
                echo "<h2>Retrieved data from the JOIN Customers and Registers Query table:</h2>";
                echo "<table class = 'data-table'>";
                echo "<tr></tr>
                        <th>Customer ID</th><br>
                        <th>Customer Name</th><br>
                        <th>Date Of Birth</th><br>
                        <th>Customer ID</th><br>
                        <th>Program ID</th><br>
                    </tr>";
                echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                        <td>" . $row[3] . "</td>
                        <td>" . $row[4] . "</td>
                    </tr>"; 
                while ($row = OCI_Fetch_Array($result, OCI_BOTH)) { 
                    echo "<tr>
                        <td>" . $row[0] . "</td>
                        <td>" . $row[1] . "</td>
                        <td>" . $row[2] . "</td>
                        <td>" . $row[3] . "</td>
                        <td>" . $row[4] . "</td>
                    </tr>"; 
                }
                echo "</table>";
                echo "<br>";
            }
            echo "</div>";
        }
        
        function handleNestedAggRequest() {
            // $result = executePlainSQL ("SELECT Temp.Capacity, Temp.avgFreq
            //                             FROM (Select P.Capacity, AVG(P.Frequency) AS avgFreq
            //                                   FROM Program P
            //                                   GROUP BY P.Capacity) AS Temp
            //                             WHERE Temp.avgFreq = (SELECT MAX(Temp.avgFreq)
            //                                                   FROM Temp)");


            echo "this statement should output, given an example code from class"; 
            $result = executePlainSQL ("SELECT Temp.Capacity, Temp.avgFreq 
                                        FROM (Select P.Capacity AS Capacity, AVG(P.Frequency) as avgFreq
                                              FROM Program P
                                              GROUP BY P.Capacity) AS Temp
                                        WHERE Temp.avgFreq = (SELECT MAX (Temp.avgFreq)
                                                            FROM Temp)");
            // $temp = executePlainSQL("SELECT P.Capacity, AVG(P.Frequency) AS avgFreq
            //                         FROM Program P
            //                         GROUP BY P.Capacity)");

            // $output = executePlainSQL("SELECT $temp.Capacity, ");

            $row = OCI_Fetch_Array($result, OCI_BOTH);
            if(empty($row)) {
                echo "<h2>The Resulting Table of the Nested Aggregation Query is Empty.</h2>";
            } else {
                echo "<h2>Retrieved data from the Resulting Table of the Nested Aggregation Query:</h2>";
                echo "<table class = 'data-table'>";
                echo "<tr></tr>
                        <th>Capacity</th><br>
                        <th>Average Frequency</th><br>
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
            }
            
        }

        function handleCustomersAndRegistersJoinRequest() {
            $result = executePlainSQL("SELECT *
             FROM Customer
             JOIN Registers_For
             ON Customer.CustomerID = Registers_For.CustomerID");
            
            printCRJoinTable($result); 
        }

        function handleDivisionRequest() {
            global $db_conn;

            echo "MADE IT BEGINNING";

            $result = executePlainSQL("SELECT R1.CustomerID
            FROM Registers_For AS R1
            WHERE NOT EXISTS
            ((SELECT ProgramID 
            FROM Registers_For AS R2 
            WHERE R2.CustomerID = 1001)
            EXCEPT
            (SELECT ProgramID 
            FROM Registers_For AS R2 
            WHERE R1.CustomerID = R2.CustomerID)
            )");

            echo "MADE IT ENDING";

            OCICommit($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            executePlainSQL("drop table Customer cascade constraints");
            executePlainSQL("drop table Program cascade constraints");
            executePlainSQL("drop table Membership cascade constraints");
            executePlainSQL("drop table Registers_For cascade constraints");

            executePlainSQL("CREATE TABLE Customer (
                CustomerID INTEGER PRIMARY KEY,
                CustomerName CHAR(255) NOT NULL,
                DateOfBirth VARCHAR(255) NOT NULL
                )");

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


            executePlainSQL("CREATE TABLE Program (
                ProgramID INTEGER,
                ProgramName CHAR(225) NOT NULL,
                Frequency INTEGER NOT NULL,
                Location CHAR(255) NOT NULL,
                Purpose CHAR(255),
                TargetAudience CHAR(255),
                Capacity INTEGER NOT NULL,
                StartDate VARCHAR(255) NOT NULL,
                EndDate VARCHAR(255),
                PRIMARY KEY (ProgramID)
                )");

            executePlainSQL("CREATE TABLE Registers_For (
                CustomerID INTEGER,
                ProgramID INTEGER,
                PRIMARY KEY (CustomerID, ProgramID),
                FOREIGN KEY (CustomerID) REFERENCES Customer (CustomerID) ON DELETE CASCADE,
                FOREIGN KEY (ProgramID) REFERENCES Program (ProgramID) ON DELETE CASCADE
                )");

            OCICommit($db_conn);
        }
        // div: find all customers who bought all differet types of membership 
        // find all memberships that are a part of x
    
        function handleShowTableRequest($table_name) {
            $result = executePlainSQL("SELECT * FROM " . $table_name);
            switch ($table_name) {
                case 'Customer':
                    printCustomerTable($result); 
                    break;
                case 'Membership': 
                    printMembershipTable($result); 
                    break;
                case 'Program': 
                    printProgramTable($result); 
                    break;
                case 'Registers_For':
                    printRegistersForTable($result);
                    break;
            }
            // printCustomerTable($result); 
        }

        function handleShowAllTablesRequest() {
            echo "<div class = 'container'>";
            $table_names = array('Customer', 'Membership', 'Program','Registers_For'); 
            foreach ($table_names as $table_name) {
                handleShowTableRequest($table_name); 
            }
            echo "</div>";
        }


        // HANDLE ALL POST ROUTES
        // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB(array_key_exists('resetRequest', $_POST))) {
                if (array_key_exists('showAllTablesRequest', $_POST)) {
                    handleShowAllTablesRequest();
                } else if (array_key_exists('resetRequest', $_POST)) {
                    handleResetRequest(); 
                } else if (array_key_exists('joinCustomersAndRegistersRequest', $_POST)) {
                    handleCustomersAndRegistersJoinRequest(); 
                } else if (array_key_exists('joinProgramsAndRegistersRequest', $_POST)) {
                    handleProgramsAndRegistersJoinRequest();
                } else if (array_key_exists('selectRequest', $_POST)) {
                    handleselectRequest(); 
                } else if (array_key_exists('projectionRequest', $_POST)) {
                    handleProjectionRequest(); 
                } else if (array_key_exists('sampleRequest', $_POST)) {
                    handleAddSamplesRequest(); 
                } else if (array_key_exists('divisionRequest', $_POST)) {
                    handleDivisionRequest();
                } else if (array_key_exists('nestedAggRequest', $_POST)) {
                    handleNestedAggRequest();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['showAllTablesRequest']) || isset($_POST['resetRequest']) || isset($_POST['joinRequest']) || isset($_POST['selectRequest']) || isset($_POST['projectionRequest']) || isset($_POST['sampleRequest']) || isset($_POST['divisionRequest']) || isset($_POST['nestedAggRequest'])) {
            handlePOSTRequest();
        }


        // indiviual table output
        
        function printCustomerTable($result) { //prints results from a select statement
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            if(empty($row)) {
                echo "<h2>Customer Table is Empty.</h2>";
            } else {
                echo "<h2>Retrieved data from the Customer table:</h2>";
                echo "<table class = 'data-table'>";
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
            }
        }

        function printMembershipTable($result) { //prints results from a select statement
            $row = OCI_Fetch_Array($result, OCI_BOTH);
            if(empty($row)) {
                echo "<h2>Membership Table is Empty.</h2>";
            } else {
                echo "<h2>Retrieved data from the Membership table:</h2>";
                echo "<table class = 'data-table'>";
                echo "<tr></tr>
                        <th>CustomerMembershipNum</th><br>
                        <th>CustomerID</th><br>
                        <th>FitnessCentreAccess</th><br>
                        <th>PoolAccess</th><br>
                        <th>GymAccess</th><br>
                        <th>StartDate</th><br>
                        <th>EndDate</th>
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
            }
        }
		?>

    </body>

    </html>
