<?php

class Controller
{
    private $_f3; // router

    public function __construct($f3)
    {
        $this->_f3 = $f3;
    }



    public function home()
    {
        //echo '<h1>Welcome to my Food Page</h1>';

        $view = new Template();
        echo $view->render('views/home.html');
    }

    public function order()
    {
        //echo '<h1>Welcome to my Food Page</h1>';

        // If the form has been submitted
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            //var_dump($_POST);
            //array(2) { ["food"]=> string(5) "Tacos" ["meal"]=> string(2) "on" }

            // Validate the data
            /*
            if (empty($_POST['food']))
            {
                echo "<p>Please enter a food</p>";
            }
            elseif (!in_array($_POST['meal'], $meals))
            {
                echo "<p>Please enter a meal</p>";
            }
            */

            // Validate food
            if (!$GLOBALS['validator']->validFood($_POST['food']))
            {
                // Set an error variable in the F3 hive
                $this->_f3->set('errors["food]', "Invalid food item");
            }
            if (!$GLOBALS['validator']->validFood($_POST['meal']))
            {
                // Set an error variable in the F3 hive
                $this->_f3->set('errors["meal"]', "Invalid meal.");
            }
            // Data is valid
            if (empty( $this->_f3->get('errors')))
            {
                // Create an object
                $order = new Order();
                $order->setFood($_POST['food']);
                $order->setMeal($_POST['meal']);

                // Store the object in the session array
                $_SESSION['order'] = $order;

                // Redirect to condiments page
                $this->_f3->reroute('condiments');
            }
        }

        $this->_f3->set('meals', getmeals());
        $this->_f3->set('food', $_POST['food']);
        $this->_f3->set('selectedMeal', $_POST['meal']);
        $view = new Template();
        echo $view->render('views/orderForm.html');
    }

    public function order2()
    {
        $condiments = getCondiments();

        // Validate data
        //var_dump($_POST);
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            // Add the data to the object in the session array
            $_SESSION['order']->setCondiments($_POST['condiments']);

            // The above way is easier to do this is the long/hard way
            //$order = $_SESSION['order'];
            //$order->setCondiments();

            // Redirect to summary page
            $this->_f3->reroute('summary');
        }

        $this->_f3->set('condiments', $condiments);
        $view = new Template();
        echo $view->render('views/orderForm2.html');
    }

}