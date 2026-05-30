<html>
<body>
<?php

// AI Acknowledgement: Throughout this homework, I've used Claude AI to help me with coding because PHP is a 
// new language for me and I wanted to study more about it. My process goes like this: I ask the Claude AI to give me
// hints/tips on how to do the query, then I try to do the query myself first. Then, I pasted my query for the AI to check,
// if my query was wrong, then it will suggest where it was wrong then I fix it myself. Through this process, I've learned
// about PHP syntax more and understand how query and HTML goes hand in hand. In this assignment, I've never copy and
// pasted a whole code fromm Claude without changing any details or filter through it. Overall, I used Claude as 
// my guide to help me code this assignment. Let me know if there are any concerns!

// Homework header
echo "<h2>Homework 4 Payut Surapinchai</h2>";

// Avoid fatal crashes (so I could see my errors that I've specified in each sections)
mysqli_report(MYSQLI_REPORT_OFF);

// Initialize servername, username, password, and dbname variables to connect to the car_rental database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental";

// Connect to the car rental database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if there was an error with the connection
if ($conn->connect_error)
{
    // Print out error message
    die("Connection failed: " . $conn->connect_error);
}

// If no error, then the database was connected succesfully
echo "<b>Connected successfully </b><br>";
echo "<b>Showing the database results </b><br>";
echo "<br>";

// Query 1: Print the list of customers

// Select Customer table with all values
$sql_cust = "SELECT * FROM Customer";

// Connect the query to the database
$result = $conn->query($sql_cust);

// If the results had more than 1 row, then run this block of code
if ($result->num_rows > 0)
{
    // Print Customers List header
    echo "<b>Customers List</b><br>";

    // Configure the table that contains the customer records
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr>
            <th>Customer ID</th>
            <th>Customer First Name</th>
            <th>Customer Last Name</th>
            <th>Phone Number</th>
          </tr>";

    // Print each Customer records as rows in the table
    while ($row = $result->fetch_assoc())
    {
        echo "<tr>";
        echo "<td>" . $row["id"]                 . "</td>";
        echo "<td>" . $row["first_name"]         . "</td>";
        echo "<td>" . $row["last_name"]          . "</td>";
        echo "<td>" . $row["phone"]              . "</td>";
        echo "</tr>";
    }

    // End the table
    echo "</table>";

    // Add a new line
    echo "<br>";
}

// If the results had no rows, then show this message
else
{
    echo "<b>No customer records existed.</b>";
}

// Query 2: Print the list of cars (with Car specifications and types)

// Select values from Car table and use CASE statement to help determine subtypes
// (CASE statement figures out the type based on which subtype table has a match)
$sql_car = "SELECT c.Vid, c.make, c.model, c.year, c.daily_rate, c.weekly_rate, 
               c.avail_start_date, c.avail_end_date,
            CASE
                WHEN v.Vid IS NOT NULL THEN 'Van'
                WHEN t.Vid IS NOT NULL THEN 'Truck'
                WHEN s.Vid IS NOT NULL THEN 'SUV'
                WHEN l.Vid IS NOT NULL THEN 'Large'
                WHEN m.Vid IS NOT NULL THEN 'Med'
                WHEN co.Vid IS NOT NULL THEN 'Compact'
                ELSE 'Unknown'
            END AS car_type
            FROM Car c
            LEFT JOIN Van v     ON c.Vid = v.Vid
            LEFT JOIN Truck t   ON c.Vid = t.Vid
            LEFT JOIN SUV s     ON c.Vid = s.Vid
            LEFT JOIN Large l   ON c.Vid = l.Vid
            LEFT JOIN Med m     ON c.Vid = m.Vid
            LEFT JOIN Compact co ON c.Vid = co.Vid
            ORDER BY car_type, c.Vid";

// Connect the query to the database
$result = $conn->query($sql_car);

