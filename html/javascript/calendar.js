// Initialize the calendar
calendar=null;

// This function displays the calendar associated to the input field 'id'
function showCalendar2(id) {
	var el = document.getElementById(id);
	if (calendar != null) {
		// we already have some calendar created
		calendar.hide();  // so we hide it first.
	} else {
		// first-time call, create the calendar.
		var cal = new Calendar(true, null, selected, closeHandler);
		cal.weekNumbers = false;  // Do not display the week number
		cal.showsTime = true;     // Display the time
		cal.time24 = true;        // Hours have a 24 hours format
		cal.showsOtherMonths = false;    // Just the current month is displayed
		calendar = cal;                  // remember it in the global var
		cal.setRange(1900, 2070);        // min/max year allowed.
		cal.create();
	}

	calendar.setDateFormat('%Y-%m-%d %H:%M');    // set the specified date format
	calendar.parseDate(el.value);                // try to parse the text in field
	calendar.sel = el;                           // inform it what input field we use

	// Display the calendar below the input field
	calendar.showAtElement(el, "Br");        // show the calendar

	return false;
}

function showCalendar(id, format, showsTime, showsOtherMonths) {
  var el = document.getElementById(id);
  if (calendar != null) {
    // we already have some calendar created
    calendar.hide();                 // so we hide it first.
  } else {
    // first-time call, create the calendar.
    var cal = new Calendar(true, null, selected, closeHandler);
    // uncomment the following line to hide the week numbers
    // cal.weekNumbers = false;
    cal.showsTime = false;
    if (typeof showsTime == "string") {
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
      cal.showsOtherMonths = true;
    }
    calendar = cal;                  // remember it in the global var
    cal.setRange(1900, 2070);        // min/max year allowed.
    cal.create();
  }
  calendar.setDateFormat(format);    // set the specified date format
  calendar.parseDate(el.value);      // try to parse the text in field
  calendar.sel = el;                 // inform it what input field we use

  // the reference element that we pass to showAtElement is the button that
  // triggers the calendar.  In this example we align the calendar bottom-right
  // to the button.
  calendar.showAtElement(el, "Br");        // show the calendar

  return false;
}

// This function update the date in the input field when selected
function selected(cal, date) {
	cal.sel.value = date;      // just update the date in the input field.
}

// This function gets called when the end-user clicks on the 'Close' button.
// It just hides the calendar without destroying it.
function closeHandler(cal) {
	cal.hide();                        // hide the calendar
	calendar = null;
}
