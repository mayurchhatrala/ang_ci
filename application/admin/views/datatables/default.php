<?php

$jsonValue = array(
    "bStateSave" => true,
    "bProcessing" => true,
    "bServerSide" => true,
    "sServerMethod" => "POST"
);

switch ($caseValue) {
    case 'userList' :
        $jsonValue["sAjaxSource"] = BASE_URL . "user/userRecord";
        $jsonValue['aoColumns'] = array(
            0 => array(
                "mData" => "userName"
            ),
            1 => array(
                "mData" => "userEmail"
            ),
            2 => array(
                "mData" => "userMobile"
            ),
            3 => array(
                "mData" => "userId"
            )
        );
        $jsonValue["aoColumnDefs"] = array(
            0 => array(
                "aTargets" => "[3]",
                "mRender" => "<a class=\"btn btn-info btn-sm\">Edit</a>"
            )
        );
        break;
}

echo json_encode($jsonValue);
