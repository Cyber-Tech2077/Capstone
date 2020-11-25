class ContentControl {
    constructor(event) {
        if (event !== null) {
            this.keyCode = event.keyCode;
            this.shiftKey = event.shiftKey;
        }
    }
    // This limits the user on current or future dates in the input elements
    // that are specified to the date category. Calendars in the browser will
    // only show todays date and beyond. All previous dates before today are
    // disabled and can one longer be used.
	limitedDatePeriod() {
		var currentMonth = new Date().getMonth();
        if (currentMonth > 0 && currentMonth < 10) {
            currentMonth = "0" + currentMonth;
        } else {
            currentMonth += 1;
        }
        var currentDay = new Date().getDate();
        if (currentDay < 10) {
            currentDay = "0" + currentDay;
        }
		return new Date().getFullYear() + '-' + currentMonth + '-' + currentDay;
	}
    // This will prevent letters and symbols from entering into the zipcode textbox.
    keyboardNumbers() {
        if (this.shiftKey == false) {
            // Keycodes are unicode values associated with each key on the keyboard .
            // When a key is pressed, a unicode number is returned associated with
            // that specific key that was pressed.
            if (this.keyCode >= 48 && this.keyCode <= 57 || this.keyCode >= 96 && this.keyCode <= 105 || this.keyCode == 8) {
                this.setBoolValue = true;
            } else {
                this.setBoolValue = false;
            }
        } else {
            this.setBoolValue = false;
        }
        return this.setBoolValue;
    }
}