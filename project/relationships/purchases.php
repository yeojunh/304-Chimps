
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
            <h2>Reset Purchases</h2>
            <p>Click here to reset the purchases table</p>

            <form method="POST" action="purchases.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetpurchasesRequest" name="resetpurchasesRequest">
            <p><input type="submit" value="Reset" name="resetpurchases"></p>
            </form>
        </div>
        
        <div class="addpurchasesTable">
            <form method="POST" action="allQueries.php"></form>

                <div class="container">
                    <h2>Add purchase</h2>
                    <p>Fill in the form with new purchase details</p>
                    <div>
                        <label for="membershipNum"><b>Membership Number</b></label>
                        <input type="text" name="membershipNum">
                    </div>
                    
                    <div>
                        <label for="customerNum"><b>Customer Number</b></label>
                        <input type="text" name="customerNum">
                    </div>

                    <div>
                    <form id="form1" name="form1" method="post" action="<?php echo $PHP_SELF; ?>">  
            Customer Number
            <select Emp Name='NEW'>
            <option value="">--- Select ---</option>  
            <?  
                global $db_conn;
                
                mysql_connect ("localhost","root","");  
                mysql_select_db ("company");  
                $select="company";  
                if (isset ($select)&&$select!=""){  
                $select=$_POST ['NEW'];  
            }  
            ?>  
            <?  
                $list=mysql_query("select * from Customer order by CustomerID asc");  
            while($row_list=mysql_fetch_assoc($list)){  
                ?>  
                    <option value="<? echo $row_list['CustomerID']; ?>"<? if($row_list['CustomerID']==$select){ echo "selected"; } ?>>  
                                        // <?echo $row_list['emp_name'];?> 
                                        echo "here now"; 
                    </option>  
                <?  
                }  
                ?>  
            </select>  
        </form>  

                    </div>

                    <div>
                        <label for="fcAccess"><b>Fitness Centre Access</b></label>
                        <input type="checkbox" name="fcAccess">
                    </div>

                    <div>
                        <label for="pAccess"><b>Pool Access</b></label>
                        <input type="checkbox" name="pcAccess">
                    </div>

                    <div>
                        <label for="gAccess"><b>Gym Access</b></label>
                        <input type="checkbox" name="gAccess">
                    </div>

                    <div>
                        <label for="startDate"><b>Start Date</b></label>
                        <input type="date" name="startDate">
                    </div>

                    <div>
                        <label for="endDate"><b>End Date</b></label>
                        <input type="date" name="endDate">
                    </div>

                        <div class="add-membership-button">
                            <input type="submit" name="addmembershipRequest" value="Add membership">    
                        </div>
                    </div>
                </div>
            </form>        
        </div>

        <div class="membership updatemembership">
            <h2>Update membership Information</h2>
            <p>The values are case sensitive and if you enter in the wrong case, the update statement will not do anything.</p>

            <form method="POST" action="purchases.php"> <!--refresh page when submitted-->
                <input type="hidden" id="updatemembershipQueryRequest" name="updatemembershipQueryRequest">
                Old membership ID: <input type="text" name="oldfcAccess"> <br /><br />
                New membership ID: <input type="text" name="newfcAccess"> <br /><br />
                <!-- Old customerNum: <input type="text" name="oldcustomerNum"> <br /><br /> -->
                New customerNum: <input type="text" name="newcustomerNum"> <br /><br />
                <!-- Old membership Name: <input type="text" name="oldName"> <br /><br /> -->
                New membership Name: <input type="text" name="newName"> <br /><br />

                <input type="submit" value="Update" name="updateSubmit"></p>
            </form>
        </div>

        <div class="membership">
            <h2>Delete membership</h2>
            <p>Enter in the membership id of the membership you would like to delete</p>

            <form method="POST" action="purchases.php"> <!--refresh page when submitted-->
                <input type="hidden" id="deletemembershipRequest" name="deletemembershipRequest">
                membership ID: <input type="text" name="oldfcAccess"> <br /><br />
                <input type="submit" value="Delete" name="deleteSubmit"></p>
            </form>
        </div>

        <div class="purchases">
            <h2>Count the Tuples in membership</h2>
            <form method="GET" action="purchases.php"> <!--refresh page when submitted-->
                <input type="hidden" id="countTupleRequest" name="countTupleRequest">
                <input type="submit" name="countTuples"></p>
            </form>
        </div>

        <div class="purchases show-all-purchases" id="show-all-memberships">
            <h2>Show All memberships</h2>
            <p>Click here to see all the memberships in your table!</p>

            <form method="POST" action="purchases.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="showmemberships" name="showmembershipsRequest">
            <p><input type="submit" value="Show memberships" name="showmembershipsRequest"></p>
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
                        <th>membership ID</th><br>
                        <th>membership Name</th><br>
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
            executePlainSQL("DROP TABLE Purchases");

            // Create new table
            echo "<br> creating new table <br>";

            executePlainSQL("CREATE TABLE Purchases (
                CustomerNum INTEGER,
                CustomerMembershipNum INTEGER PRIMARY KEY,
                FOREIGN KEY (CustomerNum) REFERENCES Customer (CustomerID) ON DELETE CASCADE,
                FOREIGN KEY (CustomerMembershipNum) REFERENCES Membership (CustomerMembershipNum) ON DELETE CASCADE
            )");

            echo "table created!";

            OCICommit($db_conn);
        }

        // adds membership into the membership table row 
        function handleAddmembershipRequest() {
            global $db_conn;

            $fcAccess = $_POST['fcAccess'];
            $membershipNum = $_POST['membershipNum'];
            $customerNum = $_POST['customerNum'];
            
            if ($fcAccess == NULL || $membershipNum == NUL || $customerNum == NULL) {
                return; 
            }

            $tuple = array (
                ":bind1" => $fcAccess,
                ":bind2" => $membershipNum,
                ":bind3" => $customerNum
            );

            $alltuples = array (
                $tuple
            );

            executeBoundSQL("INSERT INTO membership VALUES (:bind1, :bind2, :bind3)", $alltuples);
            OCICommit($db_conn);
        }

        // function handleCountRequest():int {
        //     $result = executePlainSQL("SELECT Count(*) FROM membership");

        //     if (($row = oci_fetch_row($result)) != false) {
        //         echo "<br>The number of tuples in membership: " . $row[0] . "<br>";
        //         return $row[0]; 
        //     } else {
        //         return 0; 
        //     }
        // }
    
        function handleShowmembershipsRequest() {
            $result = executePlainSQL("SELECT * FROM membership");
            printResult($result); 
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
            if (connectToDB(array_key_exists('addmembershipRequest', $_POST))) {
                if (array_key_exists('addmembershipRequest', $_POST)) {
                    handleAddmembershipRequest();
                } else if (array_key_exists('resetpurchases', $_POST)) {
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
        // function handleGETRequest() {
        //     if (connectToDB()) {
        //         if (array_key_exists('countTuples', $_GET)) {
        //             handleCountRequest();
        //         }

        //         disconnectFromDB();
        //     }
        // }

		if (isset($_POST['resetpurchases']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['addmembershipRequest']) || isset($_POST['showmembershipsRequest']) || isset($_POST['deletemembershipRequest'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest'])) {
            handleGETRequest();
        }
		?>

    </body>

</html>