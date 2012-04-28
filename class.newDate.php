<?PHP
	/*
	*	class.newDate.php
	*	author: Jono Gould
	*	last updated: 28 April 2012
	*	description: Allows you to extend the reach of the default php date function.
	*/

	class NewDate {
		var $day;
		var $month;
		var $year;
		
		var $monthNames = array(
			1=>"January", 2=>"February", 3=>"March", 
			4=>"April", 5=>"May", 6=>"June", 7=>"July", 
			8=>"August", 9=>"September", 10=>"October", 
			11=>"November", 12=>"December");
		
		//	The default constructor
		public function __construct($value) {
			$temp = explode('-', $value);
			
			$this->day = (int)$temp[2];
			$this->month = (int)$temp[1];
			$this->year = (int)$temp[0];
		}
		
		//	Returns the date in format YYYY-MM-DD
		public function __toString() {
			return $this->year . '-' . $this->addZero($this->month) . '-' . $this->addZero($this->day);
		}
		
		public function getDay() {
			return $this->day;
		}
		
		public function setDay($value) {
			$this->day = $value;
		}
		
		public function getMonth() {
			return $this->month;
		}
		
		public function getYear() {
			return $this->year;
		}
		
		//	If the day or month does not have a 0, add it
		public function addZero($value) {
			return ($value < 10) ? '0' . $value : $value;
		}
	
		//	Returns a long representation of a date
		public function toLongFormat() {
			return $this->day . ' ' . $this->monthNames[$this->month] . ' ' . $this->year;
		}
		
		//	Returns a short representation of a date
		public function toShortFormat() {
			$temp = explode('-', $this->d);
			return $this->day . ' ' . substr($this->monthNames[$this->month], 0, 3) . ' ' . $this->year;
		}
		
		//	Returns a long representation of a date specifically for terms
		public function toTermsFormat() {
			return date("M Y", strtotime($this->year . '-' . $this->month . '-1'));
		}
		
		//	Gets a workable year if greater than 2037
		public function tempWorkingYear($y) {
			$temp = $y;
			
			while ($temp > 2036) {
				$temp -= 4;
			}
			
			while ($temp < 1970) {
				$temp += 4;
			}
			
			return $temp;
		}
		
		//	Check if the year is a leap year
		public function isLeapYear() {
			$temp = $this->tempWorkingYear($this->year);

			return (date('L', strtotime($temp . '-' . $this->month . '-' . $this->day)) == 1) ? true : false;
		}
		
		//	Return the number days in the month
		public function daysInMonth() {
			$temp = $this->tempWorkingYear($this->year);
			return (date('t', strtotime($temp . '-' . $this->month . '-' . $this->day)));
		}
		
		//	Return the fraction of the month to date (i.e. 2012/11/15 will return ±0.5)
		public function partMonthFactor() {
			return ($this->day == 1) ? 1 : 1 - ($this->day / $this->daysInMonth());
		}
		
		//	Get the day of the year
		public function dayOfYear() {
			$temp = $this->tempWorkingYear($this->year);
			return (date('z', strtotime($temp . '-' . $this->month . '-' . $this->day)));
		}
		
		//	Step forward a month
		public function addMonth() {
			if ($this->month == 12) {
				$this->year++;
				$this->month = 1;
			}
			else {
				$this->month++;
			}
		}
		
		//	Step back a month
		public function minusMonth() {
			if ($this->month == 1) {
				$this->year--;
				$this->month = 12;
			}
			else {
				$this->month--;
			}
		}
		
		//	Add a specific number of years to the date
		public function addYears($value) {
			$this->year += $value;
		}
		
		//	Return true if date is in the past
		public function dateIsPast($doc) {
			if ($this->year <= 2037)
				return (strtotime($this) < strtotime($doc)) ? true : false;
			
			return false;
		}
		
		//	Compares self with another date and returns the difference (i.e. age)
		public function ageAtDate($newDate) {
			//	Explode the new date and get the temp working year
			$tempNewDate = explode('-', $newDate);
			$tempNewWorkingYear = (int)$this->tempWorkingYear($tempNewDate[0]);
			$newDate = $tempNewWorkingYear . '-' . $tempNewDate[1] . '-' . $tempNewDate[2];
			
			//	Get the temp working year of this->date
			$tempWorkingYear = (int)$this->tempWorkingYear($this->year);
			
			//	Do the calculation and add the 'illegal' years back on
			$diff = (strtotime($newDate) - strtotime($this)) / 31556926;
			$diff += ($tempNewDate[0] - $tempNewWorkingYear);
			
			return $diff;
		}
	}
?>