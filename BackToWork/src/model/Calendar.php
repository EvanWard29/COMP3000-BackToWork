<?php
class Calendar {
    private $dayLabels = array("Mon","Tues","Wed","Thur","Fri","Sat","Sun");
    private $currentYear = 0;
    private $currentMonth = 0;
    private $currentDay = 0;
    private $currentDate = null;
    private $daysInMonth = 0;
    private $naviHref = null;

    /** Constructor **/
    public function __construct(){
        $this->naviHref = htmlentities($_SERVER['PHP_SELF']);
    }


    /** Methods **/
    //Function for building and presenting the calendar
    public function show() {
        $year  = null;
        $month = null;

        //Get Current Year
        if(null==$year&&isset($_GET['year'])){

            $year = $_GET['year'];

        }else if(null==$year){

            $year = date("Y",time());

        }

        //Get Current Month
        if(null==$month&&isset($_GET['month'])){

            $month = $_GET['month'];

        }else if(null==$month){

            $month = date("m",time());

        }

        $this->currentYear=$year;
        $this->currentMonth=$month;

        //Get the number of days in current month
        $this->daysInMonth=$this->_daysInMonth($month,$year);

        $content='<div id="calendar" class="container">'.
            '<div class="calendarHeader">'.
                $this->_createNavi().
            '</div>'.
            '<div class="calendarBorder">'.
            '<ul class="list-group list-group-horizontal text-center" id="calendarLabels">'.
                $this->_createLabels().
            '</ul>';
        $content.='<div class="clear"></div>';

        $weeksInMonth = $this->_weeksInMonth($month,$year);
        // Create weeks in a month
        for( $i=0; $i<$weeksInMonth; $i++ ){
            $content.='<ul class="list-group list-group-horizontal text-center">';

            //Create days in a week
            for($j=1;$j<=7;$j++){
                $content.=$this->_showDay($i*7+$j);
            }
            $content.='</ul>';
        }


        $content.='<div class="clear"></div>';

        $content.='</div>';

        $content.='</div>';
        return $content;
    }

    //Function for showing the dates of the month
    private function _showDay($cellNumber){
        if($this->currentDay==0){

            $firstDayOfTheWeek = date('N',strtotime($this->currentYear.'-'.$this->currentMonth.'-01'));

            if(intval($cellNumber) == intval($firstDayOfTheWeek)){

                $this->currentDay=1;

            }
        }

        if( ($this->currentDay!=0)&&($this->currentDay<=$this->daysInMonth) ){

            $this->currentDate = date('Y-m-d',strtotime($this->currentYear.'-'.$this->currentMonth.'-'.($this->currentDay)));

            $cellContent = $this->currentDay;

            $this->currentDay++;

        }else{

            $this->currentDate =null;

            $cellContent=null;
        }

        if($cellNumber % 7 == 1){
            //Start of week
            return '<li id="'.$this->currentDate.'" class="start list-group-item day">'.$cellContent.'</li>';
        }else if($cellNumber % 7 == 0){
            //End of week
            return '<li id="'.$this->currentDate.'" class="end list-group-item day">'.$cellContent.'</li>';
        }else if($cellContent == null){
            //Mask
            return '<li id="'.$this->currentDate.'" class="mask list-group-item day">'.$cellContent.'</li>';
        }else{
            return '<li id="'.$this->currentDate.'" class="list-group-item day">'.$cellContent.'</li>';
        }
    }

    //Function for creating the calendar header for navigation
    private function _createNavi(){
        $nextMonth = $this->currentMonth==12?1:intval($this->currentMonth)+1;
        $nextYear = $this->currentMonth==12?intval($this->currentYear)+1:$this->currentYear;
        $preMonth = $this->currentMonth==1?12:intval($this->currentMonth)-1;
        $preYear = $this->currentMonth==1?intval($this->currentYear)-1:$this->currentYear;

        return
            '<div class="row">'.
                '<div class="col prev">'.
                    '<a class="" style="color:#000; text-decoration: none" href="'.$this->naviHref.'?month='.sprintf('%02d',$preMonth).'&year='.$preYear.'">Prev</a>'.
                '</div>'.
                '<div class="col date">'.
                    '<span class="" style="color:#000; bottom:20px;" >'.date('Y M',strtotime($this->currentYear.'-'.$this->currentMonth.'-1')).'</span>'.
                '</div>'.
                '<div class="col next">'.
                    '<a class="" style="color:#000; text-decoration: none" href="'.$this->naviHref.'?month='.sprintf("%02d", $nextMonth).'&year='.$nextYear.'">Next</a>'.
                '</div>'.
            '</div>';
    }

    //Function for creating the labels of the calendar (days)
    private function _createLabels(){

        $content='';

        foreach($this->dayLabels as $index=>$label){

            $content.='<li id="" class="list-group-item day label">'.$label.'</li>';

        }

        return $content;
    }

    //Function for calculating the number of weeks in the currently selected month
    private function _weeksInMonth($month=null,$year=null){
        if( null==($year) ) {
            $year =  date("Y",time());
        }

        if(null==($month)) {
            $month = date("m",time());
        }

        // find number of days in this month
        $daysInMonths = $this->_daysInMonth($month,$year);

        $numOfweeks = ($daysInMonths%7==0?0:1) + intval($daysInMonths/7);
        $monthEndingDay= date('N',strtotime($year.'-'.$month.'-'.$daysInMonths));
        $monthStartDay = date('N',strtotime($year.'-'.$month.'-01'));

        if($monthEndingDay<$monthStartDay){

            $numOfweeks++;

        }

        return $numOfweeks;
    }

    //Function for calculating the number of days in the currently selected month
    private function _daysInMonth($month=null,$year=null){
        if(null==($year))
            $year =  date("Y",time());

        if(null==($month))
            $month = date("m",time());

        return date('t',strtotime($year.'-'.$month.'-01'));
    }

}