// If the results had more than 1 row, then run this block of code
if ($result->num_rows > 0)
{
    // Print List of Cars
    echo "<b> List of Cars</b><br>";

    // Configure table for storing Car records
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr>
            <th>Vid</th>
            <th>Type</th>
            <th>Make</th>
            <th>Model</th>
            <th>Year</th>
            <th>Daily Rate</th>
            <th>Weekly Rate</th>
            <th>Available From</th>
            <th>Available To</th>
          </tr>";

    // Print each car records as rows in the table
    while ($row = $result->fetch_assoc())
    {
        echo "<tr>";
        echo "<td>" . $row["Vid"]              . "</td>";
        echo "<td>" . $row["car_type"]         . "</td>";
        echo "<td>" . $row["make"]             . "</td>";
        echo "<td>" . $row["model"]            . "</td>";
        echo "<td>" . $row["year"]             . "</td>";
        echo "<td>$". $row["daily_rate"]       . "</td>";
        echo "<td>$". $row["weekly_rate"]      . "</td>";
        echo "<td>" . $row["avail_start_date"] . "</td>";
        echo "<td>" . $row["avail_end_date"]   . "</td>";
        echo "</tr>";
    }

    // End the table
    echo "</table>";

    // Add a new line
    echo "<br>";
}

// If there were no car records in the table, then print "No cars found."
else
{
    echo "<b>No cars found.</b>";
}


// Query 3: Print the information on the car rental (active and scheduled) with customer information who rented the car.

// Select values from Customer, Rent, Rental, and Car tables for displaying the information on car rental
$sql_carrental = "SELECT Rid, Customer.first_name, Customer.last_name, Customer.phone, Car.make, Car.model, Car.year FROM Customer, Rent, Rental, Car WHERE (Rental.status = 'active' OR Rental.status = 'scheduled') AND 
         Rent.Rid = Rental.id AND Rent.cust_id = Customer.id AND Rent.Vid = Car.Vid";

// Connect query to database
$result = $conn->query($sql_carrental);

// If the results had more than 1 row, then run this block of code
if($result->num_rows > 0)
{
    // Print list of customers who rented the car
    echo "<b>List of Customers who Rented the Car</b>";

    // Configure the table for storing car rentals information
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr>
            <th>Rental ID</th>
            <th>Customer First Name</th>
            <th>Customer Last Name</th>
            <th>Customer Phone</th>
            <th>Make</th>
            <th>Model</th>
            <th>Year</th>
          </tr>";

    // Print each car rental records as rows in the table
    while ($row = $result->fetch_assoc())
    {
        echo "<tr>";
        echo "<td>" . $row["Rid"]               . "</td>";
        echo "<td>" . $row["first_name"]        . "</td>";
        echo "<td>" . $row["last_name"]         . "</td>";
        echo "<td>" . $row["phone"]             . "</td>";
        echo "<td>" . $row["make"]              . "</td>";
        echo "<td>" . $row["model"]             . "</td>";
        echo "<td>" . $row["year"]              . "</td>";
        echo "</tr>";
    }

    // End the table
    echo "</table>";

    // Add a newline
    echo "<br>";
} 

// If there were no car rental records, print "No records found."
else 
{
    echo "<b>No records found.</b>";
}

// These are "forms" for part 2 of the Homework 4
// each if-else code blocks will retrieve information from what the user input and will either update
// or insert the input values into the database

// If the user input a new customer, then run this block of code
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["form_type"] == "customer") 
{
    // Store the user inputs in their respective variables
    $id = $_POST["id"];
    $first_name = $_POST["first_name"];  
    $last_name = $_POST["last_name"];
    $phone = $_POST["phone"];

    // Query for inserting user input into the database
    $sql_cust = "INSERT INTO Customer (id, first_name, last_name, phone)
        VALUES ($id, '$first_name', '$last_name', '$phone')";
    
    // Connect the query to the database, if the query was successful, then print "Customer added successfully!"
    if ($conn->query($sql_cust)) {
        echo "<b>Customer added successfully!</b></br>";
    } 

    // If the query wasn't successful, print out the error without crashing the program
    else 
    {
        echo "<b>Error: </b>" . $conn->error;
    }
}

