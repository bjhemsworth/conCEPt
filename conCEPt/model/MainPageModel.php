<?php

namespace Concept\Model;


use PDO;

class MainPageModel
{
    public function __construct()
    {
        $this->db = DB::getDB();
    }

    public function getStudentForms()
    {
        $marker = $this->getMarkerID();
        $statement = $this->db->prepare(
            "SELECT Student.Student_ID, Form.Form_ID, BaseForm.Form_title, Form.IsSubmitted, Form.IsMerged
				 FROM MS_Form
				 JOIN MS ON MS.MS_ID = MS_Form.MS_ID
				 JOIN Marker ON Marker.Marker_ID = MS.Marker_ID
				 JOIN Student ON Student.Student_ID = MS.Student_ID
				 JOIN Form ON Form.Form_ID=MS_Form.Form_ID
				 JOIN BaseForm ON BaseForm.BForm_ID=Form.BForm_ID
				 WHERE Marker.Marker_ID = :markerID
				 ORDER BY Student.Student_ID, BaseForm.BForm_ID;");

        $statement->bindValue(':markerID', $marker, PDO::PARAM_STR);
        $statement->execute();

        //fetch all forms, grouped by student ID
        return $statement->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
    }

    //Generates a list of students separated by examined and supervised

    public function getMarkerID()
    {
        return $_SERVER['REMOTE_USER'];
    }

    public function getStudentInformation()
    {
        $marker = $this->getMarkerID();
        $statement = $this->db->prepare(
            "SELECT Student.Student_ID, Student.Fname, Student.Lname, MS.IsSupervisor
				 FROM MS_Form
				 JOIN MS ON MS.MS_ID = MS_Form.MS_ID
				 JOIN Marker ON Marker.Marker_ID = MS.Marker_ID
				 JOIN Student ON Student.Student_ID = MS.Student_ID
				 WHERE Marker.Marker_ID = :markerID
				 GROUP BY Student.Student_ID
		");

        $statement->bindValue(':markerID', $marker, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_GROUP | PDO::FETCH_ASSOC);
    }
	
public function isMergedFormEdited($mergedFormID) {
		$statement = $this->db->prepare(
				"SELECT MergedForm.IsEdited
				 FROM MergedForm
				 WHERE MergedForm.MForm_ID = :mformID
			 ");

		$statement->bindValue(':mformID',$mergedFormID,PDO::PARAM_INT);
		$statement->execute();
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		if($results[0] === 1) {
			return True;
		}	
	
		return False;
	}

	public function isFormSubmitted($formID) {
		$statement = $this->db->prepare(
				"SELECT Form.IsSubmitted
				 FROM Form
				 WHERE Form.Form_ID = :formID
		");

		$statement->bindValue(":formID",$formID,PDO::PARAM_INT);
		$statement->execute();
		$results = $statement->fetchAll(PDO::FETCH_ASSOC);

		if($results[0] === 1) {
			return True;
		}
		return False;
	}

}
