<?php
require_once('dbconfig.php');
include("stripe/init.php");

class STRIPE
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	

	
	public function get_all_plane()
	{
		


		
\Stripe\Stripe::setApiKey("sk_test_dtjtbPJYe3Ctg8DUo6N0EcZz");



				 $getall_plan = \Stripe\Plan::all(array("limit" => 4));		
				  // return $getall_plan;	
				  $getall_plan = json_encode($getall_plan);	
			
		

				try
		{
				$obj=json_decode($getall_plan, true);

				foreach ($obj['data'] as $k => $plan) {

				$plan_id= $plan['id'];
				$plan_object = $plan['object'];
				$plan_amount= $plan['amount'];
				$plan_created= $plan['created'];
				$plan_currency= $plan['currency'];
				$plan_interval= $plan['interval'];
				$plan_interval_count= $plan['interval_count'];
				$plan_livemode= $plan['livemode'];
				//$plan_metadata= $plan['metadata'];
				$plan_name= $plan['name'];
			//$plan_statement_descriptor= $plan['statement_descriptor'];
				$plan_trial_period_days= $plan['trial_period_days'];
			
		//echo $sql="INSERT INTO `stripe_plan`(`plan_id`, `plan_object`, `plan_amount`, `plan_created`, `plan_currency`, `plan_interval`, `plan_interval_count`, `plan_livemode`, `plan_metadata`, `plan_name`, `plan_statement_descriptor`, `plan_trial_period_days`) VALUES (:plan_id,:plan_object,:plan_amount,:plan_created,:plan_currency,:plan_interval,:plan_interval_count,:plan_livemode,:plan_metadata,:plan_name,:plan_statement_descriptor,:plan_trial_period_days)";
			//	echo "<br>";


	     $stmt = $this->conn->prepare("INSERT INTO `stripe_plan`(`plan_id`, `plan_object`, `plan_amount`, `plan_created`, `plan_currency`, `plan_interval`, `plan_interval_count`, `plan_livemode`, `plan_name`) VALUES (:plan_id,:plan_object,:plan_amount,:plan_created,:plan_currency,:plan_interval,:plan_interval_count,:plan_livemode,:plan_name)");

			
												  
			$stmt->bindparam(":plan_id", $plan_id);
			$stmt->bindparam(":plan_object", $plan_object);
			$stmt->bindparam(":plan_amount", $plan_amount);		
		    $stmt->bindparam(":plan_created", $plan_created);
			$stmt->bindparam(":plan_currency", $plan_currency);
			
		    $stmt->bindparam(":plan_interval", $plan_interval);
			$stmt->bindparam(":plan_interval_count", $plan_interval_count);
			$stmt->bindparam(":plan_livemode", $plan_livemode);	
		   // $stmt->bindparam(":plan_metadata", $plan_metadata);	
		    $stmt->bindparam(":plan_name", $plan_name);	
			//$stmt->bindparam(":plan_statement_descriptor", $plan_statement_descriptor);			
		//	$stmt->bindparam(":plan_trial_period_days", $plan_trial_period_days);	
		
				
			$stmt->execute();	
		}
			return $stmt;	
		}
		catch(PDOException $e)
		{
			return $e->getMessage();
		}

		


	}
	
	
}

    $get_all_plane = new STRIPE();
  $res= $get_all_plane->get_all_plane();

//print_r($res);
if(strpos($res,"1062 Duplicate entry"))
{
echo "Already Add Your Plans";
}else{
	echo "Add Your Plans Succesfully";
}




?>