// If the user input a new car, then run this block of code
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["form_type"] == "car") 
{
    // Store the user inputs in their respective variables
    $Vid = $_POST["Vid"];
    $model = $_POST["model"];  
    $year = $_POST["year"];
    $make = $_POST["make"];
    $daily_rate = $_POST["daily_rate"];  
    $weekly_rate = $_POST["weekly_rate"];
    $avail_start_date = $_POST["avail_start_date"];
    $avail_end_date = $_POST["avail_end_date"];
    $car_type = $_POST["car_type"];

    // Query for inserting a new car into the Car table
    $sql_car = "INSERT INTO Car (Vid, model, year, make, daily_rate, weekly_rate, avail_start_date, avail_end_date)
                VALUES ($Vid, '$model', $year, '$make', $daily_rate, $weekly_rate, '$avail_start_date', '$avail_end_date')";

    // Query for inserting a new vehicle ID into their respective car type
    $sql_cartype = "INSERT INTO $car_type (Vid) VALUES ($Vid)";
    
    // If the query was successful(for inserting new car), then run this block of code
    if ($conn->query($sql_car)) 
    {
        echo "<b>Car added successfully!</b><br>";

        // If the query was successful(for adding a new car into their respective car type), then print the successful message
        if ($conn->query($sql_cartype)) 
        {
            echo "<b>Car type added successfully!</b><br>";
        } 

        // If the query wasn't successful, then display the error message
        else 
        {
            echo "<b>Error: </b>" . $conn->error;
        }
    }   
    
    // if the query wasn't successful(for inserting new car), then display error message
    else 
    {
        echo "<b>Error: </b>" . $conn->error;
    }
}

// If the user input a new car rental in the "rental" form, then run this block of code
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["form_type"] == "rental") 
{
    // Store the user inputs in their respective variables
    $cust_id = $_POST["cust_id"];
    $rent_id = $_POST["rent_id"];  
    $car_type = $_POST["car_type"];
    $avail_start_date = $_POST["avail_start_date"];
    $rental_type = $_POST["rental_type"];
    $duration = $_POST["duration"];

    // Query for finding if any of the car in that car type is free or available for rent or not
    $sql_freecar = "SELECT C.Vid FROM Car C JOIN $car_type ON $car_type.Vid = C.Vid WHERE C.Vid NOT IN
                    (SELECT Vid FROM Rent) LIMIT 1";

    // Connect the query to database
    $result_car = $conn->query($sql_freecar);

    // Query for checking if the rental id that was entered, violates the PRIMARY KEY constraint or not
    $rental = "SELECT id FROM Rental where id = $rent_id";

    // Connect the query to the database
    $rental_check = $conn->query($rental);

    // Check if the rental id already exists or not, if not then run other queries
    // If the rental id alredy exists, display the error message
    if($rental_check)
    {
        echo "<b>Error:</b> Rental ID already exists.";
    }

    // If the rental id never existed, then run this block of code
    else
    {
        // If the results had more than 1 row, then run this block of code
        if ($result_car->num_rows > 0) 
        {
            // Get the values from the "$result_car" query
            $freecar = $result_car->fetch_assoc();

            // Store the Vid from the result query 
            $Vid = $freecar["Vid"];

            // Query for inserting a new rental into the rental table
            $sql_rental = "INSERT INTO Rental (id, status, start_date) 
                        VALUES ($rent_id, 'scheduled', '$avail_start_date')";

            // Query for inserting new information about the rental into rent table
            $sql_rent = "INSERT INTO Rent (cust_id, Rid, Vid) 
                        VALUES ($cust_id, $rent_id,  $Vid)";

            // Connect both queries to database
            $conn->query($sql_rental);
            $conn->query($sql_rent);

            // Let the user know the query was successful
            echo "Rental of the car is available!<br>";

            // Check if the rental type was daily or weekly to enter the data in the correct table
            // If the rental type was daily, then run this block of code
            if($rental_type == "daily")
            {
                // Query for inserting the new rental into Daily table
                $sql_daily = "INSERT INTO Daily (Rid, no_of_days) 
                            VALUES ($rent_id, $duration)";

                // Connect the query to the database
                $conn->query($sql_daily);
            }

            // Since we know it can only be daily or weekly, this code block will only run if rental type is weekly
            else
            {
                // Query for inserting the new rental into Daily table
                $sql_weekly = "INSERT INTO Weekly (Rid, no_of_weeks)
                            VALUES ($rent_id, $duration)";

                // Connect the query to the database
                $conn->query($sql_weekly);
            }
        } 

        // If the $result_car query didn't have any results, then print the message that "Mo car was available."
        else 
        {
            echo "<b>No car is available.</b><br>";    
        }
    }

}

