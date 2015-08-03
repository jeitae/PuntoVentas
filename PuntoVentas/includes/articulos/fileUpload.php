<?php
                        /***************
                        class name: upload
                        description: upload an image file to the destination directory
                        purpose: to upload an image file to the destination directory and manipulate the image file
                        author name: ashwin morey
                        created on: 17/11/2005
                        modified by:
                        modified on:
                        methods used:upload(constructor)
                        **************/
class upload{
  //to store name of the file
  var $fileName = 'fotos';
  //to store path of the temporary location of the uploaded file
  var $tempFileLoc;
  //to store size of the file
  var $fileSize;
  //to store type of the file
  var $fileType;
  //to store directory name of the file
  var $fileDir = 'maxcodeka';
  //to store actual destination of the file
  var $destination;
  //to store actual result
  var $move;
  //to store error messages
  var $message;
  //to store error number
  var $errNo = 0;

  /****************************
  function name: upload(constructor)
  description: constructor
  purpose: to set values for the variables $fileName, $destDir
  arguments: $fileName, $destDir
  returns: nothing
  ***********************************/
  function upload($fileName, $tempFileLoc, $fileSize, $fileDir){
    $this->fileName = $fileName;
    $this->tempFileLoc = $tempFileLoc;
    $this->fileSize = $fileSize;
    $this->fileDir = $fileDir;
    $this->destination = $this->fileDir."/".$this->fileName;
  }
  /***********************
  function name: fileUp()
  description: check whether file is uploaded 
  purpose:to check whether file is uploaded or not to the temporary location
  arguments: nothing
  returns: nothing
  ************************/
  function fileUp(){
    if(!is_uploaded_file($this->tempFileLoc)){
        $this->errNo = 1;
        return $this->errorHandler($this->errNo);
    }
    else{
        $this->dirExists();
    }
  }
  /***********************
  function name: dirExists()
  description: check whether destination directory exists
  purpose:to check whether destination directory exists
  arguments: nothing
  returns: nothing
  ************************/
  function dirExists(){
    if(!file_exists($this->fileDir)){
      $this->errNo = 2;
        return $this->errorHandler($this->errNo);
    }
    else{
      if(!is_dir($this->fileDir)){
        $this->errNo = 3;
        return $this->errorHandler($this->errNo);
      }
      else{
        $this->fileAlreadyExists();
      }
    }
  }
  /***********************
  function name: fileAlreadyExists()
  description: check whether file is already there
  purpose:to check whether file is already there
  arguments: nothing
  returns: nothing
  ************************/
  function fileAlreadyExists(){
    if(file_exists($this->destination)){
        $this->errNo = 4;
        return $this->errorHandler($this->errNo);
    }
    else{
        $this->moveFile();
    }
  }
  /***********************
  function name: moveFile()
  description: move uploaded file to the destination
  purpose:to move uploaded file to the destination
  arguments: nothing
  returns: nothing
  ************************/
  function moveFile(){
    $this->move = move_uploaded_file($this->tempFileLoc,$this->destination);
    if($this->move == false){
      $this->errNo = 5;
      return $this->errorHandler($this->errNo);
    }
    else{
      $this->errNo = 6;
      $this->errorHandler($this->errNo);
    }
  }
  /***********************
  function name: errorHandler()
  description: generate errors
  purpose: to generate errors and display them
  arguments: takes error number as an input
  returns: error Message
  ************************/
  function errorHandler($errNo){
    if($errNo == 1){
      $message = "No file uploaded to the temporary location.";
      echo $message;
    }
    else if($errNo == 2){
      $message = "Destination directory does not exist.";
      echo $message;
    }
    else if($errNo == 3){
      $message = "Destination is not a directory.";
      echo $message;
    }
    else if($errNo == 4){
      $message = "The file u are trying to upload already exists.";
      echo $message;
    }
    else if($errNo == 5){
      $message = "Something went wrong";
      echo $message;
    }
    else if($errNo == 6){
      $message = "File uploaded successfully to the desired location.";
      echo $message;
    }
    return $message;
  }
}

