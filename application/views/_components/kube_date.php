$(function()
{
        $('#date_picker').datepicker({ lang:'en', today: true, format: 'yy-mm-dd', theme: 'dark', callback: datepickerCallback } );								
});

function datepickerCallback(e, date)
{			
        document.getElementById('date_picker').value = date;
}
