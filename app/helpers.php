<?php


function coustom_response($stutas , $message , $data ,$stutasCode = 200){
    return response()->json(['stutas'=>$stutas , 'message' => $message , 'data' => $data],$stutasCode);
}

