class ContentControl {
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
}