// If the user want to return their rented car, then run this block of code
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["form_type"] == "rented") 
{
    // Store the user input in their respective variable
    $rent_id = $_POST["rent_id"];  

    // Query the Rent ID from the Daily table that matches the user input's rent_id
    $sql_daily = "SELECT * FROM Daily WHERE $rent_id = Rid";

    // Query the Rent ID from the Weekly table that matches the user input's rent_id
    $sql_weekly = "SELECT * FROM Weekly WHERE $rent_id = Rid";

    // Connect the queries to the database
    $sql_dailycheck = $conn->query($sql_daily);
    $sql_weeklycheck = $conn->query($sql_weekly);

    // If the car was rented daily, then run this block of code
    if($sql_dailycheck->num_rows > 0)
    {
        // Query to select the daily rate and number of days that the car was rented for
        $sql_rented = "SELECT daily_rate, no_of_days FROM Car, Rent, Daily WHERE Rent.Rid = $rent_id AND Rent.Vid = Car.Vid AND Daily.Rid = $rent_id";

        // Connect the query to database
        $result_rented = $conn->query($sql_rented);

        // Get the records from the query's results
        $rows_rented = $result_rented->fetch_assoc();

        // Get the daily rate and the number of days
        $daily_rate = $rows_rented["daily_rate"];
        $no_of_days = $rows_rented["no_of_days"];

        // Calculate the total value
        $total = $daily_rate * $no_of_days;
        
        // Let the user know that the car was successfully returned
        echo "<b>The car was successfully returned.</b><br>";

        // Display the total payment due
        echo "<b>Total Payment due: $". $total. "</b><br>";

        // Update the rental status of the car to be "returned"
        $sql_update = "UPDATE Rental SET status = 'returned' WHERE id = $rent_id";

        // Connect the query to the database
        $conn->query($sql_update);
    }
    // If the car was rented weekly, then run this block of code
    else if($sql_weeklycheck->num_rows > 0)
    {
        // Query to select the weekly rate and number of weeks that the car was rented for
        $sql_rented = "SELECT weekly_rate, no_of_weeks FROM Car, Rent, Weekly WHERE Rent.Rid = $rent_id AND Rent.Vid = Car.Vid AND Weekly.Rid = $rent_id";

        // Connect the query to database
        $result_rented = $conn->query($sql_rented);

        // Get the records from the query's results
        $rows_rented = $result_rented->fetch_assoc();

        // Get the weekly rate and the number of weeks
        $weekly_rate = $rows_rented["weekly_rate"];
        $no_of_weeks = $rows_rented["no_of_weeks"];

        // Calculate the total
        $total = $weekly_rate * $no_of_weeks;
        
        // Let the user know that the car was successfully returned
        echo "<b>The car was successfully returned.</b><br>";

        // Display the total payment due
        echo "<b>Total Payment due: $". $total. "</b><br>";

        // Update the rental status of the car to be "returned"
        $sql_update = "UPDATE Rental SET status = 'returned' WHERE id = $rent_id";

        // Connect the query to database
        $conn->query($sql_update);
    }
    
    // If the car rental query didn't find any records, print "Car rental was not found." message
    else
    {
        echo "<b>Car rental was not found.</b>";
    }
}

// If the user wants to update the daily rate and weekly rate of a car, then run this block of code
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["form_type"] == "update_rate") 
{
    // Store the user inputs in their respective variables
    $Vid = $_POST["vid"];  
    $daily_rate = $_POST["daily_rate"];
    $weekly_rate = $_POST["weekly_rate"];

    // Query to select vehicle ID and its daily & weekly rate
    $car = "SELECT Vid, daily_rate, weekly_rate FROM Car WHERE Vid = $Vid";

    // Connect the query to the database
    $result_car = $conn->query($car);

    // If the results had more than 1 row, then run this block of code
    if($result_car->num_rows > 0)
    {
        // Update the daily rate and the weekly rate of the car
        $sql_update = "UPDATE Car SET daily_rate = $daily_rate, weekly_rate = $weekly_rate WHERE Vid = $Vid";

        // Connect the query to the database
        $conn->query($sql_update);

        // Print out the message to let them know the rates were updated
        echo "<b>The daily rate and weekly rate were updated successfully.</b>";
    }

    // If the car didn't exist, then display "Car was not found." message
    else
    {
        echo "<b>Car was not found.</b>";
    }
}

