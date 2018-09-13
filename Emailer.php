<?php
/**
 * User: Charles Broderick
 * Email: Charwillbro@gmail.com
 * Date: 9/4/2018
 * Time: 1:27 PM
 */

//you want to match the class name with the filename
class Emailer
{ //you must state you are making a class then name it. Classes are usually capitalized

    // property declarations, be sure to declare a scope. public = global, private = local

    private $messageLine = "";
    private $senderAddress = "";
    private $sendToAddress = "";
    private $subjectLine = "";

    // define methods of the class

    //constructor method
    public function __construct()
    { // note 2 underscores, and are always public

    }

    //set methods

    public function setMessageLine($inMessageLine)
    {
         $this->messageLine = $inMessageLine;
    }

    public function setSenderAddress($inSenderAddress)
    {
        $this->senderAddress = $inSenderAddress;
    }

    public function setSendToAddress($inSendToAddress)
    {
        $this->sendToAddress = $inSendToAddress;
    }

    public function setSubjectLine($inSubjectLine)
    {
        $this->subjectLine = $inSubjectLine;
    }


    //get methods

    public function getMessageLine()
    {
        return $this->messageLine;
    }

    public function getSenderAddress()
    {
        return $this->senderAddress;
    }

    public function getSendToAddress()
    {
        return $this->sendToAddress;
    }

    public function getSubjectLine()
    {
        return $this->subjectLine;
    }

    //processing methods

    public function sendPHPEmail(){
        $formattedSenderAddress = "From: $this->senderAddress"; //formats the sender into the proper "From" format

        $formattedMessage = wordwrap($this->messageLine,70,"\r\n");

        return mail($this->sendToAddress,$this->subjectLine,$formattedMessage,$formattedSenderAddress);

    }



}

?>