// Close the "$conn" because we are done with all the queries
$conn->close();
?>

<!-- Add a header -->
<h3>Add a new customer</h3>

<!-- Specify the form's type, name, and its value -->
<form method="POST" action="">
    <input type="hidden" name="form_type" value="customer">

    <!-- Get the user input for the new customer details -->
    Customer ID:         <input type="number" name="id"><br>
    First Name:          <input type="text" name="first_name"><br>  
    Last Name:           <input type="text" name="last_name"><br>
    Phone:               <input type="text" name="phone"><br>
    
<!-- Show the button for submitting the new customer details -->
<button type="submit">Add Customer</button>

<!-- End the form -->
</form>

<!-- Add a header -->
<h3>Add a new car</h3>

<!-- Specify the form's type, name, and its value -->
<form method="POST" action="">
    <input type="hidden" name="form_type" value="car">

    <!-- Get the user input for the new car details -->
    Vehicle ID:         <input type="number" name="Vid"><br>
    Car Model:          <input type="text" name="model"><br>  
    Car Year:           <input type="number" name="year"><br>
    Car Make:           <input type="text" name="make"><br>
    Daily Rate:         <input type="number" name="daily_rate"><br>
    Weekly Rate:        <input type="number" name="weekly_rate"><br>  
    Start Date:         <input type="date" name="avail_start_date"><br>
    End Date:           <input type="date" name="avail_end_date"><br>
    Car Type:           <select name="car_type">  <!-- this will show a drop down menu with options specified below -->
                        <option value="Van">Van</option>
                        <option value="Truck">Truck</option>
                        <option value="SUV">SUV</option>
                        <option value="Large">Large</option>
                        <option value="Med">Med</option>
                        <option value="Compact">Compact</option>
                        </select><br>

<!-- Show the button for submitting the new car details-->
<button type="submit">Add Car</button>

<!-- End the form -->
</form>

<!-- Add a header -->
<h3>Add a rental</h3>

<!-- Specify the form's type, name, and its value -->
<form method="POST" action="">
    <input type="hidden" name="form_type" value="rental">

    <!-- Get the user input for the new rental details -->
    Customer ID:         <input type="number" name="cust_id"><br>
    Rental ID:           <input type="number" name="rent_id"><br>  
    Car Type:            <select name="car_type">
                         <option value="Van">Van</option>
                         <option value="Truck">Truck</option>
                         <option value="SUV">SUV</option>
                         <option value="Large">Large</option>
                         <option value="Med">Med</option>
                         <option value="Compact">Compact</option>
                         </select><br>
    Start Date:          <input type="date" name="avail_start_date"><br>
    Rental Type:         <select name="rental_type">
                         <option value="daily">Daily</option>
                         <option value="weekly">Weekly</option>
                         </select><br>
    How long:            <input type="number" name="duration"><br>
    
<!-- Show the button for submitting new rental details -->
<button type="submit">Add Rental</button>

<!-- End the form -->
</form>

<!-- Add a header -->
<h3>Return a rental car</h3>

<!-- Specify the form's type, name, and its value -->
<form method="POST" action="">
    <input type="hidden" name="form_type" value="rented">

    <!-- Get user input for rental id -->
    Rental ID:           <input type="number" name="rent_id"><br>  
    
<!-- Show the button for returning the rented car -->
<button type="submit">Return Rental Car</button>

<!-- End the form -->
</form>

<!-- Add a header -->
<h3>Update daily & weekly rates</h3>

<!-- Specify the form's type, name, and its value -->
<form method="POST" action="">
    <input type="hidden" name="form_type" value="update_rate">

    <!-- Get user input for updating the car daily & weekly rates -->
    Vehicle ID:          <input type="number" name="vid"><br> 
    Daily Rate:          <input type="number" name="daily_rate"><br>
    Weekly Rate:         <input type="number" name="weekly_rate"><br> 
    
<!-- Show the button for submitting the new rates -->
<button type="submit">Update Rates</button>

<!-- End the form -->
</form>

<!-- End the HTML body -->
</body>

<!-- End the HTML -->
</html>       